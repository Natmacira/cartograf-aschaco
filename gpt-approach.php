<?php

// change all the ini settings for PHP to show errors
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);


/**
 * Class for connecting to Wikidata's API and creating new monuments.
 * @package WikidataMonumentAPI
 */
class WikidataMonumentAPI {

    /**
     * The URL of Wikidata's API.
     * @var string
     */
    private $apiUrl;

    /**
     * The username for authenticating with Wikidata's API.
     * @var string
     */
    private $username;

    /**
     * The password for authenticating with Wikidata's API.
     * @var string
     */
    private $password;

	/**
	 * The edit token for making authenticated API calls.
	 *
	 * @var string|null
	 */
	// private $editToken;

    /**
     * WikidataMonumentAPI constructor.
     * @param string $username The username for authenticating with Wikidata's API.
     * @param string $password The password for authenticating with Wikidata's API.
     */
    public function __construct($username, $password) {
        $this->apiUrl = 'https://www.wikidata.org/w/api.php';
        $this->username = $username;
        $this->password = $password;
    }

	/**
     * Creates a new monument in Wikidata.
     * @param string $name The name of the monument.
     * @param float $latitude The latitude of the monument's location.
     * @param float $longitude The longitude of the monument's location.
     * @param string $pictureUrl The URL of the picture of the monument.
     * @return bool|string The ID of the newly created monument if successful, or false if unsuccessful.
     */
    public function createNewMonument($name, $latitude, $longitude, $pictureUrl) {
        $postData = [
            'action' => 'wbcreateentity',
            'format' => 'json',
            'newitem' => 'item',
            'data' => json_encode([
                'labels' => [
                    'en' => [
                        'language' => 'en',
                        'value' => $name
                    ]
                ],
                'descriptions' => [
                    'en' => [
                        'language' => 'en',
                        'value' => 'Monument'
                    ]
                ],
                'claims' => [
                    'P31' => [
                        [
                            'mainsnak' => [
                                'snaktype' => 'value',
                                'property' => 'P31',
                                'datavalue' => [
                                    'value' => [
                                        'entity-type' => 'item',
                                        'numeric-id' => '19842198'
                                    ],
                                    'type' => 'wikibase-entityid'
                                ]
                            ],
                            'type' => 'statement',
                            'rank' => 'normal'
                        ]
                    ],
                    'P625' => [
                        [
                            'mainsnak' => [
                                'snaktype' => 'value',
                                'property' => 'P625',
                                'datavalue' => [
                                    'value' => [
                                        'latitude' => $latitude,
                                        'longitude' => $longitude,
                                        'altitude' => null,
                                        'precision' => 0.0001,
                                        'globe' => 'http://www.wikidata.org/entity/Q2'
                                    ],
                                    'type' => 'globecoordinate'
                                ]
                            ],
                            'type' => 'statement',
                            'rank' => 'normal'
                        ]
                    ],
                    'P18' => [
                        [
                            'mainsnak' => [
                                'snaktype' => 'value',
                                'property' => 'P18',
                                'datavalue' => [
                                    'value' => $pictureUrl,
                                    'type' => 'string'
                                ]
                            ],
                            'type' => 'statement',
                            'rank' => 'normal'
                        ]
                    ]
                ]
            ])
        ];

        $response = $this->makeAPICall($postData);

		var_dump( $response );

        if (isset($response['success'])) {
            return $response['entity']['id'];
        }

        return false;
    }

	/**
     * Gets an edit token from Wikidata's API for authentication.
     * @return string The edit token.
     */
	private function getEditToken() {
        $postData = [
            'action' => 'query',
            'meta' => 'tokens',
            'type' => 'csrf',
            'format' => 'json'
        ];

        $response = $this->makeAPICall($postData);

        if (isset($response['query']['tokens']['csrftoken'])) {
            return $response['query']['tokens']['csrftoken'];
        }

        return false;
    }

	/**
	 * Makes an API call to Wikidata.
	 *
	 * @param array $postData The data to send to the API.
	 *
	 * @return mixed The JSON response from the API.
	 */
	private function makeAPICall($postData) {
		$postData['assert'] = 'user';
		$postData['formatversion'] = 2;
		//$postData['token'] = $this->getEditToken();
		$postData['bot'] = 1;
		$postData['maxlag'] = 5;
		$postData['format'] = 'json';
		$postData['utf8'] = 1;
		$postData['username'] = $this->username;
		$postData['password'] = $this->password;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			throw new Exception('API call to Wikidata failed: ' . curl_error($ch));
		}

		curl_close($ch);

		return json_decode($response, true);
	}
}


$username = 'luli086';
$password = 'jlmcaceres086@gmail.com';

// $api = new WikidataMonumentAPI('test123', 'pass123');
// instantiate the API class
$api = new WikidataMonumentAPI($username, $password);

var_dump( $api );

// die();


$result = $api->createNewMonument( 'Test Monument', 40.7128, -74.0060, 'https://www.cronista.com/files/image/365/365600/614b613bae510_360_480!.jpg');
if ($result !== false) {
    echo 'New monument created with ID ' . $result;
} else {
    echo 'Failed to create new monument';
}