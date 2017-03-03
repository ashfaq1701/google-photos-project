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
	
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
	{
		$client->setAccessToken($_SESSION['access_token']);
		$token = $_SESSION['access_token']['access_token'];
		//$albums = get_all_albums($token);
		//print_r($albums);

		$plus = new Google_Service_Plus($client);
		$me = $plus->people->get('me');
		echo json_encode($me);
	}
	else {
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

?>
