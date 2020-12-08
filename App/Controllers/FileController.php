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
    private static $table = 'File';


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

        throw new Error('Bestand niet geregistreerd!');
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function get(int $id): ?array
    {
        $result = $this->database->get(self::$table, $id);

        if ($result) return $result;

        throw new Error("Geen bestanden gevonden!");
    }

    /**
     * @param   int         $id     AuctionID to fetch images from
     * @return  array|null          A list of images from the auction
     * @throws  Error               Throws error when auction has no images
     */
    public function getByAuctionId(int $id): ?array
    {
        $result = $this->database->customQuery("SELECT * FROM [" . self::$table . "] WHERE ItemID = $id");

        if ($result) return $result;

        throw new Error("Geen bestanden beschikbaar bij deze veiling!");
    }

    /**
     * @return array|null
     * @throws Error     Throws error when execution failed.
     */
    public function index(): ?array
    {
        // TODO: Implement index() method.
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
        // TODO: Implement delete() method.
        return [];
    }
}
