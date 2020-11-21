<?php

namespace Core;

use Config\DatabaseConfig;
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
     * Create method to be used in Controllers.
     * @param   string  $table  Table to insert data in.
     * @param   array   $data   Associative array of which the key represents the column name.
     * @return  void            Returns nothing.
     * @throws  Error           Throws error when execution fails. Possible cause: SQL conflicts
     */
    public function create(string $table, array $data): void
    {
        $columns = Format::insertColumns($data);
        $values  = Format::insertValues($data);
        
        $this
            ->connect()
            ->prepare("INSERT INTO $table ($columns) VALUES ($values)")
            ->execute();

        $this->close();
    }

    /**
     * Read method to be used in Controllers.
     * @param   string  $table  Table to fetch data from.
     * @param   int     $id     Row with ID.
     * @return  array           Returns fetched row as an associative array.
     * @throws  Error           Throws error when nothing was found or when execution fails (SQL related).
     */
    public function get(string $table, int $id): ?array
    {
        $this
            ->connect()
            ->prepare("SELECT * FROM $table where ID = :id")
            ->bind(':id', $id, PDO::PARAM_INT)
            ->execute();

        $result = $this->statement->fetch(PDO::FETCH_ASSOC);

        $this->close();

        return $result ?? null;
    }

    /**
     * Read method to be used in Controllers.
     * @param   string  $table      Table to fetch data from.
     * @param   string  $column     Row where column = 'value'.
     * @param   string  $value      Value to check for in table.
     * @return  array               Returns fetched row as an associative Arrays.
     * @throws  Error               Throws error when nothing was found or when execution fails (SQL related).
     */
    public function getByColumn(string $table, string $column, string $value): ?array
    {
        $this
            ->connect()
            ->prepare("SELECT * FROM $table where $column = :value")
            ->bind(':value', $value, PDO::PARAM_STR)
            ->execute();

        $result = $this->statement->fetch(PDO::FETCH_ASSOC);

        $this->close();

        return $result ?? null;
    }

    /**
     * Read method to be used in Controllers.
     * @param   string  $table  Table to fetch data from.
     * @return  array           Returns numeric array with all rows (as an associative arrays).
     * @throws  Error           Throws error when nothing was found or when execution fails (SQL related).
     */
    public function index(string $table): ?array
    {
        $this
            ->connect()
            ->prepare("SELECT * FROM $table")
            ->execute();

        $result = $this->statement->fetchAll(PDO::FETCH_ASSOC);

        $this->close();

        return $result ?? null;
    }

    /**
     * Update method to be used in Controllers.
     * @param string $table Update row in which table?
     * @param int    $id    Row with ID?
     * @param array  $data  Associative array of which the key is the column name to be updated with its value.
     */
    public function update(string $table, int $id, array $data): void
    {
        $this
            ->connect()
            ->prepare("UPDATE $table SET " . Format::updateValues($data) . " WHERE ID = :id")
            ->bind(':id', $id, PDO::PARAM_INT)
            ->execute();

        $this->close();
    }

    /**
     * Delete method to be used in Controllers.
     * @param   string  $table  Table to delete a row
     * @param   int     $id     Delete row where ID = ?
     * @return  void            Returns nothing.
     * @throws  Error           Throws error when execution fails. Possible cause: SQL conflicts
     */
    public function delete(string $table, int $id): void
    {
        $this
            ->connect()
            ->prepare("DELETE FROM $table WHERE ID = :id")
            ->bind(':id', $id, PDO::PARAM_INT)
            ->execute();

        $this->close();
    }
    
    /**
     * Executes the statement and returns the result of it.
     * @return bool
     */
    private function execute(): bool
    {
        try {
            $result = $this->statement->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }
        
        return $result ?? false;
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
