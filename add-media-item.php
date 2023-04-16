<pre>
<?php

// Nota: las imágenes deben estar en un servidor que esté en la whitelist de Commons.
// https://commons.wikimedia.org/wiki/MediaWiki:Copyupload-allowed-domains

require_once( __DIR__ . '/vendor/autoload.php' );
require_once 'functions.php';

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;

$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';

$auth = new UserAndPassword($username, $password);
$api  = new ActionApi('https://commons.wikimedia.org/w/api.php', $auth);

$image_url = 'https://www.nasa.gov/sites/default/files/styles/full_width_feature/public/thumbnails/image/tulareflooding653_oli_2023088_lrg.jpg';
$image_name = basename($image_url);

$params = [
    'action' => 'upload',
    'filename' => $image_name,
    'comment' => 'Heavy Rain, Snow Revive Tulare Lake',
    'text' => 'Floodwater (dark blue) stands out against the vegetation in agricultural fields around Tulare Lake near Corcoran, California, in this enhanced color image taken by Landsat 8 on March 29, 2023.',
    'url' => $image_url,
    'token' => $api->getToken(),
    'format' => 'json',
];

//////////////////////////////////////
$image_url = 'https://www.nasa.gov/sites/default/files/styles/full_width/public/thumbnails/image/52532133869_fc0348c024_o.jpeg';
$image_name = basename($image_url);

$params = [
    'action' => 'upload',
    'filename' => $image_name,
    'comment' => 'NASA to Provide Live Coverage of SpaceX Cargo Craft Station Departure',
    'text' => 'The SpaceX Dragon cargo craft, loaded with over 7,700 pounds of science, supplies, and cargo, approaches the International Space Station for a docking 264 miles above the Atlantic ocean in between South America and Africa.',
    'url' => $image_url,
    'token' => $api->getToken(),
    'format' => 'json',
];

//////////////////////////////////////
$image_url = 'https://www.nasa.gov/sites/default/files/styles/full_width_feature/public/thumbnails/image/hubble_j0204_potw2315a.jpg';
$image_name = basename($image_url);

$params = [
    'action' => 'upload',
    'filename' => $image_name,
    'comment' => 'Hubble Spots a Galaxy with Tendrils',
    'text' => 'This image taken with the NASA/ESA Hubble Space Telescope shows JO204, a ‘jellyfish galaxy’ so named for the bright tendrils of gas that appear in this image as drifting lazily below JO204’s bright central bulk. The galaxy lies almost 600 million light-years away in the constellation Sextans.',
    'url' => $image_url,
    'token' => $api->getToken(),
    'format' => 'json',
];



$request = new ActionRequest();
$request->setMethod('POST');
$request->setPath('upload');
$request->addParams($params);

$success = false;

try {
	$result = $api->request($request);

	if ( isset( $result['upload']['result'] ) && 'Success' === $result['upload']['result'] ) {
		$success = true;
	} else {
		throw new Exception( 'Error uploading image' );
	}
} catch ( Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}

if ( $success ) {
	echo 'Image uploaded successfully';

	$commons_file_url   = $result['upload']['imageinfo']['descriptionurl'];
	$commons_upload_url = $result['upload']['imageinfo']['url'];
} else {
	echo 'Image upload failed';
}

echo '<br><br>';
var_dump( $result );

