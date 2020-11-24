<?php

namespace App\Controllers;

use App\Core\Database;
use App\Interfaces\IController;
use Error;

class CountryController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;
    
    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Country';
    
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->database = new Database;
    }
    
    public function create(array $data): ?array
    {
        // TODO: Implement create() method.
    }
    
    public function get(int $id): ?array
    {
        // TODO: Implement get() method.
    }
    
    public function index(): ?array
    {
        return $this->database->index(self::$table);
    }
    
    public function update(int $id, array $data): ?array
    {
        // TODO: Implement update() method.
    }
    
    public function delete(int $id): ?array
    {
        // TODO: Implement delete() method.
    }
}