<?php

use Phalcon\Loader;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

try {

    // Módulo de registro de carpetas del proyecto
    $loader = new Loader();
    $loader->registerDirs(array(
        '../app/controllers/',
        '../app/models/',
        '../app/plugins/',
    ))->register();

    // Create a DI
    $di = new FactoryDefault();

    // Configuramos el acceso a la base datos
    $di->set('db', function () {
        return new DbAdapter(array(
            "host"     => "localhost",
            "username" => "root",
            "password" => "",
            "dbname"   => "sigmaMusicBox"
        ));
    });
    
    
    // Módulo de compilador de archivos .volt
    $di->setShared('volt', function($view, $di) {
        $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);

        $volt->setOptions(array(
            "compileAlways" => true,
            "compiledPath" => "../app/compiled-templates/",
            'stat' => true
        ));

        return $volt;
    });
    
    // Módulo de registro de las vistas
    $di->set('view', function() {
        $view = new \Phalcon\Mvc\View();
        $view->setViewsDir('../app/views/');
        $view->registerEngines(array(
            ".volt" => 'volt'
        ));
        return $view;
    });

    // Módulo que administra las URL's
    $di->set('url', function () {
        $url = new UrlProvider();
        $url->setBaseUri('/sigmamusicbox/');
        return $url;
    });
    
    // Módulo de cookies o variables de sessión
    $di->setShared('session', function() {
        $session = new \Phalcon\Session\Adapter\Files(
          array(
           'uniqueId' => 'sigmamusicbox'
        ));
        $session->start();
        return $session;
    });
    
    
    $di->setShared('hash', function () {
        $security = new \Phalcon\Security();
        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);
        return $security;
    });
    
    // Módulo de mensajes
    $di->set('flashSession', function () {
        $flash = new Phalcon\Flash\Session(
            array(
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            )
        );

        return $flash;
    });
    // Módulo del archivo de logs 
    $di->set('logger', function () {
        return new \Phalcon\Logger\Adapter\File("../app/logs/debug.log");
    });
    
    $di->set('dispatcher', function() use ($di) {

       $eventsManager = $di->getShared('eventsManager');

       $security = new \Security($di);
       /**
        * We listen for events in the dispatcher using the Security plugin
        */
       $eventsManager->attach('dispatch', $security);

       $dispatcher = new \Phalcon\Mvc\Dispatcher();
       $dispatcher->setEventsManager($eventsManager);

       return $dispatcher;
    });
    
    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}