<?php

require dirname(__FILE__) . '/vendor/autoload.php';

use MediaWiki\OAuthClient\Consumer;
use MediaWiki\OAuthClient\Token;
use MediaWiki\OAuthClient\Request;
use MediaWiki\OAuthClient\SignatureMethod\HmacSha1;

require_once 'credentials.php';

$apiParams = array();

$consumer = new Consumer( $consumerKey, $consumerSecret );
$accessToken = new Token( $accessToken, $accessSecret );
$request = Request::fromConsumerAndToken( $consumer, $accessToken, 'GET', 'https://en.wikipedia.org/w/api.php', $apiParams );
$request->signRequest( new HmacSha1(), $consumer, $accessToken );
// $authorizationHeader = $request->toHeader();
// Then use this header on a request, for example:
$authenticationHeader = array();

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => 'https://en.wikipedia.org/w/api.php',
    CURLOPT_USERAGENT => 'My_bot',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query($apiParams),
    CURLOPT_HTTPHEADER => $authenticationHeader,
]);

$result = curl_exec($ch);

echo $result;