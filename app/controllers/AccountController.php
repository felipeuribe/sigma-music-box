<?php

use Phalcon\Mvc\Controller;

class AccountController extends Controller{
    
    public function indexAction(){
           
    }
    public function signupAction(){
        
        if ($this->request->isPost()) {            
            try{
                $name = $this->request->getPost("name");
                $lastName = $this->request->getPost("lastName");
                $email = $this->request->getPost("email");
                $password = $this->request->getPost("password");
                $password2 = $this->request->getPost("password2");
                $username = $this->request->getPost("username");
               
                if( empty($name)){
                    $this->flashSession->error('No ha enviado el nombre del usuario ');
                }
                else if( empty($lastName)){
                    $this->flashSession->error('No ha enviado el Apellido del usuario ');
                }
                else if( empty($email)){
                    $this->flashSession->error('No ha enviado un Correo Electrónico del usuario ');
                }
                else if( empty($password)){
                    $this->flashSession->error('No ha enviado una Contraseña  del usuario ');
                }
                else if( ($password) != ($password2)){
                    $this->flashSession->error('No Coinciden las Contraseñas Por Favor Validar la información ');
                }  
                else if( empty($username)){
                    $this->flashSession->error('No ha enviado un nombre  del usuario en el Sistema ');
                }
                else{
                    $credential = new Credentials();
                    $credential->userName = $username;
                    $credential->password = $this->hash->hash($password);
                    $credential->createdon = time();
                    $credential->updatedon = time();
                    
                    if (!$credential->save()) {
                        foreach ($credential->getMessages() as $msg) {
                            $this->logger->log($msg);        
                        }
                    }
                    else {       
                        $user = new User();
                        $user->name = $name;
                        $user->idRole = 2;
                        $user->idCredentials = $credential->idCredentials;                        
                        $user->lastName = $lastName;
                        $user->email = $email;   
                        $user->createdon = time();
                        $user->updatedon = time();  
                        
                        if (!$user->save()) {
                            foreach ($user->getMessages() as $msg) {
                                $this->logger->log($msg);        
                            }
                        }                        
                        $this->flashSession->success("Se ha Registrado Con Exito El Nuevo Usuario");
                        $this->response->redirect('account/login');
                    }  
                }
            }
            catch (Exception $ex){
                $this->flashSession->error("Ha Ocurrido Un Error");
                $this->response->redirect('account/signup');
            }
        }           
    }
    
    public function loginAction(){
        if ($this->request->isPost()) {
            $userName = $this->request->getPost('userName');
            $password = $this->request->getPost('password');

            $credential = Credentials::findFirst(array(
                'conditions' => "userName = ?1 ",
                'bind' => array(1 => $userName)
            ));
            
            if(empty($userName)){
                    $this->flashSession->error('No ha enviado un usuario , por favor valide la información');
            }
            else if(empty($password)){
                $this->flashSession->error('No ha enviado una Contraseña , por favor valide la información');
            }

            else if ($credential) {

                if ($this->hash->checkHash($password, $credential->password)) {   

                    $user = User::findFirst(array(
                        'conditions' => "idCredentials = ?1 ",
                        'bind' => array(1 => $credential->idCredentials)
                    ));  
                    
                    if ($user) {
                        $this->session->set("authenticated", true);
                        $this->session->set("idUser", $user->idUser);
                    }
                   
                    
                    
                    return $this->response->redirect("");
                }
                else{
                   $this->flashSession->error("La Contraseña es Incorrecta");
                }
            } 
            else {            
                $this->flashSession->error("El nombre de usuario es incorrecto por favor validar la informacion");
            }
        }
    }

    public function logoutAction(){
        $this->session->destroy("authenticated");
        $this->session->destroy("idUser");
        return $this->response->redirect("");   
    }
    
    
}
