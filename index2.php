<?php

require_once __DIR__ . '/vendor/autoload.php';
	
session_start();
	
$client = new Google_Client();
$client->setAuthConfig('config/photos.json');
$client->addScope(Google_Service_Drive::DRIVE);
$client->addScope('https://www.googleapis.com/oauth2/v1/userinfo');
$client->addScope('https://www.googleapis.com/auth/plus.business.manage');
$client->revokeToken();

?>
