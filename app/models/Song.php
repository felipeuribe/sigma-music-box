<?php

use Phalcon\Mvc\Model;

class Song extends Model {
    public $idSong;
    public $idAlbum;
    public $name;
    public $numberTracks;
    public $duration;
    public $createdon;
    public $updatedon;
}