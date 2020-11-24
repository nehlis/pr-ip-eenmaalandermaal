<?php

namespace App\Controllers;

use App\Interfaces\IController;
use App\Core\Database;
use Error;

/**
 * User Controller
 * All CRUD operations
 * 
 */
class AccountController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Account';
    
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->database = new Database;
    }
    
    /**
     * @param array $data
     * @return array|null
     */
    public function create(array $data): ?array
    {
        $this->database->create(self::$table, $data);

        $result = $this->database->getByColumn(self::$table, 'email', $data['email']);

        if ((bool) $result) {
            return $result;
        } else {
            throw new Error ('test');
        }
    }
    
    /**
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        return $this->database->get(self::$table, $id);
    }
    
    /**
     * @return array|null
     */
    public function index(): ?array
    {
        return $this->database->index(self::$table);
    }
    
    /**
     * @param int   $id
     * @param array $data
     * @return array|null
     */
    public function update(int $id, array $data): ?array
    {
        if (!$this->get($id)) return null;
        
        $this->database->update(self::$table, $id, $data);
        
        return $this->get($id);
    }
    
    /**
     * @param int $id
     * @return array|null
     */
    public function delete(int $id): ?array
    {
        if (!$user = $this->get($id)) return null;
    
        $this->database->delete(self::$table, $id);
    
        return $user;
    }
}
