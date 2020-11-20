<?php

namespace Controllers;

use Interfaces\IController;
use Core\Database;
use Error;

/**
 * User Controller
 * All CRUD operations
 * 
 * TODO: Errors die nu gethrowd worden zijn niet concreet (Alle errors worden opnieuw gethrowd onder 1 error). Misschien concreet maken?
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
    private $table;

    public function __construct()
    {
        $this->database = new Database();
        $this->table = 'Account';
    }

    public function create(array $data): array
    {
        try {
            $this->database->create($this->table, $data);
            return $this->database->getByColumn($this->table, 'email', $data['email']);
        } catch (Error $error) {
            throw new Error("Gebruiker kon niet aangemaakt worden!");
        }
    }

    public function get(int $id): array
    {
        try {
            return $this->database->get($this->table, $id);
        } catch (Error $error) {
            throw new Error("Gebruiker, waarvan ID = $id, niet gevonden!");
        }
    }

    public function index(): array
    {
        try {
            return $this->database->index($this->table);
        } catch (Error $error) {
            throw new Error("Geen gebruikers gevonden!");
        }
    }

    public function update(int $id, array $data): array
    {
        // First check if item exists.
        $this->get($id);

        try {
            $this->database->update($this->table, $id, $data);
            return $this->get($id);
        } catch (Error $error) {
            throw new Error("Gebruiker, waarvan ID = $id, niet geupdate!");
        }
    }

    public function delete(int $id): array
    {
        // First check if item exists.
        $user = $this->get($id);

        try {
            $this->database->delete($this->table, $id);
            return $user;   // Return deleted user when success.
        } catch (Error $error) {
            throw new Error("Gebruiker, waarvan ID = $id, niet verwijderd!");
        }
    }
}
