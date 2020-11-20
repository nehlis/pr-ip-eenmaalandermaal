<?php

namespace Core;

use Closure;
use Config\DatabaseConfig;
use PDO;
use PDOStatement;
use PDOException;

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
     * @var PDO $pdo PDO Handler also known as the database handler aka the database connection.
     */
    private $pdo;

    /**
     * @var PDOStatement $statement Statement handler.
     */
    private $statement;

    /**
     * Connect to the database.
     * @return void
     */
    private function connect(): void
    {
        try {
            $this->pdo = new PDO(DatabaseConfig::getDSN(), DatabaseConfig::USER, DatabaseConfig::PASSWORD);

            // Uncomment bottom line when debugging
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }
    }

    /**
     * Close the database connection and un-initializes the statement handler.
     * @return void
     */
    private function close(): void
    {
        unset($this->statement, $this->pdo);
    }

    /**
     * Create method to be used in Controllers.
     * @param  string $table Table to insert data in.
     * @param  array  $data  Associative array of which the key represents the column name.
     * @return void
     */
    public function create(string $table, array $data): void
    {
        $this->connect();
        
        $columns = Formatter::formatInsertColumns($data);
        $values  = Formatter::formatInsertValues($data);

        $this->statement = $this->pdo
            ->prepare("INSERT INTO $table ($columns) VALUES ($values)");

        $this->execute();
        
        $this->close();
    }

    /**
     * Read method to be used in Controllers.
     * @param  string $table Table to fetch data from.
     * @param  int    $id    Row with ID.
     * @return array         Returns fetched row as an associative array.
     */
    public function get(string $table, int $id): ?array
    {
        $this->connect();
        
        $this->statement = $this->pdo
            ->prepare("SELECT * FROM $table where ID = :id")
            ->bindParam(':id', $id, PDO::PARAM_INT);

        $result = $this
            ->execute()
            ->fetch(PDO::FETCH_ASSOC);
            
        $this->close();

        return !empty($result) ? $result : null;
    }

    /**
     * Read method to be used in Controllers.
     * @param  string $table  Table to fetch data from.
     * @param  string $column Row where column = 'value'.
     * @param  string $value  Value to check for in table.
     * @return array          Returns fetched row as an associative Arrays.
     */
    public function getByColumn(string $table, string $column, string $value): ?array
    {
        $this->connect();
        
        $this->statement = $this->pdo
            ->prepare("SELECT * FROM $table where $column = :value")
            ->bindParam(':value', $value, PDO::PARAM_STR);

        $result = $this
            ->execute()
            ->fetch(PDO::FETCH_ASSOC);
        
        $this->close();
      

        return !empty($result) ? $result : null;
    }

    /**
     * Read method to be used in Controllers.
     * @param  string $table Table to fetch data from.
     * @return array         Returns numeric array with all rows (as an associative arrays).
     */
    public function index(string $table): ?array
    {
        $this->connect();
        
        $this->statement = $this->pdo->prepare("SELECT * FROM $table");

        $result = $this
            ->execute()
            ->fetchAll(PDO::FETCH_ASSOC);
            
        $this->close();

        return !empty($result) ? $result : null;
    }

    /**
     * Update method to be used in Controllers.
     * @param string $table Update row in which table?
     * @param int    $id    Row with ID?
     * @param array  $data  Associative array of which the key is the column name to be updated with its value.
     */
    public function update(string $table, int $id, array $data): void
    {
        $this->connect();
        
        $this->statement = $this->pdo
            ->prepare("UPDATE $table SET " . Formatter::formatUpdateValues($data) . " WHERE ID = :id")
            ->bindParam(':id', $id, PDO::PARAM_INT);

        $this->execute();
        $this->close();
    }

    /**
     * Delete method to be used in Controllers.
     * @param  string $table Table to delete a row
     * @param  int    $id    Delete row where ID = ?
     * @return void          Returns nothing.
     */
    public function delete(string $table, int $id): void
    {
        $this->connect();
        
        $this->statement = $this->pdo
            ->prepare("DELETE FROM $table WHERE ID = :id")
            ->bindParam(':id', $id, PDO::PARAM_INT);

        $this->execute();
        $this->close();
    }
    
    /**
     * Handles PDO Exceptions with HTML output.
     * @param string $message
     */
    private function handlePDOException(string $message): void
    {
        echo '<div class="alert alert-danger" role="alert">' . $message . ' </div>';
    }
    
    /**
     * Execute Statement handler.
     * @return PDOStatement The statement handler for chaining.
     */
    private function execute(): PDOStatement
    {
        try {
            $this->statement->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }
        
        return $this->statement;
    }
}
