<?php 

require_once __DIR__.'/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('config/photos.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
$client->addScope(ANALYTICS);
$client->addScope(ANALYTICS_MANAGE_USERS);
$client->addScope(ANALYTICS_EDIT);
$client->addScope(ANALYTICS_MANAGE_USERS_READONLY);
$client->addScope(ANALYTICS_PROVISION);
$client->addScope(ANALYTICS_READONLY);
//$client->addScope('https://picasaweb.google.com/data/');
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