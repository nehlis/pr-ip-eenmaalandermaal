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
class ItemController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Item';

    /**
     * ItemController constructor.
     */
    public function __construct()
    {
        $this->database = new Database;
    }

    /**
     * @param   array       $data   Associative array with all Item  data (Title, Description, City, CountryID, StartingPrice, StartDate, EndDate, PaymentMethod, PaymentInstructions, ShippingCosts, SendInstructions, SellerID, ItemCategoryID).
     * @return  array|null          Returns created Item  as array or null.
     * @throws  Error               Throws error when Item  could not be created.
     */
    public function create(array $data): ?array
    {
        $id = $this->database->create(self::$table, $data);

        if ($id) {
            return $this->get($id);
        }

        throw new Error('Item niet aangemaakt!');
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

        throw new Error("Item met id = $id niet gevonden!");
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

        throw new Error("Geen Items gevonden!");
    }

    /**
     * @param   int         $id     Update item where ID=$id
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

        throw new Error("Item waarvan ID = $id niet geupdate!");
    }

    /**
     * @param int           $id     Delete item with ID=$id
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

        throw new Error("Item waarvan ID = $id niet verwijderd!");
    }


    /**
     * Ensures that the auction is set to closed
     * @param int           $id ID from Item
     * @param int           $buyerID ID from buyer
     * @param float         $sellingPrice The celling price
     * @return void
     * @throws Error  
     */
    public function handleSold(int $id, int $buyerID, float $sellingPrice): void
    {
        $item = $this->get($id);

        $result = $this->database->update(self::$table, $id, [
            'AuctionClosed' => !$item['AuctionClosed'],
            'SellingPrice' => $sellingPrice,
            'BuyerID' => $buyerID,
        ]);

        if (!$result) {
            throw new Error("Item status niet gewijzigd!");
        }
    }


    /**
     * @param int                   Update item view with 1 by ID=$id
     * @return array|null           The updated item as an associative array
     * @throws  Error               Throws error when item is not found or when updating failed.
     */
    public function increaseViews(int $id): ?array
    {
        if (!$item = $this->get($id)) {
            return null;
        }

        $result = $this->database->update(self::$table, $id, ['Views' => ++$item['Views']]);

        if ($result) {
            return $item;
        }

        throw new Error("Item waarvan ID = $id niet verwijderd!");
    }

    /**
     * @param   int                 Amount of items
     * @return  array|null          Returns fetched row or null
     * @throws  Error               Throws error when no item is found.
     */
    public function getFeaturedItems(int $amountItems): ?array
    {
        $result = $this->database->customQuery("SELECT Item.*, Temp1.Amount FROM (
            SELECT TOP $amountItems Item.ID, MAX(B.Amount) AS Amount FROM Item
            LEFT JOIN Bidding B on Item.ID = B.ItemID
            WHERE Item.AuctionClosed = 'false' AND Item.StartDate < GETDATE() AND Item.EndDate > GETDATE()
            GROUP BY Item.ID) AS Temp1
            LEFT JOIN Item ON Item.ID = Temp1.ID
            ORDER BY Item.Views  DESC 
            ");

        if ($result) {
            return $result;
        }

        throw new Error("Geen uitgelichte items gevonden...");
    }
}
