<?php

	require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/Client.php';
	require_once __DIR__ . '/lib/functions.php';
	
	session_start();
	
	$client = new My_Google_Client();
	$client->setAuthConfig('config/photos.json');
	$client->addScope(Google_Service_Drive::DRIVE);
	$client->addScope('https://www.googleapis.com/auth/plus.me');
	$client->addScope('https://www.googleapis.com/auth/userinfo.profile');
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
	{
		$client->setAccessToken($_SESSION['access_token']);
		$userInfo = $client->getUserInfo();
		$userId = $userInfo['id'];
		$token = $_SESSION['access_token']['access_token'];
		$albums = get_all_albums($userId, $token);
		print_r($albums);
	}
	else {
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

?>
