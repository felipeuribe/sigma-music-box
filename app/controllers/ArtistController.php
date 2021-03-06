<?php

use Phalcon\Mvc\Controller;

class ArtistController extends Controller{
    
    public function indexAction(){
        $artist = Artist::find();
        $this->view->setVar("artist", $artist);    
    }

    public function artistalbumAction($idArtist){
                
        // todos los albumes de un artista 
        $albums = Album::find(array(
            'conditions' => "idArtist = ?1 ",
            'bind' => array(1 => $idArtist)
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
        $artists = Artist::find();
        $this->view->setVar("artists", $artists); 
        
        $gxas = Genderxartist::find();
        $this->view->setVar("gxas", $gxas);
        
        $genders = Gender::find();
        $this->view->setVar("genders", $genders);
    }
        
    public function newAction(){ 
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
                    $this->flashSession->error('No ha enviado  el pais para crear el artista, por favor valide la información');
                }
                else if (count($genders) <= 0) {
                    $this->flashSession->error('No ha enviado un Género para crear el artista, por favor valide la información');
                }
                else if ($_FILES["artist-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una Imagen para identificar el Artista, por favor verifica la información');
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
                            $this->flashSession->error("No se ha podido crear el directorio del Artista, por favor contacta al administrador");
                            return $this->response->redirect("artist/new");
                        }

                        $ruta = $dir . $artist->idArtist . ".jpg";

                        $resultado = @move_uploaded_file($_FILES["artist-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Artista, por favor contacta al administrador");
                            return $this->response->redirect("artist/new");
                        }
                        
                        $this->flashSession->success("Se ha creado  El Artista exitosamente");
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
 
    public function editAction($idArtist){
        $artist = Artist::findFirst(array(
            'conditions' => "idArtist = ?1 ",
            'bind' => array(1 => $idArtist)
        ));
        
        $genders = Gender::find();
        $this->view->setVar("genders", $genders);
        
        $gxas = Genderxartist::find(array(
            'conditions' => "idArtist = ?1 ",
            'bind' => array(1 => $idArtist)
        ));
        
        $this->view->setVar("gxas", $gxas);
        
        if (!$artist) {
            $this->flashSession->error('No Existe el codigo valide por Favor');
            return $this->response->redirect("artist/list");
        }
        
        $this->view->setVar("artist", $artist);
        
        if ($this->request->isPost()) {            
            try{
                $name = $this->request->getPost("name");
                $country = $this->request->getPost("country");
                $genders = $this->request->getPost("genders");
                
                if(empty($name)){
                    $this->flashSession->error('No haz enviado un Nombre para identificar el Artista, por favor verifica la información');
                }
                else if (empty($country)) {
                    $this->flashSession->error('No haz enviado el Pais para identificar el Artista, por favor verifica la información');
                }
                else {
                    $artist->name = $name;
                    $artist->country = $country;
                    
                    $artist->createdon = time();
                    $artist->updatedon = time();
                    
                    if (!$gxas->delete()) {
                        foreach ($gxas->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }                    
                    else if (!$artist->save()) {
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
                        $this->response->redirect('artist/list');
                        $this->flashSession->notice("Se Modificado El Artista Exitosamente");
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                return $this->response->redirect('artist/edit');              
            }
        }   
    }
    
    public function confirmAction($idArtist){
        $artist = Artist::findFirst(array(
            'conditions' => "idArtist = ?1",
            'bind' => array(1 => $idArtist)
        ));
        
        if (!$artist) {
            $this->flashSession->error('No Existe el codigo por favor validar ');
            return $this->response->redirect("artist");
        } 
        $this->view->setVar("idArtist", $idArtist);
    }
    
    public function deleteAction($idArtist){
        try {
            $artist = Artist::findFirst(array(
                'conditions' => "idArtist = ?1 ",
                'bind' => array(1 => $idArtist)
            ));
            
            if (!$artist) {
                $this->flashSession->error('No Existe el codigo Por favor validar');
                return $this->response->redirect("artist");
            }
        
            $albums = Album::find(array(
                'conditions' => "idArtist = ?1 ",
                'bind' => array(1 => $idArtist)
            ));

            foreach ($albums as $album) {
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
                }
                
                if (!$album->delete()) {
                    foreach ($album->getMessages() as $msg) {
                        $this->logger->log($msg);        
                    }
                }  
            }
            
            $gxas = Genderxartist::find(array(
                'conditions' => "idArtist = ?1 ",
                'bind' => array(1 => $idArtist)
            ));
            
            if (!$gxas->delete()) {
                foreach ($gxas->getMessages() as $msg) {
                    $this->logger->log($msg);        
                }
            }
            else if (!$artist->delete()) {
                foreach ($artist->getMessages() as $msg) {
                    $this->logger->log($msg);        
                }
            }
            else {
                $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/artists/images/" . $artist->idArtist . "/" . $artist->idArtist . ".jpg";
                $this->deletefolder($dir);
                
                $dir1 = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/artists/images/" . $artist->idArtist ;
                $this->deletedirectory($dir1);
                
                $this->response->redirect('artist/list');
                $this->flashSession->error("Se Eliminó El Artista Exitosamente"); 
            }  
        }
        catch (Exception $ex){
            $this->flashSession->error("Ocurrió un error mientras se intentaba eliminar el artista, por favor contacte al administrador");
            $this->logger->log("Exception while deleting artist: " . $ex->getMessage());
            $this->logger->log($ex->getTraceAsString());
            return $this->response->redirect('artist/list');
        }        
    }
    
    public function changeimageAction($idArtist){
        $artist = Artist::findFirst(array(
            'conditions' => "idArtist = ?1 ",
            'bind' => array(1 => $idArtist)
        ));
        
        if (!$artist) {
            $this->flashSession->error('No Existe el codigo por favor validar');
            return $this->response->redirect("artist/list");
        }
        
        $this->view->setVar("artist", $artist);
        
        if ($this->request->isPost()) {            
            try{
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                               
                if ($_FILES["artist-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una imagen para identificar el género, por favor verifica la información');
                }
                else if (!in_array($_FILES['artist-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                else {
                    if (!$artist->save()) {
                        foreach ($artist->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/artists/images/" . $artist->idArtist . "/" . $artist->idArtist ;
                        $this->deletefolder($dir);
                        
                        $ruta = $dir .  ".jpg";

                        $resultado = @move_uploaded_file($_FILES["artist-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Artista, por favor contacta al administrador");
                            return $this->response->redirect("artist/edit");
                        }
                        
                        $this->flashSession->notice("Se ha Modificado La Imagen Del  Artista Exitosamente.");
                        return $this->response->redirect("artist/list");                        
                       
                        
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error Al Editar El Artista");
                $this->response->redirect('artist/changeimage');
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
    
   
}
