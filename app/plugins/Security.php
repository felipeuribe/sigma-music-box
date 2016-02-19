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
                'dashboard' => array('read'),
                'importdata' => array('read','create','update'),
                'user' => array('read','create','update'),              
                'data' => array('read', 'download'),                
                'payment' => array('read', 'download'),
            );
            
            foreach ($resources as $resource => $actions) {
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }
            
            // admin
            $acl->allow("admin", "dashboard", "read");           
            $acl->allow("admin", "importdata", "read");           
            $acl->allow("admin", "importdata", "create");
            $acl->allow("admin", "importdata", "update");
            $acl->allow("admin", "user", "read");
            $acl->allow("admin", "user", "create");
            $acl->allow("admin", "user", "update");
            $acl->allow("admin", "data", "read");
            $acl->allow("admin", "data", "download");
            $acl->allow("admin", "payment", "read");
            $acl->allow("admin", "payment", "download");
            
            // user
            $acl->allow("user", "dashboard", "read");   
            $acl->allow("user", "user", "read");
            $acl->allow("user", "user", "create");
            $acl->allow("user", "user", "update");
            $acl->allow("user", "data", "read");
            $acl->allow("user", "data", "download");
            $acl->allow("user", "payment", "read");
            $acl->allow("user", "payment", "download");

            //$this->cache->save('acl-cache', $acl);
        }

        // Retornar ACL
        $this->_dependencyInjector->set('acl', $acl);
        
        return $acl;
    }
    
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {
        // ...
    }
}