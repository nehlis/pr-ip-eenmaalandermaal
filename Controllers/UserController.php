<?php

namespace Controllers;

use Core\Database;
use Interfaces\IController;
use Models\User;

/**
 * Class UserController
 */
class UserController implements IController
{
    /**
     * @var Database
     */
    private $database;
    
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }
    
    /**
     * Returns all users.
     * @return array
     */
    public function index(): array
    {
        return $this->database->index(User::$table);
    }
    
    /**
     * Creates a User.
     * @param array $args
     * @return void
     */
    public function create(array $args): void
    {
        $this->database->create($args, new User());
    }
    
    /**
     * Returns a single user.
     * @param int $id
     * @return User
     */
    public function get(int $id)
    {
        $user = $this->database->get(User::$table, $id);
        
        return new User($user);
    }
    
    /**
     * Edits a single user.
     * @param array $args
     * @param int   $id
     * @return mixed
     */
    public function put(array $args, int $id)
    {
        $this->database->update(User::$table, $args, $id);
        
        $user = $this->database->get(User::$table, $id);
        
        return new User($user);
    }
    
    /**
     * Deletes a single user.
     * @param int $id
     * @return mixed
     */
    public function delete(int $id): void
    {
        $this->database->delete(User::$table, $id);
    }
}