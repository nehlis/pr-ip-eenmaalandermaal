<?php

namespace App\Controllers;

use App\Interfaces\IController;
use App\Core\Database;
use Error;

/**
 * User Controller
 * All CRUD operations
 *
 */
class AccountController implements IController
{
    /**
     * @var Database $database Database class which contains all generic CRUD functions.
     */
    private $database;

    /**
     * @var string $table Table name on which the CRUD operations should apply.
     */
    private static $table = 'Account';

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->database = new Database;
    }

    /**
     * @param   array       $data   Associative array with all account data (Firstname, Lastname, Password, Street, Housenumber, Zipcode, City,   Country, QuestionID, QuestionAnswer, Birthday).
     * @return  array|null          Returns created account as array or null.
     * @throws  Error               Throws error when account could not be created.
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
     * @param   int           $id   Get row where ID=$id
     * @return  array|null          Returns fetched row or null
     * @throws  Error               Throws error when no account is found.
     */
    public function get(int $id): ?array
    {
        $result = $this->database->get(self::$table, $id);

        if ($result) {
            return $result;
        }

        throw new Error("Account met id = $id niet gevonden!");
    }

    /**
     * @return array|null   Returns array with all users
     * @throws  Error               Throws error when no accounts were found.
     */
    public function index(): ?array
    {
        $result = $this->database->index(self::$table);

        if ($result) {
            return $result;
        }

        throw new Error("Geen accounts gevonden!");
    }

    /**
     * @param   int         $id     Update user where ID=$id
     * @param   array       $data   Associative array of which the key is the column name to be updated with its value.
     * @return  array|null          The updated user as an associative array
     * @throws  Error               Throws error when account is not found or when updating failed.
     */
    public function update(int $id, array $data): ?array
    {
        if (!$this->get($id)) {
            return null;
        }

        $result = $this->database->update(self::$table, $id, $data);

        if ($result) {
            $_SESSION['name'] = "{$data['Firstname']} {$data['Inserts']} {$data['Lastname']}";
            return $this->get($id);
        }

        throw new Error("Account waarvan ID = $id niet geupdate!");
    }

    /**
     * @param int           $id     Delete user with ID=$id
     * @return array|null           The deleted user as an associative array
     * @throws  Error               Throws error when account is not found or when updating failed.
     */
    public function delete(int $id): ?array
    {
        if (!$user = $this->get($id)) {
            return null;
        }

        $result = $this->database->delete(self::$table, $id);

        if ($result) {
            return $user;
        }

        throw new Error("Account waarvan ID = $id niet verwijderd!");
    }

    /**
     * Gets the question that belongs to the account.
     * @param int $id
     * @return array|null
     */
    public function getQuestion(int $id): ?array
    {
        $questionId = $this->database->get(self::$table, $id)['QuestionID'];
        $question   = $this->database->get('Question', $questionId);

        return $questionId && $question ? $question : null;
    }

    /**
     * Gets the phone numbers that belong to the account.
     * @param int $id
     * @return array|null
     */
    public function getPhoneNumbers(int $id): ?array
    {
        return $this->database->getByColumn('Phonenumber', 'AccountID', $id);
    }

    public function addPhoneNumberByUser(array $data): void
    {
        $this->database->create('Phonenumber', $data);
    }

    public function deletePhoneNumberByUserId(int $AccountID): void
    {
        $this->database->customQuery('DELETE FROM Phonenumber WHERE AccountID = ' . $AccountID);
    }

    // TODO: Docs schrijven
    public function getByEmail(string $email): ?array
    {
        $result = $this->database->getByColumn(self::$table, 'Email', $email);

        if ($result) {
            return $result[0];
        }

        throw new Error($email . ' is niet aan een account gekoppeld.');
    }

    // TODO: Docs schrijven
    public function existsByColumn(string $column, string $value): bool
    {
        $result = $this->database->getByColumn(self::$table, $column, $value);
        return $result ? true : false;
    }

    // TODO: Docs schrijven 
    public function isBlocked(int $id): ?bool
    {
        $user = $this->get($id);

        return (bool) $user['Blocked'];
    }

    // TODO: Docs schrijven
    public function toggleBlocked(int $id): void
    {
        $user = $this->get($id);

        $result = $this->database->update(self::$table, $id, ['Blocked' => !$user['Blocked']]);

        if (!$result) {
            throw new Error("Blokkeer status niet gewijzigd!");
        }
    }

    /**
     * Function that is used to toggle a seller true/false
     * @param int                       Account ID
     * @return  void                    Returns nothing
     * @throws  Error                   Throws and error if no users were found.
     */
    public function toggleSeller(int $id): void
    {
        $user = $this->get($id);

        $result = $this->database->update(self::$table, $id, ['Seller' => !$user['Seller']]);

        if (!$result) {
            throw new Error("Seller status niet gewijzigd!");
        }
    }


    /**
     * Function that is used to load up users in the auction users view.
     * @return  array|null              Array containing all users found in the database
     * @throws  Error                   Throws and error if no users were found.
     */
    public function getOverview(int $pageNumber, int $perPage): ?array
    {
        $result = $this->database->customQuery("SELECT * FROM Account ORDER BY ID DESC OFFSET (($pageNumber-1) * $perPage) ROWS FETCH NEXT $perPage ROWS ONLY");

        if ($result) return $result;

        throw new Error("Geen gebruikers gevonden!");
    }
}
