<?php
use Phalcon\Mvc\Controller;

class GenderController extends Controller{
    
    public function IndexAction(){
        $gender = Gender::find();
        $this->view->setVar("gender", $gender);     
    }
    
    public function NewAction(){
        if ($this->request->isPost()) {            
            try{
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                
                $name = $this->request->getPost("name");
                                
                if( empty($name)){
                    $this->flashSession->error('No haz enviado un nombre para identificar el género, por favor verifica la información');
                } 
                else if ($_FILES["gender-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una imagen para identificar el género, por favor verifica la información');
                }
                else if (!in_array($_FILES['gender-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                else {    
                    $gender = new Gender();
                    $gender->name = $name;
                    $gender->createdon = time();
                    $gender->updatedon = time();

                    if (!$gender->save()) {
                        foreach ($gender->getMessages() as $msg) {
                            $this->flashSession->error($msg);
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/genders/images/" . $gender->idGender . "/" ;

                        if(!mkdir($dir, 0777, true)) {
                            $this->flashSession->error("No se ha podido crear el directorio del género, por favor contacta al administrador");
                            return $this->response->redirect("gender/new");
                        }

                        $ruta = $dir . $gender->idGender . ".jpg";

                        $resultado = @move_uploaded_file($_FILES["gender-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el género, por favor contacta al administrador");
                            return $this->response->redirect("gender/new");
                        }
                        
                        $this->flashSession->success("Se ha creado el género exitosamente");
                        return $this->response->redirect("gender");
                    }  
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('gender/new');                
            }
        }
    }
    
    public function ListAction(){
        $gender = Gender::find();
        $this->view->setVar("gender", $gender); 
    }

    public function deleteAction($idGender){
        $gender = Gender::findFirst(array(
            'conditions' => "idGender = ?1 ",
            'bind' => array(1 => $idGender)
        ));
        
        $gxas = Genderxartist::find(array(
            'conditions' => "idGender = ?1 ",
            'bind' => array(1 => $idGender)
        )); 
        
        if (!$gxas->delete()) {
            foreach ($gxas->getMessages() as $msg) {
                $this->logger->log($msg);        
            }
        } 
        else if (!$gender) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("gender/list");
        }
        
        try{
            if (!$gender->delete()) {
                    foreach ($gender->getMessages() as $msg) {
                        $this->logger->log($msg);        
                    }
                }
                else {
                    $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/genders/images/" . $gender->idGender . "/" . $gender->idGender . ".jpg";
                    $this->deleteFolder($dir);                     
                    $this->response->redirect('gender/list');
                    $this->flashSession->error("Se Elimino El Album Exitosamente");
                }  
        }
        catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('gender/list');
        }
        
    }

    public function confirmAction($idGender){
        $gender = Gender::findFirst(array(
            'conditions' => "idGender = ?1 ",
            'bind' => array(1 => $idGender)
        ));
        
        if (!$gender) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("gender");
        }
        
        
         $this->view->setVar("idGender", $idGender);
    }
   
    public function editAction($idGender){
        $gender = Gender::findFirst(array(
            'conditions' => "idGender = ?1 ",
            'bind' => array(1 => $idGender)
        ));
        
        if (!$gender) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("gender");
        }
        
        $this->view->setVar("gender", $gender);
        
        if ($this->request->isPost()) {            
            try{                               
                $name = $this->request->getPost("name");
                                
                if( empty($name)){
                    $this->flashSession->error('No haz enviado un Nombre para identificar el Genero, por favor verifica la información');
                }
                else {
                    $gender->name = $name;                    
                    $gender->updatedon = time();
                    
                    if (!$gender->save()) {
                        foreach ($gender->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {                      
                        $this->flashSession->success("Se ha Modificado El Género Exitosamente");
                        return $this->response->redirect("gender/list"); 
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('gender/edit');
            }
        }   
    }
    
    public function changeimageAction($idGender){
        $gender = Gender::findFirst(array(
            'conditions' => "idGender = ?1 ",
            'bind' => array(1 => $idGender)
        ));
        
        if (!$gender) {
            $this->flashSession->error('No Existe el codigo');
            return $this->response->redirect("gender");
        }
        
        $this->view->setVar("gender", $gender);
        
        if ($this->request->isPost()) {            
            try{
                $permitidos = array("image/jpg");
                $limite_kb = 800;
                
                
                if ($_FILES["gender-cover"]["error"] > 0){
                    $this->flashSession->error('No haz enviado una imagen para identificar el género, por favor verifica la información');
                }
                else if (!in_array($_FILES['gender-cover']['type'], $permitidos) && $_FILES['imagen']['size'] > $limite_kb * 1024){
                    $this->flashSession->error('Haz enviado un tipo de imagen no soportado o una imagen demasiado pesada, la imagen debe pesar máximo 800 KB, por favor verifica la información');
                }
                
                else {
                                       
                    if (!$gender->save()) {
                        foreach ($gender->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {
                        $dir = "C:/Users/felipe.uribe.SIGMAMOVIL.000/Documents/NetbeansProjects/sigmamusicbox/public/assets/genders/images/" . $gender->idGender . "/" . $gender->idGender . ".jpg";
                        $this->deleteFolder($dir);
                        
                        $ruta = $dir .  ".jpg";

                        $resultado = @move_uploaded_file($_FILES["gender-cover"]["tmp_name"], $ruta);

                        if (!$resultado){
                            $this->flashSession->error("No se ha podido crear el género, por favor contacta al administrador");
                            return $this->response->redirect("gender/new");
                        }
                        
                        $this->flashSession->success("Se ha creado el género exitosamente");
                        return $this->response->redirect("gender/list"); 
                    }
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('gender/edit');
            }
        }   
    }
    
    private function deleteFolder($dir){
        if (!unlink($dir)){
            $this->logger->log("No Se pudo eliminar este archivo");
        }
    }
}
