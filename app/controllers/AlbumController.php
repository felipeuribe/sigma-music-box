<?php

use Phalcon\Mvc\Controller;

class AlbumController extends Controller{
    
    public function indexAction(){
        $album = Album::find();        
        $this->view->setVar("album", $album);    
    }
    
    public function albumsongAction($idAlbum){
         
        // todos los albumes de un artista 
        $albums = Album::find(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        $songs = array();
        
        foreach ($albums as $album) {
            $s = Song::find(array(
                'conditions' => "idAlbum = ?1 ",
                'bind' => array(1 => $album->idAlbum)
            ));
            
            $songs[] = $s;
        }
        
        $this->view->setVar("albums", $albums);
        $this->view->setVar("arraySongs", $songs);
        
    }
    
    public function listAction(){
        $album = Album::find();
        $this->view->setVar("album", $album); 
        
        $artists = Artist::find();
        $this->view->setVar("artists", $artists);  
    }
    
    public function newAction(){ 
        $artists = Artist::find();
        $this->view->setVar("artists", $artists);
        
        if ($this->request->isPost()) {
            try {
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                
                $name = $this->request->getPost("name");
                $numberTracks = $this->request->getPost("numberTracks");
                $year = $this->request->getPost("year");
                $artist = $this->request->getPost("artist");
                
                if(empty($name)){
                    $this->flashSession->error('No ha enviado el nombre del albúm, por favor valide la información');
                }
                else if (empty($artist)) {
                    $this->flashSession->error('No ha enviado un artista para crear el albúm, por favor valide la información');
                }
                else if (empty($year)) {
                    $this->flashSession->error('No ha enviado un Año para crear el Album, por favor valide la información');
                }
                else if ($_FILES["album-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una Imagen para identificar el Albúm, por favor verifica la información');
                }
                else if (!in_array($_FILES['album-cover']['type'], $permitidos) && $_FILES['album-cover']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                else{
                    $album = new Album();
                    $album->name = $name;
                    $album->idArtist = $artist;
                    $album->numberTracks = $numberTracks;
                    $album->year = $year;
                    $album->duration = 0;
                    $album->createdon = time();
                    $album->updatedon = time();

                    if (!$album->save()) {
                        foreach ($album->getMessages() as $msg) {
                            $this->flashSession->error($msg);
                            $this->logger->log($msg);        
                        }
                    }
                    
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/albumes/images/" . $album->idAlbum . "/" ;

                        if(!mkdir($dir, 0777, true)) {
                            $this->flashSession->error("No se ha podido crear el directorio del album, por favor contacta al administrador");
                            return $this->response->redirect("album/new");
                        }

                        $ruta = $dir . $album->idAlbum . ".jpg";

                        $resultado = @move_uploaded_file($_FILES["album-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Albúm, por favor contacta al administrador");
                            return $this->response->redirect("album/new");
                        }
                        
                        $this->flashSession->success("Se ha creado el Album exitosamente");
                        return $this->response->redirect("album/list");
                    } 
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("No se han podido guardar los datos del Album, por favor contacta al administrador");
                $this->logger->log("Exception while saving artist: {$ex->getTraceAsString()} {$ex->getMessage()}");
                return $this->response->redirect('album/list');
            }
        }        
    }
   
    public function editAction($idAlbum){
        $artists = Artist::find();
        $this->view->setVar("artists", $artists);
        
        $album = Album::findFirst(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        if (!$album) {
            $this->flashSession->error('No Existe el codigo valide La Informacion');
            return $this->response->redirect("album/list");
        }
        
        $this->view->setVar("album", $album);
        
        if ($this->request->isPost()) {            
            try{
                $name = $this->request->getPost("name");
                $numberTracks = $this->request->getPost("numberTracks");
                $year = $this->request->getPost("year");
                $artist = $this->request->getPost("artist");
                
                
                if(empty($name)){
                    $this->flashSession->error('No haz enviado un Nombre para identificar el Albúm, por favor verifica la información');
                }                
                
                else if (empty($year)) {
                    $this->flashSession->error('No haz enviado un Año para identificar el Album, por favor verifica la información');
                }
                else {
                    $album->name = $name;
                    $album->numberTracks = $numberTracks;
                    $album->year = $year;
                    $album->idArtist = $artist;
                    
                    $album->createdon = time();
                    $album->updatedon = time();
                    
                    if (!$album->save()) {
                        foreach ($album->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $this->response->redirect('album/list');
                        $this->flashSession->notice("Se Modificado El Album  Exitosamente");
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error con el Album");
                return $this->response->redirect('album/list');
              
            }
        }   
    }
    
    public function deleteAction($idAlbum){
        
        $album = Album::findFirst(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        $song = Song::find(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        if (!$album) {
            $this->flashSession->error('No Existe el codigo del Albúm');
            return $this->response->redirect("album");
        }        
        try {
            
            $songs = Song::find(array(
                'conditions' => "idAlbum = ?1 ",
                'bind' => array(1 => $album->idAlbum)
            ));

            foreach ($songs as $song) {
                if (!$song->delete()) {
                    foreach ($song->getMessages() as $msg) {
                        $this->logger->log($msg);        
                    }
                }  
                $dirsong = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/" . $song->idAlbum . "/" . $song->idSong . ".mp3";
                $this->deletefoldersong($dirsong); 

                $dirsong1 = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/" . $song->idAlbum ;
                $this->deletedirectorysong($dirsong1);                
            }

            if (!$album->delete()) {
                foreach ($album->getMessages() as $msg) {
                    $this->logger->log($msg);        
                }
            }  
            else {                
                
                $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/albumes/images/" . $album->idAlbum . "/" . $album->idAlbum . ".jpg";
                $this->deletefolder($dir);
                
                $dir1 = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/albumes/images/" . $album->idAlbum ;
                $this->deletedirectory($dir1);
                
                $this->response->redirect('album/list');
                return $this->flashSession->error("Se Elimino Exitosamente el Album");
            }  
        }
        catch (Exception $ex){
            $this->flashSession->error("Ocurrió un error mientras se intentaba eliminar el Album, por favor contacte al administrador");
            return $this->response->redirect('album/list');
        }        
    }
    
    public function confirmAction($idAlbum){
        $album = Album::findFirst(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        if (!$album) {
            $this->flashSession->error('No Existe el codigo del Albúm');
            return $this->response->redirect("album");
        }
        
        
         $this->view->setVar("idAlbum", $idAlbum);
    }
    
    public function changeimageAction($idAlbum){
        $album = Album::findFirst(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        
        if (!$album) {
            $this->flashSession->error('No Existe el codigo del Albúm');
            return $this->response->redirect("album/list");
        }
        
        $this->view->setVar("album", $album);
        
        if ($this->request->isPost()) {            
            try{
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                               
                if ($_FILES["artist-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una imagen para identificar el Album, por favor verifica la información');
                }
                else if (!in_array($_FILES['album-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                else {
                    if (!$album->save()) {
                        foreach ($album->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/albumes/images/" . $album->idAlbum . "/" . $album->idAlbum ;
                        $this->deletefolder($dir);
                        
                        $ruta = $dir .  ".jpg";

                        $resultado = @move_uploaded_file($_FILES["album-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Albúm, por favor contacta al administrador");
                            return $this->response->redirect("album/edit");
                        }
                        
                        $this->flashSession->notice("Se ha Modificado La Imagen Del  Albúm Exitosamente.");
                        return $this->response->redirect("album/list");                       
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error Al Editar El Album");
                $this->response->redirect('album/changeimage');
            }
        } 
    }
    
    private function deletefolder($dir){
        if (!unlink($dir)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
    
    private function deletedirectory($dir1){
        if (!rmdir($dir1)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
    
    private function deletefoldersong($dirsong){
        if (!unlink($dirsong)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
    
    private function deletedirectorysong($dirsong1){
        if (!rmdir($dirsong1)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
    
}
