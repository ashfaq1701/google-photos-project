<?php 

use GuzzleHttp\Client;

function get_all_albums($userId, $token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/'.$userId.'?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	$albumsString = $res->getBody()->getContents();
	$albumXml = simplexml_load_string($albumsString) or die("Error: Cannot create object");
	$categories = $albumXml->category[0];//->subtitle->entry->category;
	return $categories->asXML();
	/*foreach ($categories as $category)
	{
		$currentEntries = $category->summary->entry;
		foreach ($currentEntries as $entry)
		{
			$str .= $entry->asXML().'<br/><br/>';
		}
	}*/
	//return '';
}

function get_all_accounts($token)
{
	$url = 'https://mybusiness.googleapis.com/v3/accounts?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	return $res->getBody()->getClients();
}

?>