<?php
/**
 * Created by PhpStorm.
 * User: pascal
 * Date: 12.09.14
 * Time: 11:52
 */

namespace YMC\Virus;


class Spotify implements RemoteContent {

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
        return "spotify";
    }
    public function getMetadata()
    {
        return $this->getSpotifyData();
    }
    private function getSpotifyData()
    {
        $apiString = $this->client->getSslPage("https://api.spotify.com/v1/search?q=".$this->getSearchString().'&type=track');
        $rawData = json_decode($apiString, true);

        return $rawData['tracks']['items'][0];

    }
    private function getSearchString()
    {
        return urlencode('artist:'.$this->song->getArtist().' track:'.$this->song->getTitle());
    }


} 