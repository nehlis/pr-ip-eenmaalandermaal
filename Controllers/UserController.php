<?php

namespace Controllers;

use Interfaces\IController;
use Core\Database;

/**
 * User Controller
 * All CRUD operations
 * 
 */
class UserController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Account';
    

    public function __construct()
    {
        $this->database = new Database;
    }
    
    public function create(array $data): ?array
    {
        $this->database->create(self::$table, $data);
        
        return $this->database->getByColumn(self::$table, 'email', $data['email']);
    }

    public function get(int $id): ?array
    {
        return $this->database->get(self::$table, $id);
    }

    public function index(): ?array
    {
        return $this->database->index(self::$table);
    }

    public function update(int $id, array $data): ?array
    {
        if ($this->get($id)) {
            $this->database->update(self::$table, $id, $data);
        }
        
        return $this->get($id) ?? null;
    }

    public function delete(int $id): ?array
    {
        if ($user = $this->get($id)) {
            $this->database->delete(self::$table, $id);
        }
        
        return $user ?? null;
    }
}
