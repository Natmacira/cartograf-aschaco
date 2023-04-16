<pre>
<?php
$debugging = true;

// ?q wdt:P31/wdt:P279* wd:Q385994 búsqueda de bibliotecas especializadas
// ?q wdt:P2596/wdt:P279* wd:Q6122670 búsqueda de items de cultura maori
// https://wikishootme.toolforge.org/#lat=-38.26838272806484&lng=176.4137878501788&zoom=10&layers=wikidata_image,wikidata_no_image&sparql_filter=%3Fq%20wdt%3AP2596%2Fwdt%3AP279*%20wd%3AQ6122670&worldwide=1

// https://www.wikidata.org/wiki/Q117313340 =>Axion Energy

// https://www.wikidata.org/wiki/Q1542227 => Toba people
// https://www.wikidata.org/wiki/Q3099764 => Mocoví people
// https://www.wikidata.org/wiki/Q1284276 => Wichís

// item added with this approach: https://www.wikidata.org/wiki/Q117337907

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

$latitude     = !empty($_POST['lat']) ? $_POST['lat'] : '';
$longitude    = !empty($_POST['long']) ? $_POST['long'] : '';
$label        = !empty($_POST['title']) ? $_POST['title'] : '';
$description  = !empty($_POST['description']) ? $_POST['description'] : '';
$nation       = !empty($_POST['nation']) ? $_POST['nation'] : array();
$nation_q_ids = array();

foreach ($nation as $nation_code) {
	foreach ($q_ids[$nation_code] as $q_id) {
		$nation_q_ids[] = $q_id;
	}
}

if (
	empty($nation) ||
	empty($nation_q_ids) ||
	empty($latitude) ||
	empty($longitude) ||
	empty($label) ||
	empty($description)
) {
	header('Location: error.php');
	exit;
}


$p172 = array();

foreach ($nation_q_ids as $nation_q_id) {
	$p172[] = array(
		'mainsnak' => array(
			'snaktype' => 'value',
			'property' => 'P172',
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
		$allowed_file_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'image/webp'];

		if (in_array($file_type, $allowed_file_types)) {
			// Check if the file size is within the allowed limit
			$maxFile_size = 5 * 1024 * 1024; // 5 MB
			if ($file_size <= $maxFile_size) {
				// Move the uploaded file to the upload directory
				$file_in_localhost = move_uploaded_file($tmp_name, $uploadDir . $filename);
			} else {
				$upload_error = 'Error: File size exceeds the allowed limit.';
			}
		} else {
			$upload_error = 'Error: File type not allowed.';
		}
	} else {
		$upload_error = 'Error: An error occurred while uploading the file.';
	}

	if ($file_in_localhost) {
		echo __LINE__ . PHP_EOL;
		$auth               = new UserAndPassword($username, $password);
		echo __LINE__ . PHP_EOL;
		$commons_api        = new ActionApi('https://commons.wikimedia.org/w/api.php', $auth);

		$local_file_url     = APP_HOME_URL . $uploadDir . $filename;

		/////////////////////////
		///// Only for testing hardcode. simply delete these lines afterwards.
		$local_file_url     = 'https://www.nasa.gov/sites/default/files/styles/full_width_feature/public/thumbnails/image/louisianarice653_oli2_2023034_lrg.jpg';
		$filename           = 'louisianarice653_oli2_2023034_lrg.jpg';
		/////////////////////////

		$commons_error      = '';
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
				throw new Exception('Error uploading image');
			}
		} catch (Exception $e) {
			$commons_error = $e->getMessage();
			var_dump($commons_error);
		}

		echo __LINE__ . PHP_EOL;
		if ($commons_success || $debugging ) {
			var_dump($result);
			// $commons_file_url   = $result['upload']['imageinfo']['descriptionurl'];
			// $commons_upload_url = $result['upload']['imageinfo']['url'];
			$commons_file_url   = 'https://commons.wikimedia.org/wiki/File:Louisianarice653_oli2_2023034_lrg.jpg';
			$commons_upload_url = 'https://upload.wikimedia.org/wikipedia/commons/d/dd/Louisianarice653_oli2_2023034_lrg.jpg';

			$auth = new UserAndPassword($username, $password);
			echo __LINE__ . PHP_EOL;
			$api  = new ActionApi('https://www.wikidata.org/w/api.php', $auth);

			echo __LINE__ . PHP_EOL;

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
						// P172 statement to specify that the item belongs to an indigenous group
						'P172' => $p172,
						// P2596 is the property for "culture"
						'P2596' => $p2596,
						'P18' => [
							[
								'mainsnak' => [
									'snaktype' => 'value',
									'property' => 'P18',
									'datavalue' => [
										'value' => $filename, // Image.jpg
										'type' => 'string',
									],
									'datatype' => 'commonsMedia',
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
} else {
	echo __LINE__ . PHP_EOL;
	$auth = new UserAndPassword($username, $password);
	echo __LINE__ . PHP_EOL;
	$api  = new ActionApi('https://www.wikidata.org/w/api.php', $auth);
	echo __LINE__ . PHP_EOL;

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
				// P172 statement to specify that the item belongs to an indigenous group
				'P172' => $p172,
				// P2596 is the property for "culture"
				'P2596' => $p2596,
			],
		]),
		'token' => $api->getToken(),
		'format' => 'json',
	];
}


if ( ! empty($params )) {
	$request = ActionRequest::simplePost('wbeditentity', $params);

	try {
		$data = $api->request($request);
		var_dump($data);
	} catch (Exception $e) {
		$commons_error = $e->getMessage();
		var_dump($commons_error);
	}
}

if ($data['success'] === 1) {
	$item_id = $data['entity']['id'];
	echo 'Item added with ID: https://www.wikidata.org/wiki/' . $item_id;
} else {
	echo "Failed to add item";
}
