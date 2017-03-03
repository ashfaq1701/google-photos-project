<?php 

use GuzzleHttp\Client;

function get_all_albums($userId, $token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/'.$userId.'?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	$albumsString = $res->getBody()->getContents();
	$albumXml = simplexml_load_string($albumsString) or die("Error: Cannot create object");
	$entries = $albumXml->entry;
	$albumElements = [];
	foreach ($entries as $entry)
	{
		$idElement = $entry->id;
		$titleElement = $entry->title;
		$idLink = (string) $idElement;
		$idLinkParts = explode('/', $idLink);
		$id = $idLinkParts[count($idLinkParts) - 1];
		$title = (string) $titleElement;
		$albumElement = [];
		$albumElement['id'] = $id;
		$albumElement['title'] = $title;
		$albumElements[] = $albumElement;
	}
	return $albumElements;
}

function get_all_accounts($token)
{
	$url = 'https://mybusiness.googleapis.com/v3/accounts?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	return $res->getBody()->getClients();
}

?>