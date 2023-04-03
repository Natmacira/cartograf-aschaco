<pre>
<?php

// item added with this approach: https://www.wikidata.org/wiki/Q117337907

require_once( __DIR__ . '/vendor/autoload.php' );

$username = 'lalala';
$password = 'lalala';

$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;
use Addwiki\Mediawiki\Api\Client\Action\Request\HasParameterAction;

$auth = new UserAndPassword($username, $password);
$api = new ActionApi('https://www.wikidata.org/w/api.php', $auth);

$label = 'My New Item';
$description = 'This is a description of my new item.';

$params = [
    'action' => 'wbeditentity',
    'new' => 'item',
    'data' => json_encode([
        'labels' => ['en' => ['language' => 'en', 'value' => $label]],
        'descriptions' => ['en' => ['language' => 'en', 'value' => $description]],
    ]),
	'token' => $api->getToken(),
    'format' => 'json',
];

$request = ActionRequest::simplePost('wbeditentity', $params);

die();

// make the API call
$data = $api->request($request);
var_dump( $data );


if ($data['success'] === 1) {
    $item_id = $data['entity']['id'];
    echo "Item added with ID: $item_id";
} else {
    echo "Failed to add item";
}

