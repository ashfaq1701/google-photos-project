<?php

	require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/Client.php';
	
	session_start();
	
	$client = new My_Google_Client();
	$client->setAuthConfig('config/photos.json');
	$client->addScope(Google_Service_Drive::DRIVE);
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
	{
		$client->setAccessToken($_SESSION['access_token']);
		$userInfo = $client->getUserInfo();
		print_r($userInfo);
	}
	else {
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

?>
