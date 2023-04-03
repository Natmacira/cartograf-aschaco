<?php

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;

$auth = new UserAndPassword('username', 'password');
$api = new ActionApi('https://commons.wikimedia.org/w/api.php', $auth);

// Get the file data from the POST request
$image_data = file_get_contents($_FILES['image']['tmp_name']);
$image_name = $_FILES['image']['name'];

$params = [
    'action'   => 'upload',
    'filename' => $image_name,
    'comment'  => 'Upload by bot',
    'text'     => 'This is my new image',
    'file'     => $image_data,
    'token'    => $api->getToken(),
    'format'   => 'json',
];

$request = ActionRequest::simplePost('upload', $params);

$data = $api->request($request);

if (isset($data['upload']['result']) && $data['upload']['result'] == 'Success') {
    echo "Upload successful!";
} else {
    echo "Upload failed.";
}

