<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Client.php';
	
session_start();
	
$client = new My_Google_Client();
$client->setAuthConfig('config/photos.json');
$client->addScope(Google_Service_Drive::DRIVE);
$client->addScope('https://www.googleapis.com/oauth2/v1/userinfo');
$client->revokeToken();

?>
