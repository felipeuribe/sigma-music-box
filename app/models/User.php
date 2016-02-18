<?php

use Phalcon\Mvc\Model;

class User extends Model {
    public $idUser;
    public $idCredentials;
    public $name;
    public $lastName;
    public $email;
    public $createdon;
    public $updatedon;
    
}