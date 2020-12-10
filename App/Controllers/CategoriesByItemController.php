<?php

namespace App\Controllers;

use App\Interfaces\IController;
use App\Core\Database;
use Error;

/**
 * Item Controller
 * All CRUD operations
 * 
 */
class CategoriesByItemController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'CategoriesByItem';

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        $this->database = new Database;
    }


    /**
     * @param   array       $data   Associative array with all Item  data (Title, Description, City, CountryID, StartingPrice, StartDate, EndDate, PaymentMethod, PaymentInstructions, ShippingCosts, SendInstructions, SellerID).
     * @return  array|null          Returns created Item  as array or null.
     * @throws  Error               Throws error when Item  could not be created.
     */
    public function create(array $data): ?array
    {
        $id = $this->database->create(self::$table, $data);

        if ($id) {
            return $this->get($id);
        }

        throw new Error('Categorieën bij item niet aangemaakt!');
    }


      /**
     * @param   int           $id   Get row where ID=$id
     * @return  array|null          Returns fetched row or null
     * @throws  Error               Throws error when no item is found.
     */
    public function get(int $id): ?array
    {
        $result = $this->database->get(self::$table, $id);

        if ($result) {
            return $result;
        }

        throw new Error("Categorieën in Item met id = $id niet gevonden!");
    }

    /**
     * @return array|null   Returns array with all iterms
     * @throws  Error               Throws error when no items were found.
     */
    public function index(): ?array
    {
        $result = $this->database->index(self::$table);

        if ($result) {
            return $result;
        }

        throw new Error("Geen Categorieën bij items gevonden!");
    }


     /**
     * @param   int         $id     Update Category In item where ID=$id
     * @param   array       $data   Associative array of which the key is the column name to be updated with its value.
     * @return  array|null          The updated item as an associative array
     * @throws  Error               Throws error when item is not found or when updating failed.
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

        throw new Error("Categorieën waarvan ID = $id niet geupdate!");
    }

    /**
     * @param int           $id     Delete Category in Item with ID=$id
     * @return array|null           The deleted item as an associative array
     * @throws  Error               Throws error when item is not found or when updating failed.
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

}
