<?php

use Phalcon\Mvc\Controller;

class ArtistController extends Controller{
    
    public function IndexAction(){
        $artist = Artist::find();
        $this->view->setVar("artist", $artist);
    }
    
    public function ListAction(){
        $artist = Artist::find();
        $this->view->setVar("artist", $artist); 
    }
    private function deleteFolder($dir){
        if (!unlink($dir)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
    
    public function  newAction(){ 
        $genders = Gender::find();
        $this->view->setVar("genders", $genders);
        
        if ($this->request->isPost()) {
            try {
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                
                $name = $this->request->getPost("name");
                $country = $this->request->getPost("country");
                $genders = $this->request->getPost("genders");
                
                if( empty($name)){
                    $this->flashSession->error('No ha enviado el nombre para crear el artista, por favor valide la información');
                }
                else if (empty($country)) {
                    $this->flashSession->error('No ha enviado un el pais para crear el artista, por favor valide la información');
                }
                else if (count($genders) <= 0) {
                    $this->flashSession->error('No ha enviado un género para crear el artista, por favor valide la información');
                }
                else if ($_FILES["artist-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una imagen para identificar el Artista, por favor verifica la información');
                }
                else if (!in_array($_FILES['artist-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                else{
                    $artist = new Artist();
                    $artist->name = $name;
                    $artist->country = $country;

                    $artist->createdon = time();
                    $artist->updatedon = time();

                    if (!$artist->save()) {
                        foreach ($artist->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        foreach ($genders as $gender) {
                            $gxa = new Genderxartist();
                            $gxa->idArtist = $artist->idArtist;
                            $gxa->idGender = $gender;
                            
                            if (!$gxa->save()) {
                                foreach ($gxa->getMessages() as $msg) {
                                    $this->logger->log($msg);        
                                }
                            }                            
                        }
                        
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/artists/images/" . $artist->idArtist . "/" ;

                        if(!mkdir($dir, 0777, true)) {
                            $this->flashSession->error("No se ha podido crear el directorio del género, por favor contacta al administrador");
                            return $this->response->redirect("artist/new");
                        }

                        $ruta = $dir . $artist->idArtist . ".jpg";

                        $resultado = @move_uploaded_file($_FILES["artist-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Artista, por favor contacta al administrador");
                            return $this->response->redirect("artist/new");
                        }
                        
                        $this->flashSession->success("Se ha creado el género exitosamente");
                        return $this->response->redirect("artist/list");
                    }  
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("No se han podido guardar los datos del artista, por favor contacta al administrador");
                $this->logger->log("Exception while saving artist: {$ex->getTraceAsString()}");
                return $this->response->redirect('artist/list');
            }
        }        
    }
    
    public function editimagesAction($idArtist){
        $artist = Artist::findFirst(array(
            'conditions' => "idArtist = ?1 ",
            'bind' => array(1 => $idArtist)
        ));
        
        if (!$artist) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("artist/list");
        }
        
        $this->view->setVar("artist", $artist);
        
        if ($this->request->isPost()) {            
            try{
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                
                $name = $this->request->getPost("name");
                $country = $this->request->getPost("country");
                                
                if( empty($name)){
                    $this->flashSession->error('No has enviado el nombre del Artista');
                }
                else if( empty($country)){
                    $this->flashSession->error('No has enviado el Pais del Artista');
                }                
                else if (!in_array($_FILES['artist-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                
                else {
                    $artist->name = $name;
                    $artist->country = $country;
                    
                    $artist->updatedon = time();
                    
                    if (!$artist->save()) {
                        foreach ($artist->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/artists/images/" . $artist->idArtist . "/" . $artist->idArtist . ".jpg";
                        $this->deleteFolder($dir);
                        
                        $ruta = $dir .  ".jpg";

                        $resultado = @move_uploaded_file($_FILES["artist-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Artista, por favor contacta al administrador");
                            return $this->response->redirect("artist/edit");
                        }
                        
                        $this->flashSession->success("Se ha Modificado El Artista Exitosamente");
                        return $this->response->redirect("artist/list");                        
                       
                        
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error Al Editar El Artista");
                $this->response->redirect('artist/edit');
            }
        } 
    }
    
    public function editAction($idArtist){
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
    
    public function confirmAction($idArtist){
        $artist = Artist::findFirst(array(
            'conditions' => "idArtist = ?1",
            'bind' => array(1 => $idArtist)
        ));
        
        if (!$artist) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("artist");
        } 
        $this->view->setVar("idArtist", $idArtist);
    }
    
    public function deleteAction($idArtist){
        $artist = Artist::findFirst(array(
            'conditions' => "idArtist = ?1 ",
            'bind' => array(1 => $idArtist)
        ));
        
        if (!$artist) {
            $this->flashSession->error('No Existe el codigo Del Artista');
            return $this->response->redirect("artist");
        }
        
        try {            
            if (!$artist->delete()) {
                foreach ($artist->getMessages() as $msg) {
                    $this->logger->log($msg);        
                }
            }
            else {
                $this->response->redirect('artist/list');
                return $this->flashSession->error("Se Elimino Exitosamente");
            }  
        }
        catch (Exception $ex){
            $this->flashSession->error("Ocurrió un error mientras se intentaba eliminar el artista, por favor contacte al administrador");
            $this->logger->log("Exception while deleting artist: " . $ex->getMessage());
            $this->logger->log($ex->getTraceAsString());
            return $this->response->redirect('artist/list');
        }        
    }
    
    
    
   
}
