<?php

namespace Controllers;

use Interfaces\IController;
use Core\Database;

/**
 * User Controller
 * All CRUD operations
 * 
 * TODO: Add feedback for every function.
 */
class UserController implements IController
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function create(array $data): void
    {
        $this->database->create('test', $data);
    }


    public function get(int $id): array
    {
        return $this->database->get('test', $id);
    }


    public function index(): array
    {
        return $this->database->index('test');
    }


    public function update(int $id, array $data): void
    {
        $this->database->update('test', $id, $data);
    }


    public function delete(int $id): void {
        $this->database->delete('test', $id);
    }
}
