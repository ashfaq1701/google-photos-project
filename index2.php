<?php

require_once __DIR__ . '/vendor/autoload.php';
	
session_start();
	
$client = new Google_Client();
$client->setAuthConfig('config/photos.json');
$client->addScope(ANALYTICS);

$client->addScope('https://picasaweb.google.com/data/');
$client->revokeToken();

?>
