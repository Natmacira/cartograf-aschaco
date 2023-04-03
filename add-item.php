<?php

// https://www.wikidata.org/wiki/Q1542227 => Toba people
// https://www.wikidata.org/wiki/Q3099764 => Mocoví people
// https://www.wikidata.org/wiki/Q1284276 => Wichís

// item added with this approach: https://www.wikidata.org/wiki/Q117337907

require_once( __DIR__ . '/vendor/autoload.php' );

$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';

use Addwiki\Mediawiki\Api\Client\Auth\UserAndPassword;
use Addwiki\Mediawiki\Api\Client\Action\ActionApi;
use Addwiki\Mediawiki\Api\Client\Action\Request\ActionRequest;
// use Addwiki\Mediawiki\Api\Client\Action\Request\HasParameterAction;

$auth = new UserAndPassword($username, $password);
$api = new ActionApi('https://www.wikidata.org/w/api.php', $auth);

$label = 'My New Item';
$description = 'This is a description of my new item.';

$latitude = 40.748817;
$longitude = -73.985428;

$params = [
    'action' => 'wbeditentity',
    'new' => 'item',
    'data' => json_encode([
        'labels' => ['en' => ['language' => 'en', 'value' => $label]],
        'descriptions' => ['en' => ['language' => 'en', 'value' => $description]],
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
			// Add a P172 statement to specify that the item belongs to an indigenous group
            'P172' => [
                [
                    'mainsnak' => [
                        'snaktype' => 'value',
                        'property' => 'P172', // P172 is the property for "member of"
                        'datavalue' => [
                            'type' => 'wikibase-entityid',
                            'value' => [
                                'entity-type' => 'item',
                                'id' => 'QID_OF_INDIGENOUS_GROUP_ITEM',
                            ],
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

