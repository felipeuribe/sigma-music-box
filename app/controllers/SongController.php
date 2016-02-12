<?php

use Phalcon\Mvc\Controller;

class SongController extends Controller{
    
    public function IndexAction(){
        $song = Song::find();
        
        $this->view->setVar("song", $song);
    }
    
    public function ListAction(){
        $song = Song::find();
        $this->view->setVar("song", $song); 
    }
    
    public function  newAction(){
        $albums = Album::find();
        $this->view->setVar("albums", $albums);
        
        if ($this->request->isPost()) {            
            try{
                $name = $this->request->getPost("name");
                $number = $this->request->getPost("number");
                $duration = $this->request->getPost("duration");
                
                if( empty($name)){
                    $this->flashSession->error('No haz enviado un Nombre para identificar la Cancion, por favor verifica la información');
                }
                else if (empty($number)) {
                    $this->flashSession->error('No haz enviado un Numero para identificar la Cancion, por favor verifica la información');
                }
                else if (!is_numeric($number)) {
                    $this->flashSession->error('No haz enviado un Numero Valido para identificar de la Cancion, por favor verifica la información');
                }
                else if (empty($duration)) {
                    $this->flashSession->error('No haz enviado una Duracion para identificar la Cancion, por favor verifica la información');
                }
                else{

                    $song = new Song();
                    $song->name = $name;
                    $song->numberTracks = $numberTracks;                   
                    $song->duration = $duration;

                    $song->createdon = time();
                    $song->updatedon = time();


                    if (!$song->save()) {
                    foreach ($song->getMessages() as $msg) {
                        $this->logger->log($msg);        
                        }
                    }
                    else {
                        $this->flashSession->success("Se ha creado la Cancion exitosamente");
                        $this->response->redirect('song/list');
                    }  
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('song/list');
                
            }
        }
    }
    
    public function editAction($idproduct){
        $product = Product::findFirst(array(
            'conditions' => "idproduct = ?1 ",
            'bind' => array(1 => $idproduct)
        ));
        
        if (!$product) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("product");
        }
        
        $this->view->setVar("product", $product);
        
        if ($this->request->isPost()) {
            
            try{
                $name = $this->request->getPost("name");
                $price = $this->request->getPost("price");
                
                if( empty($name)){
                    $this->flashSession->error('No haz enviado un nombre para identificar la Cancion, por favor verifica la información');
                }
                else if (empty($price)) {
                    $this->flashSession->error('No ha enviado el precio');
                }
                else if (!is_numeric($price)) {
                    $this->flashSession->error('No ha enviado un precio válido');
                }
                else {
                    $product->name = $name;
                    $product->price = $price;
                    $product->updatedon = time();
                    
                    if (!$product->save()) {
                        foreach ($product->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $this->response->redirect('product/index');
                        $this->flashSession->success("Se Modificado Exitosamente");
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('product/edit');
            }
        }   
    }
    
    public function deleteAction($idproduct){
        $product = Product::findFirst(array(
            'conditions' => "idproduct = ?1 ",
            'bind' => array(1 => $idproduct)
        ));
        
        if (!$product) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("product");
        }
        
        try{
            if (!$product->delete()) {
                    foreach ($product->getMessages() as $msg) {
                        $this->logger->log($msg);        
                    }
                }
                else {
                    $this->response->redirect('product/index');
                    $this->flashSession->error("Se Elimino Exitosamente");
                }  
        }
        catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('product/index');
        }
        
    }
    
    public function confirmAction($idproduct){
        $product = Product::findFirst(array(
            'conditions' => "idproduct = ?1 ",
            'bind' => array(1 => $idproduct)
        ));
        
        if (!$product) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("product");
        }
        
        
         $this->view->setVar("idproduct", $idproduct);
    }
}
