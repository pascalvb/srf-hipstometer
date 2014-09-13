<?php
namespace YMC\Virus;

include_once("HttpClient.php");
include_once("RemoteContent.php");
include_once("Spotify.php");
include_once("Youtube.php");
include_once("Lyrics.php");



class Song {

    private $title;

    private $artist;

    private $id;

    /**
     * @var RemoteContent[]
     */
    private $collectors;

    public function __construct()
    {
        $this->collectors[] = new Spotify(new HttpClient(), $this);
        $this->collectors[] = new Youtube(new HttpClient(), $this);
        $this->collectors[] = new Lyrics(new HttpClient(), $this);
    }

    public function isValid()
    {
        if ($this->title != '') {
            return true;
        }
        return false;
    }

    public function getMetadata()
    {
        $metadata = [
            'title' => $this->title,
            'artist' => $this->artist,
        ];
        foreach ($this->collectors as $collector) {
            $metadata[$collector->getName()] = $collector->getMetadata();
        }
        return $metadata;
    }

    /**
     * @return mixed
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param mixed $artist
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


} 