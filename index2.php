<?php

require_once __DIR__ . '/vendor/autoload.php';
	
session_start();
	
$client = new Google_Client();
$client->setAuthConfig('config/photos.json');
$client->addScope(ANALYTICS);
$client->addScope(ANALYTICS_MANAGE_USERS);
$client->addScope(ANALYTICS_EDIT);
$client->addScope(ANALYTICS_MANAGE_USERS_READONLY);
$client->addScope(ANALYTICS_PROVISION);
$client->addScope(ANALYTICS_READONLY);
$client->addScope('https://picasaweb.google.com/data/');
$client->revokeToken();

?>
