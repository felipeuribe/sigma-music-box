<?php

use Phalcon\Events\Event,
        Phalcon\Mvc\User\Plugin,
        Phalcon\Mvc\Dispatcher;
use Phalcon\Acl\Adapter\Memory as AclList;

class Security extends Plugin {
    public function __construct($dependencyInjector) {
        $this->_dependencyInjector = $dependencyInjector;
    }
    
    public function getAcl() {
        if (!$acl) {
                // No existe, crear objeto ACL
            $acl = new AclList();
            $roles = Role::find();
            
            //Registrando roles
            foreach ($roles as $role){
                $acl->addRole(new Phalcon\Acl\Role($role->name));
            }

            //Registrando recursos
            $resources = array(
                'artist' => array('add', 'delete', 'update', 'read'),
                'gender' => array('add', 'delete', 'update', 'read'),
                'album' => array('add', 'delete', 'update', 'read'),
                'song' => array('add', 'delete', 'update', 'read'),
                'tools' => array('read'),
                'player' => array('play'),
                'dashboard' => array('read'),
                
            );
            
            foreach ($resources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }
            
            // admin
            $acl->allow("admin", "gender", "add");           
            $acl->allow("admin", "gender", "delete");           
            $acl->allow("admin", "gender", "read");
            $acl->allow("admin", "gender", "update");
            $acl->allow("admin", "artist", "add");           
            $acl->allow("admin", "artist", "delete");           
            $acl->allow("admin", "artist", "read");
            $acl->allow("admin", "artist", "update");
            $acl->allow("admin", "album", "add");           
            $acl->allow("admin", "album", "delete");           
            $acl->allow("admin", "album", "read");
            $acl->allow("admin", "album", "update");
            $acl->allow("admin", "song", "add");           
            $acl->allow("admin", "song", "delete");           
            $acl->allow("admin", "song", "read");
            $acl->allow("admin", "song", "update");
            $acl->allow("admin", "tools", "read");
            $acl->allow("admin", "player", "play");
            
            // user
            $acl->allow("user", "gender", "read"); 
            $acl->allow("user", "artist", "read"); 
            $acl->allow("user", "album", "read"); 
            $acl->allow("user", "song", "read"); 
            $acl->allow("user", "player", "play"); 
            

            //$this->cache->save('acl-cache', $acl);
        }

        // Retornar ACL
        $this->_dependencyInjector->set('acl', $acl);
        
        return $acl;
    }
    
    protected function getControllerMap() {
        if (!$map) {
            $map = array(
            /* Public resources */    
                /* Error views */
                'error::index' => array(),
                /* Session */
                'account::signup' => array(),
                'account::logout' => array(),
                'account::login' => array(),
                
            /* Private resources */
                /* Dashboard */
                'artist::new' => array('artist' => array('add')),
                'artist::delete' => array('artist' => array('delete')),                
                'artist::index' => array('artist' => array('read')),
                'artist::edit' => array('artist' => array('update')),                
                'artist::artistalbum' => array('artist' => array('read')),
                'artist::list' => array('artist' => array('read')),  
                'artist::confirm' => array('artist' => array('delete')),                
                'artist::changeimage' => array('artist' => array('update')),
                'artist::deletefolder' => array('artist' => array('delete')),
                'artist::deletedirectory' => array('artist' => array('delete')),                
                
                'gender::new' => array('gender' => array('add')),
                'gender::delete' => array('gender' => array('delete')),                
                'gender::index' => array('gender' => array('read')),
                'gender::edit' => array('gender' => array('update')),
                'gender::list' => array('gender' => array('read')),  
                'gender::confirm' => array('gender' => array('delete')),                
                'gender::changeimage' => array('gender' => array('update')),
                'gender::deletefolder' => array('gender' => array('delete')),
                'gender::deletedirectory' => array('gender' => array('delete')),                
                
                'album::new' => array('album' => array('add')),
                'album::delete' => array('album' => array('delete')),                
                'album::index' => array('album' => array('read')),
                'album::edit' => array('album' => array('update')),
                'album::albumsong' => array('album' => array('read')), 
                'album::list' => array('album' => array('read')),  
                'album::confirm' => array('album' => array('delete')),                
                'album::changeimage' => array('album' => array('update')),
                'album::deletefolder' => array('album' => array('delete')),
                'album::deletedirectory' => array('album' => array('delete')),                
                
                'song::new' => array('song' => array('add')),
                'song::delete' => array('song' => array('delete')),                
                'song::index' => array('song' => array('read')),
                'song::edit' => array('song' => array('update')),                
                'song::list' => array('song' => array('read')),  
                'song::confirm' => array('song' => array('delete')),                
                'song::changeimage' => array('song' => array('update')),
                'song::deletefolder' => array('song' => array('delete')),
                'song::deletedirectory' => array('song' => array('delete')),
                
                'index::index' => array('dashboard' => array('read')),
                
                'tools::index' => array('tools' => array('read')), 
            
            );
            
            //$this->cache->save('controllermap-cache', $map);
        }        
        return $map;
    }
    
    
    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher) {
        $controller = \strtolower($dispatcher->getControllerName());
        $action = \strtolower($dispatcher->getActionName());
        $resource = "$controller::$action";

       
        $role = 'guest';
        if ($this->session->get('authenticated')) {
            $user = User::findFirstByIdUser($this->session->get('idUser'));
            if ($user) {
                $role = Role::findFirst(array(
                    "conditions" => "idRole = ?0",
                    "bind" => array($user->idRole)
                ));

                // Inyectar el usuario
                $this->_dependencyInjector->set('user', $user);
            }
        }

        $map = $this->getControllerMap();

        $this->publicurls = array(
             /* Error views */
            'error::index',
            /* Session */
            'account::signup',
            'account::login',
            'account::logout',
        );

        if ($role == 'guest') {
            if (!in_array($resource, $this->publicurls)) {
                $this->response->redirect("account/login");
                return false;
            }
        }
        else {
            if ($resource == 'account::login') {
                $this->response->redirect("index");
                return false;
            }
            else {
                $acl = $this->getAcl();
                $this->logger->log("Validando el usuario con rol [$role->name] en [$resource]");

                if (!isset($map[$resource])) {
                    $this->logger->log("El recurso no se encuentra registrado");
                    $dispatcher->forward(array('controller' => 'error', 'action' => 'index'));
                    return false;
                }

                $reg = $map[$resource];

                foreach($reg as $resources => $actions){
                    foreach ($actions as $act) {
                        if (!$acl->isAllowed($role->name, $resources, $act)) {
                            $this->logger->log('Acceso denegado');
                            $dispatcher->forward(array('controller' => 'error', 'action' => 'error'));
                            return false;
                        }
                    }
                }                
                return true;
            }
        }	
    }

}