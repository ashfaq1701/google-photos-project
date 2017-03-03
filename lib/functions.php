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

function get_album_photos($albumId, $userId, $token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/'.$userId.'/albumid/'.$albumId.'?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	$albumsString = $res->getBody()->getContents();
	$photoXml = simplexml_load_string($albumsString) or die("Error: Cannot create object");
	$entries = $photoXml->entry;
	$photoElements = [];
	foreach ($entries as $entry)
	{
		$idElement = $entry->id;
		$contentElement = $entry->content;
		$idLink = (string) $idElement;
		$idLinkParts = explode('/', $idLink);
		$id = $idLinkParts[count($idLinkParts) - 1];
		$url = $contentElement['src'];
		$photoElement = [];
		$photoElement['id'] = $id;
		$photoElement['url'] = $url[0];
		$photoElements[] = $photoElement;
	}
	return $photoElements;
}

function get_user_photos($userId, $token)
{
	$albums = get_all_albums($userId, $token);
	for ($i = 0; $i < count($albums); $i++)
	{
		$album = $albums[$i];
		$albumId = $album['id'];
		$photos = get_album_photos($albumId, $userId, $token);
		$albums[$i]['photos'] = $photos;
	}
	return $albums;
}

function get_user_account_photos($client, $token)
{
	$plus = new Google_Service_Plus($client);
	$me = $plus->people->get('me');
	$userId = $me['id'];
	return get_user_photos($userId, $token);
}

function get_all_accounts($token)
{
	$url = 'https://mybusiness.googleapis.com/v3/accounts?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	return $res->getBody()->getClients();
}

?>