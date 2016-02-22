<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    
    public function indexAction(){        
        $album = Album::find(array("limit"=> 15,"order" => "idAlbum DESC"));
        $this->view->setVar("album", $album); 
        
       
        
    }
    
    
}
