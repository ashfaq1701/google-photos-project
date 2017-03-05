<?php

	require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/lib/functions.php';
	
	session_start();
	
	$client = new Google_Client();
	$client->setAuthConfig('config/photos.json');
	$client->addScope(Google_Service_Plus::PLUS_ME);
	$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
	$client->addScope(Google_Service_Plus::USERINFO_PROFILE);
	$client->addScope('https://picasaweb.google.com/data/');
	// this will only be working when business is whitelisted and have business account verified.
	//$client->addScope('https://www.googleapis.com/auth/plus.business.manage');
	
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
	{
		$client->setAccessToken($_SESSION['access_token']);
		$token = $_SESSION['access_token']['access_token'];

		// the below line will be replaced by bottom one only if account is verified and google my business api is working
		//albumPhotos = get_user_all_account_photos($token);
		$albumPhotos = get_user_account_photos($client, $token);
		print_r($albumPhotos);
		
	}
	else {
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

?>
