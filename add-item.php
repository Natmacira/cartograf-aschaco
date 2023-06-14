<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once 'functions.php';

	$q_ids = array(
		'qo' => array('Q1542227'),
		'wi' => array('Q1284276', 'Q3027047'),
		'mo' => array('Q3099764', 'Q3027906'),
	);

$username = WIKI_USER;
$password = WIKI_PASSWORD;

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;

$latitude       = !empty($_POST['lat']) ? $_POST['lat'] : '';
$longitude      = !empty($_POST['long']) ? $_POST['long'] : '';
$label          = !empty($_POST['title']) ? $_POST['title'] : '';
$description    = !empty($_POST['description']) ? $_POST['description'] : '';
$filename       = '';
$new_item_id    = '';
$nation         = !empty($_POST['nation']) ? $_POST['nation'] : array();
$nation_q_ids   = array();
$commons_error  = '';
$wikidata_error = '';

foreach ($nation as $nation_code) {
	foreach ($q_ids[$nation_code] as $q_id) {
		$nation_q_ids[] = $q_id;
	}
}

if (
	!empty($nation) &&
	!empty($nation_q_ids) &&
	!empty($latitude) &&
	!empty($longitude) &&
	!empty($label) &&
	!empty($description)
) {

	$p2596 = array();

	foreach ($nation_q_ids as $nation_q_id) {
		$p2596[] = array(
			'mainsnak' => array(
				'snaktype' => 'value',
				'property' => 'P2596',
				'datavalue' => array(
					'type' => 'wikibase-entityid',
					'value' => array(
						'entity-type' => 'item',
						'id' => $nation_q_id,
					),
				),
			),
			'type' => 'statement',
			'rank' => 'normal',
		);
	}

	if (isset($_FILES['image'])) {
		$file_in_localhost = false;

		if (!$_FILES['image']['error']) {
			$file_type = $_FILES['image']['type'];
			$file_size = $_FILES['image']['size'];
			$tmp_name  = $_FILES['image']['tmp_name'];
			$extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
			$filename  = chaco_sanitize_title($label) . '.' . $extension;

			$uploadDir          = 'uploads/';
			$allowed_file_types = [
				'application/pdf',
				'audio/mpeg',
				'audio/ogg',
				'audio/wav',
				'image/gif',
				'image/jpeg',
				'image/png',
				'image/svg+xml',
				'image/tiff',
				'image/webp',
				'video/avi',
				'video/mp4',
				'video/mpeg',
				'video/ogg',
				'video/webm',
			];

			if (in_array($file_type, $allowed_file_types)) {
				// Check if the file size is within the allowed limit
				$maxFile_size = 5 * 1024 * 1024; // 5 MB
				if ($file_size <= $maxFile_size) {
					// Move the uploaded file to the upload directory
					$file_in_localhost = move_uploaded_file($tmp_name, $uploadDir . $filename);
				} else {
					$commons_error = 'El archivo excede el límite de 5M.';
				}
			} else {
				$commons_error = 'El archivo tiene una extensión no permitida: ' . $extension;
			}
		} else {
			$commons_error = 'Error en la carga del archivo al servidor local.';
		}

		if ($file_in_localhost) {
			$auth               = new UserAndPassword($username, $password);
			$commons_api        = new ActionApi('https://commons.wikimedia.org/w/api.php', $auth);
			$local_file_url     = APP_HOME_URL . $uploadDir . $filename;
			$commons_file_url   = '';
			$commons_upload_url = '';

			$params = [
				'action'   => 'upload',
				'filename' => $filename,
				'comment'  => $label,
				'text'     => $description,
				'url'      => $local_file_url,
				'token'    => $commons_api->getToken(),
				'format'   => 'json',
			];

			$request = new ActionRequest();
			$request->setMethod('POST');
			$request->setPath('upload');
			$request->addParams($params);

			$commons_success = false;

			try {
				$result = $commons_api->request($request);

				if (isset($result['upload']['result']) && 'Success' === $result['upload']['result']) {
					$commons_success = true;
				} else {
					throw new Exception('Wiki Commons rechazó el archivo.');
				}
			} catch (Exception $e) {
				$commons_error = $e->getMessage();
			}

			if ($commons_success) {
				$commons_file_url   = $result['upload']['imageinfo']['descriptionurl'];
				$commons_upload_url = $result['upload']['imageinfo']['url'];

				$auth = new UserAndPassword($username, $password);
				$api  = new ActionApi('https://www.wikidata.org/w/api.php', $auth);

				$p31 = ''; // P31: instance of

				if (
					$file_type === 'audio/mpeg' ||
					$file_type === 'audio/ogg' ||
					$file_type === 'audio/wav'
				) {
					$p31 = 'Q3302947'; // Grabación sonora (https://www.wikidata.org/wiki/Q3302947)
				} elseif (
					$file_type === 'image/gif' ||
					$file_type === 'image/jpeg' ||
					$file_type === 'image/png' ||
					$file_type === 'image/svg+xml' ||
					$file_type === 'image/tiff' ||
					$file_type === 'image/webp'
				) {
					$p31 = 'Q11633'; // Fotografía (https://www.wikidata.org/wiki/Q11633)
				} elseif (
					$file_type === 'video/avi' ||
					$file_type === 'video/mp4' ||
					$file_type === 'video/mpeg' ||
					$file_type === 'video/ogg' ||
					$file_type === 'video/webm'
				) {
					$p31 = 'Q34508'; // Video (https://www.wikidata.org/wiki/Q34508)
				} else {
					$p31 = 'Q694975'; // Documento electrónico (https://www.wikidata.org/wiki/Q694975)
				}

				$params = [
					'action' => 'wbeditentity',
					'new' => 'item',
					'data' => json_encode([
						'labels' => ['es' => ['language' => 'es', 'value' => $label]],
						'descriptions' => ['es' => ['language' => 'es', 'value' => $description]],
						// Add the P625 property to specify the coordinates
						'claims' => [
							'P625' => [
								[
									'mainsnak' => [
										'snaktype' => 'value',
										'property' => 'P625',
										'datavalue' => [
											'type' => 'globecoordinate',
											'value' => [
												'latitude' => $latitude,
												'longitude' => $longitude,
												'precision' => 0.0001,
												'globe' => 'http://www.wikidata.org/entity/Q2',
											],
										],
									],
									'type' => 'statement',
									'rank' => 'normal',
								],
							],
							// P2596 is the property for "culture"
							'P2596' => $p2596,
							'P195' => [
								[
									'mainsnak' => [
										'snaktype' => 'value',
										'property' => 'P195',
										'datavalue' => [
											'value' => [
												'entity-type' => 'item',
												'id' => 'Q117554123', // Cartografías Abiertas
											],
											'type' => 'wikibase-entityid',
										],
									],
									'type' => 'statement',
									'rank' => 'normal',
								],
							],
							'P18' => [
								[
									'mainsnak' => [
										'snaktype' => 'value',
										'property' => 'P18',
										'datavalue' => [
											'value' => $filename, // image.jpg || file.pdf
											'type' => 'string',
										],
										'datatype' => 'commonsMedia',
									],
									'type' => 'statement',
									'rank' => 'normal',
								],
							],
							'P31' => [
								[
									'mainsnak' => [
										'snaktype' => 'value',
										'property' => 'P31',
										'datavalue' => [
											'value' => [
												'entity-type' => 'item',
												'id' => $p31,
											],
											'type' => 'wikibase-entityid',
										],
									],
									'type' => 'statement',
									'rank' => 'normal',
								],
							],
						],
					]),
					'token' => $api->getToken(),
					'format' => 'json',
				];
			}
		}
	}

	if ( ! isset( $_FILES['image'] ) || empty( $commons_success ) ) {
		$auth = new UserAndPassword($username, $password);
		$api  = new ActionApi('https://www.wikidata.org/w/api.php', $auth);

		$params = [
			'action' => 'wbeditentity',
			'new' => 'item',
			'data' => json_encode([
				'labels' => ['es' => ['language' => 'es', 'value' => $label]],
				'descriptions' => ['es' => ['language' => 'es', 'value' => $description]],
				// Add the P625 property to specify the coordinates
				'claims' => [
					'P625' => [
						[
							'mainsnak' => [
								'snaktype' => 'value',
								'property' => 'P625',
								'datavalue' => [
									'type' => 'globecoordinate',
									'value' => [
										'latitude' => $latitude,
										'longitude' => $longitude,
										'precision' => 0.0001,
										'globe' => 'http://www.wikidata.org/entity/Q2',
									],
								],
							],
							'type' => 'statement',
							'rank' => 'normal',
						],
					],
					// P2596 is the property for "culture"
					'P2596' => $p2596,
					'P195' => [
						[
							'mainsnak' => [
								'snaktype' => 'value',
								'property' => 'P195',
								'datavalue' => [
									'value' => [
										'entity-type' => 'item',
										'id' => 'Q117554123', // Cartografías Abiertas
									],
									'type' => 'wikibase-entityid',
								],
							],
							'type' => 'statement',
							'rank' => 'normal',
						],
					],
				],
			]),
			'token' => $api->getToken(),
			'format' => 'json',
		];
	}

	if (!empty($params)) {
		$request = ActionRequest::simplePost('wbeditentity', $params);

		try {
			$data = $api->request($request);

			if ($data['success'] === 1) {
				$new_item_id = $data['entity']['id'];
				echo 'Item added with ID: https://www.wikidata.org/wiki/' . $new_item_id;
			} else {
				$wikidata_error = 'Wikidata rechazó el item.';
			}
		} catch (Exception $e) {
			$wikidata_error = $e->getMessage();
		}
	}

	$host     = APP_DB_HOST;
	$username = APP_DB_USER;
	$password = APP_DB_PASSWORD;
	$dbname   = APP_DB_NAME;

	$mysqli = new mysqli($host, $username, $password, $dbname);

	if ($mysqli->connect_errno) {
		exit();
	}

	$date = date('Y-m-d h:i:s');

	$sql = 'INSERT INTO entries (commons_filename, wikidata_id, date, commons_error, wikidata_error) VALUES
		("' . $mysqli->real_escape_string($filename) . '",
		"' . $mysqli->real_escape_string($new_item_id) . '",
		"' . $mysqli->real_escape_string($date) . '",
		"' . $mysqli->real_escape_string($commons_error) . '",
		"' . $mysqli->real_escape_string($wikidata_error) . '")';

	$insert = mysqli_query($mysqli, $sql);

	mysqli_close($mysqli);
}

if (empty($new_item_id)) {
	$message = 'Ha habido un error en el proceso. Por favor, verifique que ha completado todos los campos requeridos.';
} else {
	$message = 'Se ha cargado con éxito la entrada. El código de la misma es: ' . $new_item_id;
	if ( ! empty( $commons_error ) ) {
		$message .= '<br>Se ha producido un error al subir el archivo a Wikimedia Commons. El dominio no está en la lista de dominios permitidos.';
	}
}

$body_class = 'submission-result';

require_once 'header.php';
?>
<section class="message">
	<h2><?php echo $message; ?></h2>

	<a href="mapa.php">Volver al mapa</a>
</section>

<?php
require_once 'footer.php';
