<?php
/**
 * Created by PhpStorm.
 * User: pascal
 * Date: 12.09.14
 * Time: 11:52
 */

namespace YMC\Virus;


interface RemoteContent {

    public function __construct(HttpClient $client, Song $song);
    public function setSong(Song $song);
    public function getMetadata();
    public function getName();
}