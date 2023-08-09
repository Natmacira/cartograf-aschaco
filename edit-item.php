<?php
require_once(__DIR__ . '/vendor/autoload.php');
require_once 'functions.php';

$username = WIKI_USER;
$password = WIKI_PASSWORD;

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;

$label            = !empty($_POST['title']) ? $_POST['title'] : '';
$wikidata_item_id = !empty($_POST['wikidata_item_id']) ? $_POST['title'] : '';
$filename         = '';
$commons_error    = '';
$wikidata_error   = '';

if (
	!empty($label) &&
	!empty($wikidata_item_id)
) {

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

				$p18_claim = [
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
				];

				$params = [
					'action' => 'wbcreateclaim',
					'entity' => $wikidata_item_id,
					'snaktype' => 'value',
					'property' => 'P18',
					'value' => json_encode([
						'entity-type' => 'media',
						'id' => $filename,
					]),
					'token' => $api->getToken(),
					'format' => 'json',
				];
			}
		}
	}

	if (!empty($params)) {
		$request = ActionRequest::simplePost('wbcreateclaim', $params);

		try {
			$data = $api->request($request);

			if (isset($data['claim']['id'])) {
				$claim_id = $data['claim']['id'];
				echo 'Property added with claim ID: ' . $claim_id;
			} else {
				$wikidata_error = 'Wikidata rechazó la propiedad.';
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
		"' . $mysqli->real_escape_string($wikidata_item_id) . '",
		"' . $mysqli->real_escape_string($date) . '",
		"' . $mysqli->real_escape_string($commons_error) . '",
		"' . $mysqli->real_escape_string($wikidata_error) . '")';

	$insert = mysqli_query($mysqli, $sql);

	mysqli_close($mysqli);
}

if (empty($claim_id)) {
	$message = 'Ha habido un error en el proceso. Por favor, verifique que ha completado todos los campos requeridos.';
} else {
	$message = 'Se ha cargado con éxito la entrada.';
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
