<?php

namespace App\Controllers;

use App\Core\Database;
use App\Interfaces\IController;
use Error;

/**
 * Class CategoryController
 * @package App\Controllers
 */
class CategoryController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string      $table      Table name on which the CRUD operations should apply.
     */
    private static $table = 'Category';

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
     */
    public function create(array $data): ?array
    {
        $id = $this->database->create(self::$table, $data);
        if ($id) {
            return $this->get($id);
        }

        throw new Error('Categorie niet toegevoegd!');
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

        throw new Error("Geen categorie gevonden!");
    }

    /**
     * Gets all categories in an associative format.
     * @return array|null
     */
    public function index(): ?array
    {
        $result = $this->database->customQuery(
            "SELECT
            L1.ID AS Level1ID,
            L1.Name AS Level1Name,
            L2.ID AS Level2ID,
            L2.Name AS Level2Name,
            L3.ID AS Level3ID,
            L3.Name AS Level3Name,
            L4.ID AS Level4ID,
            L4.Name AS Level4Name,
            L5.ID AS Level5ID,
            L5.Name AS Level5Name
            FROM Category AS L1
            LEFT JOIN Category AS L2 ON L2.ParentID = L1.ID
            LEFT JOIN Category AS L3 ON l3.ParentID = l2.ID
            LEFT JOIN Category AS L4 ON l4.ParentID = l3.ID
            LEFT JOIN Category AS L5 ON l5.ParentID = l4.ID
            WHERE L1.ParentID = -1
            ORDER BY L1.ID, L2.ID, L3.ID"
        );

        if (!$result) {
            throw new Error("Er is iets misgegaan bij het ophalen van de categorieën");
        }

        return $result;
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

        throw new Error("Categorie waarvan ID = $id niet geupdate!");
    }

    /**
     * Delete function
     * @param int $id
     * @return array|null
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

        throw new Error("Categorie waarvan ID = $id niet verwijderd!");
    }

    /** EXTRA FUNCTIONS */

    /**
     * Function that returns all valid categories needed for the 'veiling toevoegen' page.
     * @return array|null    Correct formatted categories as an associative array.
     * @throws Error         Throws an error when no categories have been found.
     */
    public function getDatalist(): ?array
    {
        $result = $this->database->customQuery("SELECT DISTINCT C.ID, C.Name
                                                FROM Category C
                                                    LEFT JOIN  Category C2 on C2.ParentID = C.ID
                                                WHERE C2.ParentID IS NULL");

        if (isset($result) && count($result) > 0) {
            return $result;
        }

        throw new Error("Geen categorieen gevonden!");
    }

    public function getRandomItems(): ?array
    {
        $result = $this->database->customQuery("SELECT TOP 8 C.ID, C.Name, I.Thumbnail FROM Category C
                                                INNER JOIN CategoriesByItem CBI on C.ID = CBI.CategoryID
                                                INNER JOIN Item I on I.ID = CBI.ItemID
                                                ORDER BY NEWID()");

        if ($result) {
            return $result;
        }

        throw new Error("Items niet gevonden!");
    }
}
