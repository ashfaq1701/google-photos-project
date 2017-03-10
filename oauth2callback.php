<?php 

require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('config/photos.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
$client->addScope(Google_Service_Plus::PLUS_ME);
$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
$client->addScope(Google_Service_Plus::USERINFO_PROFILE);
$client->addScope('https://picasaweb.google.com/data/');
// this will only be working when business is whitelisted and have business account verified.
$client->addScope('https://www.googleapis.com/auth/plus.business.manage');

if (! isset($_GET['code'])) {
	$auth_url = $client->createAuthUrl();
	header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
}
else {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

?>