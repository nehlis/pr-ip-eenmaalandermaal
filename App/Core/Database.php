<?php

namespace App\Core;

use App\Config\DatabaseConfig;
use PDO;
use PDOStatement;
use PDOException;
use Error;

/**
 * Database Class
 *
 * In this class you find all generic CRUD operations to be used in Controller classes.
 *
 * TODO: Dubbele code eruit halen!
 *
 */
class Database
{
    /**
     * @var PDO $database PDO Handler also known as the database handler aka the database connection.
     */
    private $database;

    /**
     * @var PDOStatement $statement Statement handler.
     */
    private $statement;

    /**
     * Connect to the database.
     */
    private function connect(): Database
    {
        try {
            $this->database = new PDO(DatabaseConfig::getDSN(), DatabaseConfig::USER, DatabaseConfig::PASSWORD);

            // Uncomment bottom line when debugging
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }

        return $this;
    }

    /**
     * Close the database connection.
     */
    private function close(): void
    {
        unset($this->statement);
        $this->database = null;
    }

    /**
     * BASIC CRUD OPERATIONS
     */

    /**
     * Create method to be used in Controllers.
     * @param   string  $table  Table to insert data in.
     * @param   array   $data   Associative array of which the key represents the column name.
     * @return  int|null        Returns ID of the last inserted record or null.
     */
    public function create(string $table, array $data): ?int
    {
        $columns = Format::insertColumns($data);
        $values  = Format::insertValues($data);

        // exit("INSERT INTO $table ($columns) VALUES ($values)");

        $result = $this
            ->connect()
            ->prepare("INSERT INTO $table ($columns) VALUES ($values)")
            ->execute(false);

        $id = $result ? $this->database->lastInsertId() : null;

        $this->close();

        return $id;
    }

    /**
     * Read method to be used in Controllers.
     * @param   string      $table  Table to fetch data from.
     * @param   int         $id     Row with ID.
     * @return  array|null          Returns fetched row as an associative array or null when nothing was found.
     */
    public function get(string $table, int $id): ?array
    {
        $result = $this
            ->connect()
            ->prepare("SELECT * FROM $table WHERE ID = :id")
            ->bind(':id', $id, PDO::PARAM_INT)
            ->execute()
            ->fetch(PDO::FETCH_ASSOC);

        $this->close();

        return $result ? $result : null;
    }

    /**
     * Read method to be used in Controllers.
     * @param   string  $table  Table to fetch data from.
     * @return  array           Returns numeric array with all rows (as an associative arrays).
     */
    public function index(string $table): ?array
    {
        $result = $this
                    ->connect()
                    ->prepare("SELECT * FROM $table")
                    ->execute()
                    ->fetchAll(PDO::FETCH_ASSOC);

        $this->close();

        return $result ? $result : null;
    }

    /**
     * Update method to be used in Controllers.
     * @param   string $table   Update row in which table?
     * @param   int    $id      Row with ID?
     * @param   array  $data    Associative array of which the key is the column name to be updated with its value.
     * @return  bool            true if update was successful and false otherwise.
     */
    public function update(string $table, int $id, array $data): bool
    {
        $result = $this
                    ->connect()
                    ->prepare("UPDATE $table SET " . Format::updateValues($data) . " WHERE ID = :id")
                    ->bind(':id', $id, PDO::PARAM_INT)
                    ->execute(false);

        $this->close();

        return $result;
    }

    /**
     * Delete method to be used in Controllers.
     * @param   string  $table  Table to delete a row
     * @param   int     $id     Delete row where ID = ?
     * @return  bool            True if deletion was successful and false otherwise.
     */
    public function delete(string $table, int $id): bool
    {
        $result = $this
                    ->connect()
                    ->prepare("DELETE FROM $table WHERE ID = :id")
                    ->bind(':id', $id, PDO::PARAM_INT)
                    ->execute(false);

        $this->close();

        return $result;
    }

    /**
     * EXTRA CRUD FUNCTIONS
     */
    
     /**
     * Read by Column method to be used in Controllers.
     * @param   string  $table      Table to fetch data from.
     * @param   string  $column     Row where column = 'value'.
     * @param   string  $value      Value to check for in table.
     * @return  array               Returns fetched row as an associative Arrays.
     */
    public function getByColumn(string $table, string $column, string $value): ?array
    {
        $result = $this
            ->connect()
            ->prepare("SELECT * FROM $table WHERE $column = :value")
            ->bind(':value', $value, PDO::PARAM_STR)
            ->execute()
            ->fetch(PDO::FETCH_ASSOC);

        $this->close();

        return (bool) $result ? $result : null;
    }

    /**
     * HELPER FUNCTIONS
     */

    /**
     * Executes the statement and returns the result of it.
     * @param   bool                $chained    Is the function used in a chain?
     * @return  PDOStatement|bool               Returns PDOStatement or bool depending on $chained param
     */
    private function execute(bool $chained = true)
    {
        try {
            $result = $this->statement->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }

        return $chained ? $this->statement : $result;
    }

    /**
     * Prepares the database and set's the statement's value to it.
     * @param string $query
     * @return $this
     */
    private function prepare(string $query): Database
    {
        $this->statement = $this->database->prepare($query);

        return $this;
    }

    /**
     * Binds the parameter and returns self for chaining.
     * @param $variable
     * @param $value
     * @param $type
     * @return $this
     */
    private function bind($variable, $value, $type): Database
    {
        $this->statement->bindParam($variable, $value, $type);

        return $this;
    }

    /**
     * Handles PDO Exceptions with HTML output.
     * @param string $message
     */
    private function handlePDOException(string $message): void
    {
        echo '<div class="alert alert-danger" role="alert">' . $message . ' </div>';
    }
}
