<?php

	require_once __DIR__ . '/vendor/autoload.php';
	require_once __DIR__ . '/lib/functions.php';
	
	session_start();
	
	$client = new Google_Client();
	$client->setAuthConfig('config/photos.json');
	$client->addScope('https://picasaweb.google.com/data/');
	$client->addScope(ANALYTICS);
	$client->addScope(ANALYTICS_MANAGE_USERS);
	$client->addScope(ANALYTICS_EDIT);
	$client->addScope(ANALYTICS_MANAGE_USERS_READONLY);
	$client->addScope(ANALYTICS_PROVISION);
	$client->addScope(ANALYTICS_READONLY);
	
	if (isset($_SESSION['access_token']) && $_SESSION['access_token']) 
	{
		$client->setAccessToken($_SESSION['access_token']);
		$token = $_SESSION['access_token']['access_token'];
		//$albums = get_all_albums($token);
		//print_r($albums);
		$accounts = $analytics->management_accounts->listManagementAccounts();
		print_r($accounts);
	}
	else {
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

?>
