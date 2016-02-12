<?php

use Phalcon\Mvc\Controller;

class AlbumController extends Controller{
    
    public function IndexAction(){
        $album = Album::find();        
        $this->view->setVar("album", $album);
        
        
    }
    public function ListAction(){
        $album = Album::find();
        $this->view->setVar("album", $album); 
    }
    
    public function  newAction(){ 
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
                else if (empty($numberTracks)) {
                    $this->flashSession->error('No ha enviado el numero de pista para crear el Album, por favor valide la información');
                }
                else if (empty($year)) {
                    $this->flashSession->error('No ha enviado un Año para crear el Album, por favor valide la información');
                }
                else if ($_FILES["album-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una imagen para identificar el Albúm, por favor verifica la información');
                }
                else if (!in_array($_FILES['album-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
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
                            $this->flashSession->error("No se ha podido crear el directorio del género, por favor contacta al administrador");
                            return $this->response->redirect("album/new");
                        }

                        $ruta = $dir . $album->idAlbum . ".jpg";

                        $resultado = @move_uploaded_file($_FILES["album-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Albúm, por favor contacta al administrador");
                            return $this->response->redirect("album/new");
                        }
                        
                        $this->flashSession->success("Se ha creado el género exitosamente");
                        return $this->response->redirect("album/list");
                    } 
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("No se han podido guardar los datos del artista, por favor contacta al administrador");
                $this->logger->log("Exception while saving artist: {$ex->getTraceAsString()} {$ex->getMessage()}");
                return $this->response->redirect('album/list');
            }
        }        
    }
   
    public function editAction($idAlbum){
        $album = Album::findFirst(array(
            'conditions' => "$idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        if (!$album) {
            $this->flashSession->error('No Existe el codigo validar por Favor');
            return $this->response->redirect("album/list");
        }
        
        $this->view->setVar("album", $album);
        
        if ($this->request->isPost()) {
            
            try{
                $name = $this->request->getPost("name");
                $numberTracks = $this->request->getPost("numberTracks");
                $year = $this->request->getPost("year");
                
                if(empty($name)){
                    $this->flashSession->error('No haz enviado un Nombre para identificar el Albúm, por favor verifica la información');
                }                
                else if (!is_numeric($numberTracks)) {
                    $this->flashSession->error('No haz enviado un numero de Pistas para identificar el Album, por favor verifica la información');
                }
                else if (empty($year)) {
                    $this->flashSession->error('No haz enviado un Año para identificar el Album, por favor verifica la información');
                }
                else {
                    $album->name = $name;
                    $album->numberTracks = $numberTracks;
                    $album->year = $year;
                    
                    $album->createdon = time();
                    $album->updatedon = time();
                    
                    if (!$album->save()) {
                        foreach ($album->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $this->response->redirect('album/list');
                        $this->flashSession->success("Se Modificado Exitosamente");
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                return $this->response->redirect('album/list');
              
            }
        }   
    }
    
    public function deleteAction($idAlbum){
        $album = Album::findFirst(array(
            'conditions' => "idAlbum = ?1 ",
            'bind' => array(1 => $idAlbum)
        ));
        
        if (!$album) {
            $this->flashSession->error('No Existe el codigo El Albúm');
            return $this->response->redirect("album");
        }
        
        try {            
            if (!$album->delete()) {
                foreach ($album->getMessages() as $msg) {
                    $this->logger->log($msg);        
                }
            }
            else {
                $this->response->redirect('album/list');
                return $this->flashSession->error("Se Elimino Exitosamente");
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
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("album");
        }
        
        
         $this->view->setVar("idAlbum", $idAlbum);
    }
}
