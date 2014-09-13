<?php
/**
 * Created by PhpStorm.
 * User: pascal
 * Date: 12.09.14
 * Time: 11:52
 */

namespace YMC\Virus;


class Lyrics implements RemoteContent {

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
        return "lyrics";
    }
    public function getMetadata()
    {
        return $this->getLyrics();
    }
    private function getLyrics()
    {
        $apiString = $this->client->getSslPage("http://lyrics.wikia.com/api.php?artist=".urlencode(strtolower($this->song->getArtist()))."&song=".urlencode(strtolower($this->song->getTitle()))."&fmt=xml");
        $xml = simplexml_load_string($apiString);
        $lyrics = (string) $xml->lyrics;
        if ($lyrics == 'Not found') {
            $lyrics = false;
        } else {
            $lyrics = nl2br($lyrics);
        }
        return $lyrics;

    }


} 