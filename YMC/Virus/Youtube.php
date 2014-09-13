<?php
/**
 * Created by PhpStorm.
 * User: pascal
 * Date: 12.09.14
 * Time: 11:52
 */

namespace YMC\Virus;


class Youtube implements RemoteContent {

    private $client;
    private $song;

    public function __construct(HttpClient $client, Song $song)
    {
        $this->client = $client;
        $this->song = $song;
    }

    public function setSong(Song $song)
    {
        $this->song = $song;
    }

    public function getName()
    {
        return "youtube";
    }
    public function getMetadata()
    {
        return $this->getYoutubeData();
    }
    private function getYoutubeData()
    {
        $apiString = $this->client->getSslPage("https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&videoDefinition=high&videoEmbeddable=true&key=AIzaSyAajCr-83tFsM2_pM3v9rpcRCoF8L6vacs&q=".$this->getSearchString());
        $rawData = json_decode($apiString, true);
        return $rawData['items'][0];

    }
    private function getSearchString()
    {
        return urlencode($this->song->getArtist().' '.$this->song->getTitle());
    }


} 