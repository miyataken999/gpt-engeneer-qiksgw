<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

class WpApi {
    private $apiUrl;
    private $username;
    private $password;

    public function __construct($apiUrl, $username, $password) {
        $this->apiUrl = $apiUrl;
        $this->username = $username;
        $this->password = $password;
    }

    public function createPage($title, $content) {
        $client = new Client();
        $auth = base64_encode("{$this->username}:{$this->password}");
        $headers = [
            'Authorization' => "Basic {$auth}",
            'Content-Type' => 'application/json'
        ];

        $data = [
            'title' => $title,
            'content' => $content,
            'status' => 'publish'
        ];

        $response = $client->post($this->apiUrl . '/wp/v2/pages', [
            'headers' => $headers,
            'json' => $data
        ]);

        if ($response->getStatusCode() == 201) {
            echo "Page created successfully!";
        } else {
            echo "Error creating page: " . $response->getReasonPhrase();
        }
    }
}

$apiUrl = 'https://example.com/wp-json/wp/v2'; // Replace with your WordPress API URL
$username = 'your_username'; // Replace with your WordPress username
$password = 'your_password'; // Replace with your WordPress password

$wpApi = new WpApi($apiUrl, $username, $password);
$wpApi->createPage('My New Page', 'This is the content of my new page');