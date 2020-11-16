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
    private static $baseDir;
    
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
     * @param $dir
     */
    public function __construct($dir)
    {
        self::setBaseDir($dir);
        
        $this->request = $_SERVER['REQUEST_URI'];
        $this->check();
    }
    
    /**
     * Sets the project's base dir.
     * @param mixed $baseDir
     */
    public static function setBaseDir($baseDir): void
    {
        self::$baseDir = $baseDir;
    }
    
    /**
     * Returns the project's base dir.
     * @return mixed
     */
    public static function getBaseDir()
    {
        return self::$baseDir;
    }
    
    /**
     * Check if route matches
     */
    private function check()
    {
        foreach ($this->routes as $route => $view) {
            if ($this->request === $route) {
                View::render($view);
            }
        }
    }
}