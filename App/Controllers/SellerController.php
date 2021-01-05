<?php

namespace App\Controllers;

use App\Core\Database;
use App\Interfaces\IController;
use Error;

/**
 * Class SellerController
 * @package App\Controllers
 */
class SellerController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Seller';

    /**
     * SellerController constructor.
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
        $id = $this->database->create(self::$table, $data);

        if ($id) {
            return $this->get($id);
        }

        throw new Error('Account niet aangemaakt!');
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        $result = $this->database->getByColumn(self::$table, 'AccountID', $id)[0];
        if ($result) {
            return $result;
        } else {
            return null;
        }

        throw new Error("Account met id = $id niet gevonden!");
    }

    /**
     * @return array|null
     */
    public function index(): ?array
    {
        $result = $this->database->index(self::$table);

        if ($result) {
            return $result;
        }

        throw new Error("Geen vragen gevonden!");
    }

    /**
     * @param int   $id
     * @param array $data
     * @return array|null
     */
    public function update(int $id, array $data): ?array
    {
        if (!$this->get($id)) {
            return null;
        }

        $result = $this->database->update(self::$table, $id, $data);

        if ($result) {
            return $this->get($id);
        }

        throw new Error("Verkoper waarvan ID = $id niet geupdate!");
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function delete(int $id): ?array
    {
        if (!$seller = $this->get($id)) {
            return null;
        }

        $result = $this->database->delete(self::$table, $id);

        if ($result) {
            return $seller;
        }

        throw new Error("Verkoper waarvan ID = $id niet verwijderd!");
    }
}
