<?php

namespace Core;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /**
     * @var mixed
     */
    private $request;
    
    /**
     * @var
     */
    private $baseDir;
    
    /**
     * @var string[]
     */
    private $routes = [
        '/'            => 'home',
        ''             => 'home',
        '/inloggen'    => 'login',
        '/registreren' => 'register',
        'default'      => '404',
    ];
    
    /**
     * Router constructor.
     * @param $baseDir
     */
    public function __construct($baseDir)
    {
        $this->request = $_SERVER['REQUEST_URI'];
        $this->baseDir = $baseDir;
        $this->check();
    }
    
    /**
     * Check if route matches
     */
    private function check()
    {
        foreach ($this->routes as $key => $route) {
            if ($this->request === $key) {
                require $this->baseDir . '/views/' . $route . '.php';
                
                return;
            }
        }
    }
}