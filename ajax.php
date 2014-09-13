<?php
include_once("YMC/Virus/Song.php");

list($artist, $title) = explode(' - ', $_POST['songdata']);

header('Content-Type: Application/json');
$song = new \YMC\Virus\Song();
$song->setTitle($title);
$song->setArtist($artist);
if ($song->isValid()) {
    echo json_encode(
        $song->getMetadata()
    );
}