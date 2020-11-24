<?php

namespace App\Controllers;

use App\Core\Database;
use App\Interfaces\IController;
use Error;

/**
 * Class QuestionController
 * @package App\Controllers
 */
class QuestionController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;
    
    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Question';
    
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
        // TODO: Implement create() method.
    }
    
    /**
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        // TODO: Implement get() method.
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
        // TODO: Implement update() method.
    }
    
    /**
     * @param int $id
     * @return array|null
     */
    public function delete(int $id): ?array
    {
        // TODO: Implement delete() method.
    }
}