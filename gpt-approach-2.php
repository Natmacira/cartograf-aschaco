<!--
echo '<pre>'; print_r($data); echo '</pre>';
$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';
-->

<?php
// Define the endpoint URL for Wikidata API
$endpointUrl = 'https://www.wikidata.org/w/api.php';

// Define the API action to log in to Wikidata API
$action = 'login';

// Define the username and password for the user
$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';

// Define the parameters for the login API request
$params = array(
    'action' => $action,
    'lgname' => $username,
    'lgpassword' => $password,
    'format' => 'json'
);

// Send the login API request and get the response
$ch = curl_init($endpointUrl);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response and get the login result
$data = json_decode($response, true);
echo '<pre>'; print_r($data); echo '</pre>';

$loginResult = $data['login']['result'];

// If the login was successful, get a CSRF token for the user
if ($loginResult == 'Success') {
    // Get a CSRF token for the user
    $action = 'login';
    $params = array(
        'meta' => 'tokens',
        'type' => 'csrf',
        'format' => 'json'
    );
    $cookies = array('Token' => $data['login']['token']);
    $headers = array('Content-Type: application/x-www-form-urlencoded');
    $ch = curl_init($endpointUrl);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_COOKIE, http_build_query($cookies, '', '; '));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON response and get the CSRF token
    $data = json_decode($response, true);
	echo '<pre>'; print_r($data); echo '</pre>';
    $csrfToken = $data['query']['tokens']['csrftoken'];

    // Output the CSRF token
    echo "CSRF token: $csrfToken\n";
} else {
    // Output an error message
    $errorMessage = $data['login']['reason'];
    echo "Login failed: $errorMessage\n";
}



//---------------------
// // Define the API action to get a CSRF token
// $action = 'query';

// // Define the parameters for the API request
// $params = array(
//     'action' => $action,
//     'meta' => 'tokens',
//     'type' => 'csrf',
//     'format' => 'json'
// );

// // Send the API request and get the response
// $ch = curl_init($endpointUrl);
// curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($ch);
// curl_close($ch);

// // Decode the JSON response and get the CSRF token
// $data = json_decode($response, true);

// echo '<pre>'; print_r($data); echo '</pre>';

// $csrfToken = $data['query']['tokens']['csrftoken'];

// // Output the CSRF token
// echo "CSRF token: $csrfToken\n";

//---------------------


// Define the endpoint URL for Wikidata API
$endpointUrl = 'https://www.wikidata.org/w/api.php';

// Define the API action to create a new item
$action = 'wbeditentity';

// Define the parameters for the API request
$params = array(
    'action' => $action,
    'new' => 'item',
    'data' => json_encode(array(
        'labels' => array(
            'en' => array(
                'language' => 'en',
                'value' => 'My Monument'
            )
        ),
        'descriptions' => array(
            'en' => array(
                'language' => 'en',
                'value' => 'A monument created via Wikidata API'
            )
        ),
        'claims' => array(
            'P31' => array(
                array(
                    'mainsnak' => array(
                        'snaktype' => 'value',
                        'property' => 'P31',
                        'datavalue' => array(
                            'value' => array(
                                'id' => 'Q4989906', // instance of monument
                                'entity-type' => 'item',
                                'numeric-id' => 4989906
                            ),
                            'type' => 'wikibase-entityid'
                        )
                    ),
                    'type' => 'statement',
                    'rank' => 'normal'
                )
            ),
            'P625' => array(
                array(
                    'mainsnak' => array(
                        'snaktype' => 'value',
                        'property' => 'P625',
                        'datavalue' => array(
                            'value' => array(
                                'latitude' => 51.507222, // latitude of monument
                                'longitude' => -0.1275, // longitude of monument
                                'altitude' => null,
                                'precision' => 0.0001,
                                'globe' => 'http://www.wikidata.org/entity/Q2'
                            ),
                            'type' => 'globecoordinate'
                        )
                    ),
                    'type' => 'statement',
                    'rank' => 'normal'
                )
            ),
            'P18' => array(
                array(
                    'mainsnak' => array(
                        'snaktype' => 'value',
                        'property' => 'P18',
                        'datavalue' => array(
                            'value' => 'https://www.cronista.com/files/image/365/365600/614b613bae510_360_480!.jpg', // file name of monument image
                            'type' => 'string'
                        )
                    ),
                    'type' => 'statement',
                    'rank' => 'normal'
                )
            )
        )
    )),
    'format' => 'json',
    'token' => $csrfToken
);

// Send the API request and get the response
$ch = curl_init($endpointUrl);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response and get the new item ID
$data = json_decode($response, true);

echo '<pre>';
print_r($data);
echo '</pre>';

$itemId = $data['entity']['id'];

// Output the new item ID
echo "Created item: $itemId\n";
