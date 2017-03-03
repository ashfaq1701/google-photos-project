<?php

require_once __DIR__ . '/vendor/autoload.php';
	
session_start();
	
$client = new Google_Client();
$client->setAuthConfig('config/photos.json');
$client->addScope(Google_Service_Analytics::ANALYTICS);
$client->addScope(Google_Service_Analytics::ANALYTICS_MANAGE_USERS);
$client->addScope(Google_Service_Analytics::ANALYTICS_EDIT);
$client->addScope(Google_Service_Analytics::ANALYTICS_MANAGE_USERS_READONLY);
$client->addScope(Google_Service_Analytics::ANALYTICS_PROVISION);
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
$client->addScope('https://picasaweb.google.com/data/');
$client->revokeToken();

?>
