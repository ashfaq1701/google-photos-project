<?php 

use GuzzleHttp\Client;

function get_all_albums($token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/default?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	return $res->getBody()->getContents();
}

function get_all_accounts($token)
{
	$url = 'https://mybusiness.googleapis.com/v3/accounts?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	return $res->getBody()->getClients();
}

?>