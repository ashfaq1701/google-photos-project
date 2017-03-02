<?php 

use GuzzleHttp\Client;

function get_all_albums($userId, $token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/default';
	$client = new Client();
	$res = $client->request('GET', $url.'?access_token='.$token);
	return $res->getBody()->getContents();
}

?>