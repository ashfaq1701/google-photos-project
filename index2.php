<?php

require_once __DIR__ . '/vendor/autoload.php';
	
session_start();
	
$client = new Google_Client();
$client->setAuthConfig('config/photos.json');
$client->addScope(Google_Service_Plus::PLUS_ME);
$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
$client->addScope(Google_Service_Plus::USERINFO_PROFILE);
$client->addScope('https://picasaweb.google.com/data/');
$client->revokeToken();

?>
