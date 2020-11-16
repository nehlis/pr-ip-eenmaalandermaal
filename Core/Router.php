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
    public static $base;
    
    /**
     * @var string[]
     */
    private $routes = [
        '/'            => 'home',
        ''             => 'home',
        '/inloggen'    => 'login',
        '/registreren' => 'register',
    ];
    
    /**
     * Router constructor.
     * @param $dir
     */
    public function __construct($dir)
    {
        self::$base    = $dir;
        $this->request = $_SERVER['REQUEST_URI'];
        
        $this->check();
    }
    
    /**
     * Check if route matches and render matching view.
     */
    private function check(): void
    {
        foreach ($this->routes as $route => $view) {
            if ($this->request === $route) {
                View::render($view);
                return;
            }
        }
        
        View::render('404');
    }
}