<?php 

use GuzzleHttp\Client;

function get_all_albums($token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/default?access_token='.$token;
	echo $url.'<br/><br/>';
	$client = new Client();
	$res = $client->request('GET', $url);
	return $res->getBody()->getContents();
}

?>