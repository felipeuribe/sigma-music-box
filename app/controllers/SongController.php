<?php

use Phalcon\Mvc\Controller;

class SongController extends Controller{
    
    public function indexAction(){
        $song = Song::find();        
        $this->view->setVar("song", $song);
        
        $albums = Album::find();
        $this->view->setVar("albums", $albums); 
    }
    
    public function listAction(){
        $song = Song::find();
        $this->view->setVar("song", $song); 

        $albums = Album::find();
        $this->view->setVar("albums", $albums); 
    }
    
    public function newAction(){ 

        $albums = Album::find();
        $this->view->setVar("albums", $albums);
        
        $artists = Artist::find();
        $this->view->setVar("artists", $artists); 
        
               
        if ($this->request->isPost()) {
            try {
                $permitidos = array("audio/mp3");
                $limite_Kb = 10000000;
                
                $name = $this->request->getPost("name");                
                $number = $this->request->getPost("number");
                $duration = $this->request->getPost("duration");
                $album = $this->request->getPost("album");
                
                if(empty($name)){
                    $this->flashSession->error('No ha enviado el nombre de la Cancion, por favor valide la información');
                }
                else if(empty($album)){
                    $this->flashSession->error('No ha seleccionado un albúm para la canción, por favor valide la información');
                }
                else if (empty($number)) {
                    $this->flashSession->error('No ha enviado un Numero para crear la Cancion, por favor valide la información');
                }
                else if (empty($duration)) {
                    $this->flashSession->error('No ha enviado una Duracion para crear la Cancion, por favor valide la información');
                }
                else if ($_FILES["song"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una Cancion , por favor verifica la información');
                }
                
                else if (!in_array($_FILES['song']['type'], $permitidos) && $_FILES['song']['size'] > $limite_Kb * 10000000){
                    $this->flashSession->error('Haz enviado una cancion no soportado o una cancion demasiado pesada, la imagen debe pesar máximo 10 MB, por favor verifica la información');
                }
                
                else{
                    $song = new Song();
                    $song->name = $name;
                    $song->idAlbum = $album;                    
                    $song->number = $number;
                    $song->duration = $duration;
                    $song->createdon = time();
                    $song->updatedon = time();
                                                
                    if (!$song->save()) {
                        foreach ($song->getMessages() as $msg) {
                            $this->flashSession->error($msg);
                            $this->logger->log($msg);        
                        }
                    } 
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/". $song->idAlbum . "/";

                        
                        if(file_exists($dir)) {
                            
                        }
                        else if(!mkdir($dir, 0777, true)) {
                            $this->flashSession->error("No se ha podido crear el directorio del género, por favor contacta al administrador");
                            return $this->response->redirect("song/new");
                        }                        
                                              
                        $ruta = $dir . "{$song->idSong}.mp3";
                        
                        $resultado = @move_uploaded_file($_FILES["song"]["tmp_name"], $ruta);

                        $album = Album::findFirst(array('conditions' => 'idAlbum = ?0', 'bind' => array($album)));
                        
                        $durSecSong = $this->convertTimeToSeconds($duration);
                        $durSecAlbum = ($album->duration == 0 || $album->duration == null ? 0 : $this->convertTimeToSeconds($album->duration));
                        $sumSecFinalDur = $durSecSong + $durSecAlbum;
                        $durationAlbum = $this->convertSecondsToTime($sumSecFinalDur);
                        
                        $album->duration = $durationAlbum;
                        $songs = Song::find(array("conditions" => "idAlbum = ?0", "bind" => array($album->idAlbum)));
                        $album->numberTracks = count($songs);
                       
                        $album->save();
                        
                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el Albúm, por favor contacta al administrador");
                            return $this->response->redirect("song/new");
                        }
                        
                        $this->flashSession->success("Se ha creado la Cancion exitosamente");
                        return $this->response->redirect("song/list");
                        
                    } 
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("No se han podido guardar los datos del artista, por favor contacta al administrador");
                $this->logger->log("Exception while creating song: " . $ex->getMessage());
                $this->logger->log($ex->getTraceAsString());
                return $this->response->redirect('song/list');
            }
        }        
    }
    
    public function editAction($idSong){
        $albums = Album::find();
        $this->view->setVar("albums", $albums);

        $song = Song::findFirst(array(
            'conditions' => "idSong = ?1 ",
            'bind' => array(1 => $idSong)
        ));
        
        if (!$song) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("song");
        }        
        $this->view->setVar("song", $song);
        
        if ($this->request->isPost()) {
            
            try{
                $name = $this->request->getPost("name");
                $number = $this->request->getPost("number");
                $duration = $this->request->getPost("duration");
                $album = $this->request->getPost("album");
                
                if( empty($name)){
                    $this->flashSession->error('No haz enviado un nombre para identificar la Cancion, por favor verifica la información');
                }
                else if (empty($number)) {
                    $this->flashSession->error('No ha enviado un Numero');
                }
                else if (empty($duration)) {
                    $this->flashSession->error('No ha enviado una duracion de la Cancion');
                }
                else if (!is_numeric($number)) {
                    $this->flashSession->error('No ha enviado un Numero válido');
                }
                else {
                    $dir1 = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/". $song->idAlbum . "/{$song->idSong}.mp3";  
                    $song->name = $name;
                    $song->number = $number;
                    
                    $song->updatedon = time();                    
                    $song->idAlbum = $album;                   
                    
                    $album = Album::findFirst(array('conditions' => 'idAlbum = ?0', 'bind' => array($album)));
                    $durSecSong = $this->convertTimeToSeconds($duration);
                    $durSecAlbum = ($album->duration == 0 || $album->duration == null ? 0 : $this->convertTimeToSeconds($album->duration));
                    $durSecSong1 = ($song->duration == 0 || $song->duration == null ? 0 : $this->convertTimeToSeconds($song->duration));

                    $Subtraction = $durSecAlbum - $durSecSong1;                     
                    $sumSecFinalDur = $Subtraction + $durSecSong ;                    
                    $durationAlbum = $this->convertSecondsToTime($sumSecFinalDur);

                    $album->duration = $durationAlbum;
                    $songs = Song::find(array("conditions" => "idAlbum = ?0", "bind" => array($album->idAlbum)));
                    $album->numberTracks = count($songs);
                    $album->save();
                    
                    
                    $song->duration = $duration;                    
                    if (!$song->save()) {
                        foreach ($song->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/". $song->idAlbum . "/";

                        if(!file_exists($dir)) {          
                            if(!mkdir($dir, 0777, true)) {
                                $this->flashSession->error("No se ha podido crear el directorio del género, por favor contacta al administrador");
                                return $this->response->redirect("song/list");
                            } 
                        }  
                        $dir = $dir . "{$song->idSong}.mp3";                        
                        rename($dir1,$dir);
                        
                        $this->response->redirect('song/list');
                        $this->flashSession->notice("Se Modificado Exitosamente la Cancion");
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('song/edit');
            }
        }   
    }
    
    public function deleteAction($idSong){       
       
        $song = Song::findFirst(array(
            'conditions' => "idSong = ?1 ",
            'bind' => array(1 => $idSong)
        ));
        
        if (!$song) {
            $this->flashSession->error('No Existe una Cancion con este codigo');
            return $this->response->redirect("song");
        }  
           
        try{   
            
            $album = Album::findFirst(array(
                "conditions" => "idAlbum = ?0",
                'bind' => array($song->idAlbum)
            ));
            
                    
            $durSecAlbum = ($album->duration == 0 || $album->duration == null ? 0 : $this->convertTimeToSeconds($album->duration));
            $durSecSong1 = ($song->duration == 0 || $song->duration == null ? 0 : $this->convertTimeToSeconds($song->duration));      

            $sumSecFinalDur = $durSecAlbum - $durSecSong1;

            $durationAlbum = $this->convertSecondsToTime($sumSecFinalDur);

            $album->duration = $durationAlbum;
            
            $songs = Song::find(array("conditions" => "idAlbum = ?0", "bind" => array($album->idAlbum)));
            $album->numberTracks = count($songs);
            $album->save();
            
            if (!$song->delete()) {
                    foreach ($song->getMessages() as $msg) {
                        $this->logger->log($msg);        
                    }
                }
                else {                    
                    $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/" . $song->idAlbum . "/" . $song->idSong . ".mp3";
                    $this->deletefolder($dir); 
                   
                    $dir1 = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/" . $song->idAlbum ;
                    $this->deletedirectory($dir1);
                    
                    $this->response->redirect('song/list');
                    $this->flashSession->error("Se Elimino Exitosamente la Cancion");
                }  
        }
        catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('song/list');
        }
        
    }
    
    public function confirmAction($idSong){
        $song = Song::findFirst(array(
            'conditions' => "idSong = ?1 ",
            'bind' => array(1 => $idSong)
        ));
        
        
        if (!$song) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("song");
        }
        
        $this->view->setVar("idSong", $idSong);
    }

    public function changeaudioAction($idSong){
        $song = Song::findFirst(array(
            'conditions' => "idSong = ?1 ",
            'bind' => array(1 => $idSong)
        ));
        
        if (!$song) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("song/list");
        }
        
        $this->view->setVar("song", $song);
        
        if ($this->request->isPost()) {            
            try{
                $permitidos = array("audio/mp3");
                $limite_Mb = 800;
                               
                if ($_FILES["song-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado la Cancion, por favor verifica la información');
                }
                else if (!in_array($_FILES['song-cover']['type'], $permitidos) && $_FILES['audio']['size'] > $limite_Mb * 800){
                    $this->flashSession->error('Haz enviado una Cacion no soportado o una Cancion demasiado pesada, la Cancion debe pesar máximo 800 MB, por favor verifica la información');
                }
                else {
                    if (!$song->save()) {
                        foreach ($artist->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/music/". $song->idAlbum . "/";
                        $this->deletefolder($dir);
                        
                        $ruta = $dir . "{$song->idSong}.mp3";

                        $resultado = @move_uploaded_file($_FILES["song-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear la Cancion, por favor contacta al administrador");
                            return $this->response->redirect("song/edit");
                        }
                        
                        $this->flashSession->notice("Se ha Modificado La Cancion Exitosamente.");
                        return $this->response->redirect("song/list");  
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
    
    private function deletedirec($di){
        if (!rmdir($di)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
    
    protected function convertTimeToSeconds($dur) {
        $arrayDuration = explode(":", $dur);
        $minutes = $arrayDuration[0] * 60;
        $seconds = $arrayDuration[1];    
        return $minutes + $seconds;
    }
    
    protected function convertSecondsToTime($sec) {
        $minutes = floor(($sec / 60) % 60);
        $seconds = $sec % 60;
        return "{$minutes}:{$seconds}";
    }
    
}
