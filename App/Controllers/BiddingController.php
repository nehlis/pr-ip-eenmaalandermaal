<?php

namespace App\Controllers;

use App\Core\Database;
use App\Interfaces\IController;
use Error;

/**
 * Class BiddingController
 * @package App\Controllers
 */
class BiddingController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Bidding';

    /**
     * BiddingController constructor.
     */
    public function __construct()
    {
        $this->database = new Database;
    }

    /**
     * @param   array       $data   Associative array with all bidding data (ItemID, AccountID, Time, Amount).
     * @return  array|null          Returns created bidding as array or null.
     * @throws  Error               Throws error when bidding could not be created.
     */
    public function create(array $data): ?array
    {
        $id = $this->database->create(self::$table, $data);

        if ($id) {
            return $this->get($id);
        }

        throw new Error("Bieding niet aangemaakt!");
    }

    /**
     * @param   int           $id   Get row where ID=$id
     * @return  array|null          Returns fetched row or null
     * @throws  Error               Throws error when no bidding is found.
     */
    public function get(int $id): ?array
    {
        $result = $this->database->get(self::$table, $id);

        if ($result) {
            return $result;
        }

        throw new Error("Bieding met id = $id niet gevonden!");
    }

    /**
     * @param int       $id     Get bidding 
     * @return array            Returns fetched rows or an empty array if no biddings are found
     */
    public function indexBiddingsWithUsernameByAuctionId(int $id): array
    {
        $result = $this->database->customQuery("SELECT B.*, A.Username
                                                FROM Bidding B
                                                LEFT JOIN Account A
                                                ON B.AccountID = A.ID
                                                WHERE B.ItemID = $id
                                                ORDER BY B.Amount DESC;");

        if ($result) return $result;
        return [];
    }

    /**
     * @return array|null           Returns array with all biddings
     * @throws  Error               Throws error when no biddings were found.
     */
    public function index(): ?array
    {
        $result = $this->database->index(self::$table);

        if ($result) {
            return $result;
        }

        throw new Error("Geen biedingen gevonden!");
    }

    /**
     * @param   int         $id     Update bidding where ID=$id
     * @param   array       $data   Associative array of which the key is the column name to be updated with its value.
     * @return  array|null          The updated bidding as an associative array
     * @throws  Error               Throws error when bidding is not found or when updating failed.
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

        throw new Error("Bieding waarvan ID = $id niet geupdate!");
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function delete(int $id): ?array
    {
        if (!$bidding = $this->get($id)) {
            return null;
        }

        $result = $this->database->delete(self::$table, $id);

        if ($result) {
            return $bidding;
        }

        throw new Error("Bieding waarvan ID = $id niet verwijderd!");
    }
}
