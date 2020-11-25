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
class PhonenumberController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Phonenumber';

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
     * @throws Error     Throws error when execution failed.
     */
    public function create(array $data): ?array
    {
        // TODO: Implement create() method.
        return [];
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        $result = $this->database->get(self::$table, $id);

        if ($result) {
            return $result;
        }

        throw new Error("Geen telefoonnummers gevonden!");
    }

    /**
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function index(): ?array
    {
        // TODO: Implement update() method.
        return [];
    }

    /**
     * @param int   $id
     * @param array $data
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function update(int $id, array $data): ?array
    {
        // TODO: Implement update() method.
        return [];
    }

    /**
     * @param int $id
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function delete(int $id): ?array
    {
        // TODO: Implement update() method.
        return [];
    }
}
