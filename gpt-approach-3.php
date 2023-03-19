<?php
require_once 'vendor/autoload.php';

use MediaWiki\OAuthClient\ClientConfig;
use MediaWiki\OAuthClient\Token;
use MediaWiki\OAuthClient\Consumer;
use MediaWiki\OAuthClient\Client;
use MediaWiki\OAuthClient\TokenNotFoundException;

// Set up the OAuth client configuration
$config = new ClientConfig( [
    'consumer_key'    => '1bf802ebc6a7dcbfc44f34dsa6f571f8998',
    'consumer_secret' => 'd17df20b222312052b21da58f8f0b7ee017fb2bba82b',
    'base_url'        => 'https://www.example.com/w/api.php',
] );

// Set up the OAuth client with the provided credentials
$client = new Client( $config );
$consumer = new Consumer( $config->getConsumerKey(), $config->getConsumerSecret() );
$token = new Token( 'b25a6d0ffa329gfdsb64c09b01ac0ff4bb5b', '342725asfce950eas100c252ce380f885b71c2578ed4' );

// Make an API call to create a new item
try {
    $client->setToken( $token );
    $params = [
        'action' => 'wbeditentity',
        'format' => 'json',
        'new' => 'item',
        'data' => json_encode( [
            'labels' => [
                'en' => [
                    'language' => 'en',
                    'value' => 'Example Item',
                ],
            ],
        ] ),
    ];
    $response = $client->makeOAuthCall( $consumer, 'POST', $config->getBaseUrl(), $params );
    $result = json_decode( $response['body'], true );
    if ( isset( $result['success'] ) ) {
        echo "New item created successfully.\n";
    } else {
        echo "Failed to create new item.\n";
    }
} catch ( TokenNotFoundException $ex ) {
    echo "OAuth token not found.\n";
} catch ( Exception $ex ) {
    echo "API request failed: " . $ex->getMessage() . "\n";
}