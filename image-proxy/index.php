<?php
// 'https://cartografiaschaco.altcooperativa.com/image-proxy/?z={z}&x={x}&y={y}.png'
// if $_GET['y'] has an extension, remove it
if (strpos($_GET['y'], '.') !== false) {
	$_GET['y'] = substr($_GET['y'], 0, strpos($_GET['y'], '.'));
}

if (
	empty($_GET['z']) || ! is_numeric($_GET['z'] ) ||
	empty($_GET['x']) || ! is_numeric($_GET['x'] ) ||
	empty($_GET['y']) || ! is_numeric($_GET['y'] )
) {
	die();
}

$image_url = 'https://maps.wikimedia.org/osm-intl/' . $_GET['z'] . '/' . $_GET['x'] . '/' . $_GET['y'] . '.png';
// Set the user agent and headers to send with the request
$user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36';
$headers = [
    'Accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
    'Accept-Encoding: gzip, deflate, br',
    'Accept-Language: es-419,es;q=0.9',
    'Cache-Control: no-cache',
    'Pragma: no-cache',
    'Referer: https://localhost/',
    'Sec-CH-UA: "Chromium";v="112", "Google Chrome";v="112", "Not:A-Brand";v="99"',
    'Sec-CH-UA-Mobile: ?0',
    'Sec-CH-UA-Platform: "Windows"',
    'Sec-Fetch-Dest: image',
    'Sec-Fetch-Mode: no-cors',
    'Sec-Fetch-Site: cross-site'
];

// Use cURL to fetch the image data
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $image_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$image_data = curl_exec($ch);
curl_close($ch);

// Set the appropriate content type header for the image
header('Content-Type: image/png');

// Output the image data
echo $image_data;
die();
