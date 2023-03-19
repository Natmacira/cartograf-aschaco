<?php
require_once __DIR__ . '/vendor/autoload.php'; // Path to the MediaWiki\OAuthClient library

$consumerKey = '1bf802ebc6a7dcbfc44f346f571f8998';
$consumerSecret = 'd17df20b22052b21da58f8f0b7ee017fb2bba82b';
$accessToken = 'b25a6d0ffa329b64c09b01ac0ff4bb5b';
$accessSecret = '342725fce950e100c252ce380f885b71c2578ed4';

use MediaWiki\OAuthClient\ClientConfig;
use MediaWiki\OAuthClient\Token;
use MediaWiki\OAuthClient\Client;

// Set up the OAuth client configuration
$config = new ClientConfig( 'https://www.wikidata.org/w/index.php?title=Special:OAuth', $consumerKey, $consumerSecret );

// Create the token object
$token = new Token( $accessToken, $accessSecret );

// Configure the OAuth client with the URL and consumer details.

$config->setUserAgent( 'DemoApp MediaWikiOAuthClient/1.0' );
$client = new Client( $config );

// Set up the API call parameters
$params = array(
    'action' => 'wbeditentity',
    'format' => 'json',
    'new' => 'item',
    'data' => json_encode( array(
        'labels' => array(
            'en' => array(
                'language' => 'en',
                'value' => 'Test Item'
            )
        )
    ) )
);

// Make the makeOAuthCall call to 'https://www.wikidata.org/w/api.php'
$result = $client->makeOAuthCall( $token, 'https://www.wikidata.org/w/api.php', $params );



// Output the result
echo $result;
