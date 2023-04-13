<pre>
<?php
require_once( __DIR__ . '/vendor/autoload.php' );

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

$request = new ActionRequest();
$request->setMethod('POST');
$request->setPath('upload');
$request->addParams($params);

$result = $api->request($request);
var_dump( $result );

/*
require_once( __DIR__ . '/vendor/autoload.php' );

$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';
// $username = 'CartografiasChaco';
// $password = 'yCCKwh9zeg9rz68k4H42';

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;
// use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;
// use Addwiki\Mediawiki\Api\Client\Action\Request\HasParameterAction;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

$auth = new UserAndPassword($username, $password);
$api  = new ActionApi('https://commons.wikimedia.org/w/api.php', $auth);

$image_data = file_get_contents($_FILES['image']['tmp_name']);
$image_name = $_FILES['image']['name'];


// $image_data = curl_file_create($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);

$params = [
    'action'   => 'upload',
    'filename' => $image_name,
    'comment'  => 'This is a photogrpah of an Axion Energy station.',
    'text'     => 'Axion Energy station',
    'file'     => $image_data,
    'token'    => $api->getToken(),
    'format'   => 'json',
];

// $request = ActionRequest::simplePost('upload', $params);

// var_dump( $request );

// $request = new ActionRequest();
// $request->setMethod('POST');
// $request->setPath('upload');
// $request->addParams($params);
// $result = $api->request($request);

$client = new Client();
$response = $client->post('https://commons.wikimedia.org/w/api.php', [
    RequestOptions::MULTIPART => array_map(function ($key, $value) {
        return ['name' => $key, 'contents' => $value];
    }, array_keys($params), $params),
]);

$result = json_decode($response->getBody()->getContents(), true);

var_dump( $result );
die();
/*use Addwiki\Mediawiki\Api\Client\MediawikiApi;
// use Addwiki\Mediawiki\Api\MediawikiApi;
use Addwiki\Mediawiki\Api\Service\Uploads;

$api = MediawikiApi::newFromPage('https://commons.wikimedia.org/wiki/Main_Page');
$api->login(new ApiUser('username', 'password'));

$uploads = new Uploads($api);

$result = $uploads->upload(
    $image_name,
    file_get_contents($_FILES['image']['tmp_name']),
    '',
    ''
);


die();
use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;

// print files global variable
// print_r($_FILES);

// print_r($_REQUEST);


$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';

$auth = new UserAndPassword( $username, $password);
$api  = new ActionApi('https://commons.wikimedia.org/w/api.php', $auth);

// Get the file data from the POST request
$image_data = file_get_contents($_FILES['image']['tmp_name']);
$image_name = $_FILES['image']['name'];

$image_data = curl_file_create($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name']);
$params = [
    'action'   => 'upload',
    'filename' => $image_name,
    'comment'  => 'Upload by bot',
    'text'     => 'Axion energy',
    'file'     => $image_data,
    'token'    => $api->getToken(),
    'format'   => 'json',
];

// make isMultipart true in params
$params['multipart'] = true;


$request = ActionRequest::simplePost('upload', $params);

var_dump( $request );

$data = $api->request($request);
var_dump( $data );

if (isset($data['upload']['result']) && $data['upload']['result'] == 'Success') {
    echo "Upload successful!";
} else {
    echo "Upload failed.";
}

*/