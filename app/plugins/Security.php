<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Mvc\Dispatcher;

class Security extends Plugin {
    public function __construct($dependencyInjector) {
        $this->_dependencyInjector = $dependencyInjector;
    }
    
    public function getAcl() {
        if (!$acl) {
                // No existe, crear objeto ACL
            $acl = $this->acl;
            $roles = Role::find();
            
            //Registrando roles
            foreach ($roles as $role){
                $acl->addRole(new Phalcon\Acl\Role($role->name));
            }

            //Registrando recursos
            $resources = array(
                'gender' => array('add', 'delete', 'update', 'read'),
                'importdata' => array('read','create','update'),
                'user' => array('read','create','update'),              
                'data' => array('read', 'download'),                
                'payment' => array('read', 'download'),
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
                
                'album::new' => array('album' => array('add')),
                'album::delete' => array('album' => array('delete')),
                'album::index' => array('album' => array('read')),
                'album::edit' => array('album' => array('update')),
                
                'song::new' => array('song' => array('add')),
                'song::delete' => array('song' => array('delete')),
                'song::index' => array('song' => array('read')),
                'song::edit' => array('song' => array('update')),
                
                'tools::index' => array('tools' => array('read')),               
                
                'index::index' => array('dashboard' => array('read')),
                
                
                
            );
            
            //$this->cache->save('controllermap-cache', $map);
        }
        
        return $map;
    }
    
    
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
        // ...
    }
}