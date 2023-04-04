<?php

// ?q wdt:P31/wdt:P279* wd:Q385994 búsqueda de bibliotecas especializadas
// ?q wdt:P2596/wdt:P279* wd:Q6122670 búsqueda de items de cultura maori
// https://wikishootme.toolforge.org/#lat=-38.26838272806484&lng=176.4137878501788&zoom=10&layers=wikidata_image,wikidata_no_image&sparql_filter=%3Fq%20wdt%3AP2596%2Fwdt%3AP279*%20wd%3AQ6122670&worldwide=1

// https://www.wikidata.org/wiki/Q117313340 =>Axion Energy

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

// read the input from the POST request: lat, long, title, description
// $latitude = 40.748817;
// $longitude = -73.985428;
$latitude    = $_POST['lat'];
$longitude   = $_POST['long'];
$label       = $_POST['title'];
$description = $_POST['description'];

$nation = $_POST['nation'];

if ($nation == 'qo') {
	$group = 'Q1542227';
} else if ($nation == 'wi') {
	$group = 'Q1284276';
} else if ($nation == 'mo') {
	$group = 'Q3099764';
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
			// Add a P172 statement to specify that the item belongs to an indigenous group
            /*'P172' => [
                [
                    'mainsnak' => [
                        'snaktype' => 'value',
                        'property' => 'P172', // P172 is the property for "member of"
                        'datavalue' => [
                            'type' => 'wikibase-entityid',
                            'value' => [
                                'entity-type' => 'item',
                                'id' => $group,
                            ],
                        ],
                    ],
                    'type' => 'statement',
                    'rank' => 'normal',
                ],
            ],*/
            'P2596' => [
                [
                    'mainsnak' => [
                        'snaktype' => 'value',
                        'property' => 'P2596', // P2596 is the property for "culture"
                        'datavalue' => [
                            'type' => 'wikibase-entityid',
                            'value' => [
                                'entity-type' => 'item',
                                'id' => $group,
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

// make the API call
$data = $api->request($request);
var_dump( $data );


if ($data['success'] === 1) {
    $item_id = $data['entity']['id'];
    echo 'Item added with ID: https://www.wikidata.org/wiki/' . $item_id;
} else {
    echo "Failed to add item";
}

