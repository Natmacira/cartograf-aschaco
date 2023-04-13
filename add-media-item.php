<pre>
<?php

require_once( __DIR__ . '/vendor/autoload.php' );

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

