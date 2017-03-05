<?php 

use GuzzleHttp\Client;

// get all album list for user
function get_all_albums($userId, $token)
{
	$url = 'https://picasaweb.google.com/data/feed/api/user/'.$userId.'?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	$albumsString = $res->getBody()->getContents();
	$albumXml = simplexml_load_string($albumsString) or die("Error: Cannot create object");
	echo $albumXml->asXML();
	return '';
	/*$entries = $albumXml->entry;
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
	return $albumElements;*/
}

// get photos for a given album id
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
		$url = (string) $contentElement['src'];
		$photoElement = [];
		$photoElement['id'] = $id;
		$photoElement['url'] = str_replace( '\/', '/', $url);
		$photoElements[] = $photoElement;
	}
	return $photoElements;
}

// get photos of current user with all albums
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

//get all photos for the current user only. No business account will not be supported or polled.
function get_user_account_photos($client, $token)
{
	$plus = new Google_Service_Plus($client);
	$me = $plus->people->get('me');
	$userId = $me['id'];
	return get_user_photos($userId, $token);
}

//get all business accounts for the current logged in user. This will not work without My Business API, which is only visible when business in address verified. 
function get_all_accounts($token)
{
	$url = 'https://mybusiness.googleapis.com/v3/accounts?access_token='.$token;
	$client = new Client();
	$res = $client->request('GET', $url);
	$accountsJson = $res->getBody()->getClients();
	$accountsObj = json_decode($accountsJson, true);
	$accounts = $accountsObj['accounts'];
	$accountIds = [];
	foreach ($accounts as $account)
	{
		$accountName = $account['name'];
		$accountTitle = $account['accountName'];
		$nameParts = explode('/', $accountName);
		$accountId = $nameParts[count($nameParts) - 1];
		$accountObj = [];
		$accountObj['id'] = $accountId;
		$accountObj['name'] = $accountTitle;
		$accountIds[] = $accounObj;
	}
	return $accountIds;
}

//get all photos for all business and personal accounts for the current user
function get_user_all_account_photos($token)
{
	$accounts = get_all_accounts();
	$accountPhotos = [];
	foreach ($accounts as $account)
	{
		$accountId = $account['id'];
		$accountName = $account['name'];
		$accountPhotos[$accountName] = get_user_photos($accountId, $token);
	}
	return $accountPhotos;
}

?>