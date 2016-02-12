<?php

use Phalcon\Mvc\Model;

class Album extends Model {   
    public $idAlbum;
    public $idSong;
    public $name;
    public $numberTracks;
    public $year;
    public $duration;
    public $createdon;
    public $updatedon;
}