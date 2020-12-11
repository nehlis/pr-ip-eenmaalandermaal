<?php

namespace App\Controllers;

use App\Interfaces\IController;
use App\Core\Database;
use Error;

/**
 * Class FileController
 * @package App\Controllers
 */
class FileController implements IController
{
    /**
     * @var Database    $database   Database class which contains all generic CRUD functions   
     */
    private $database;

    /**
     * @var string      $table      Table name on which the CRUD operations should apply.
     */
    private static $table = '[File]';


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
        $id = $this->database->create(self::$table, $data);
        if ($id) {
            return $this->get($id);
        }

        throw new Error('Afbeelding(en) niet toegevoegd!');
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

        throw new Error("Geen bestanden gevonden!");
    }

    /**
     * @param   int         $id     AuctionID to fetch images from
     * @return  array|null          A list of images from the auction
     */
    public function getByAuctionId(int $id): array
    {
        $result = $this->database->customQuery("SELECT * FROM " . self::$table . " WHERE ItemID = $id");

        if ($result) return $result;
        return [];
    }

    /**
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function index(): ?array
    {
        $result = $this->database->index(self::$table);

        if ($result) {
            return $result;
        }

        throw new Error("Geen Foto's gevonden!");
    }

    /**
     * @param int   $id
     * @param array $data
     * @return array|null
     * @throws Error     Throws error when execution failed.
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

        throw new Error("Afbeelding waarvan FileID = $id niet geupdate!");
    }

    /**
     * @param int $id
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function delete(int $id): ?array
    {
        if (!$item = $this->get($id)) {
            return null;
        }

        $result = $this->database->delete(self::$table, $id);

        if ($result) {
            return $item;
        }

        throw new Error("Afbeelding waarvan FileID = $id niet verwijderd!");
    }

    /**
     * @param int $id
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function deleteAllImagesByItemID(int $id): ?array
    {
        if (!$item = $this->get($id)) {
            return null;
        }

        $result = $this->database->customQuery("DELETE FROM [File] WHERE ItemID = " . $id);

        if ($result) {
            return $item;
        }

        throw new Error("Afbeelding(en) waarvan ItemID = $id niet verwijderd!");
    }
}
