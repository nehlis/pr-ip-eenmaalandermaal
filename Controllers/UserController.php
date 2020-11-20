<?php

namespace Controllers;

use Interfaces\IController;
use Core\Database;
use Error;

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
        $this->database = new Database();
    }

    public function create(array $data): ?array
    {
        try {
            $this->database->create(self::$table, $data);
            return $this->database->getByColumn(self::$table, 'email', $data['email']);
        } catch (Error $error) {
            throw new Error("Gebruiker kon niet aangemaakt worden!");
        }
    }

    public function get(int $id): ?array
    {
        try {
            return $this->database->get(self::$table, $id);
        } catch (Error $error) {
            throw new Error("Gebruiker, waarvan ID = $id, niet gevonden!");
        }
    }

    public function index(): ?array
    {
        try {
            return $this->database->index(self::$table);
        } catch (Error $error) {
            throw new Error("Geen gebruikers gevonden!");
        }
    }

    public function update(int $id, array $data): ?array
    {
        // First check if item exists.
        $this->get($id);

        try {
            $this->database->update(self::$table, $id, $data);
            return $this->get($id);
        } catch (Error $error) {
            throw new Error("Gebruiker, waarvan ID = $id, niet geupdate!");
        }
    }

    public function delete(int $id): ?array
    {
        // First check if item exists.
        $user = $this->get($id);

        try {
            $this->database->delete(self::$table, $id);
            return $user;   // Return deleted user when success.
        } catch (Error $error) {
            throw new Error("Gebruiker, waarvan ID = $id, niet verwijderd!");
        }
    }
}
