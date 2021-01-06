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

        throw new Error('Verzoek niet ingediend!');
    }


    /**
     * @return array|null
     */
    public function getSellersToValidate(): ?array
    {
        $result = $this->database->customQuery("SELECT * FROM Seller INNER JOIN Account ON Seller.AccountID = Account.ID  WHERE AccountID in (SELECT ID FROM Account WHERE Seller = 0)");

        if ($result) {
            return $result;
        } else {
            return null;
        }
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        $result = $this->database->getByColumn(self::$table, 'AccountID', $id);
        if ($result) {
            return $result[0];
        } else {
            return [];
        }

        throw new Error("Verkoper met AccountID = $id niet gevonden!");
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

        throw new Error("Geen verkopers gevonden!");
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

    /**
     * @param int $id
     * @return array|null
     */
    public function deleteByAccountID(int $id): ?array
    {
        if (!$seller = $this->get($id)) {
            return null;
        }

        $result = $this->database->customQuery("DELETE FROM Seller WHERE AccountID = " . $id);

        if ($result) {
            return $seller;
        }

        throw new Error("Verkoper waarvan ID = $id niet verwijderd!");
    }
}
