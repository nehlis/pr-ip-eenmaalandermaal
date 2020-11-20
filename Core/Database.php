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
     * @var PDO $dbh PDO Handler also known as the database handler aka the database connection.
     */
    private $dbh;

    /**
     * @var PDOStatement $sth Statement handler.
     */
    private $sth;

    /**
     * Connect to the database.
     * @return void
     */
    private function connect(): void
    {
        try {
            $this->dbh = new PDO(
                "sqlsrv:server=" . DatabaseConfig::HOST . "; Database=" . DatabaseConfig::DATABASE,
                DatabaseConfig::USER,
                DatabaseConfig::PASSWORD
            );

            // Uncomment bottom line when debugging
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        unset($this->sth, $this->dbh);
    }

    /**
     * Create method to be used in Controllers.
     * @param  string $table Table to insert data in.
     * @param  array  $data  Associative array of which the key represents the column name.
     * @return void
     * @throws Error         Throws error when execution fails. Possible cause: SQL conflicts
     */
    public function create(string $table, array $data): void
    {
        $this->connect();

        $columns = implode(', ', array_keys($data));
        $values  = $this->formatInsertValues(array_values($data));
        
        $this->sth = $this->dbh->prepare("INSERT INTO $table ($columns) VALUES ($values)");

        $this->execute();
        $this->close();
    }

    /**
     * Read method to be used in Controllers.
     * @param  string $table Table to fetch data from.
     * @param  int    $id    Row with ID.
     * @return array         Returns fetched row as an associative array.
     * @throws Error         Throws error when nothing was found or when execution fails (SQL related).
     */
    public function get(string $table, int $id): ?array
    {
        $this->connect();

        $this->sth = $this->dbh
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
     * @throws Error          Throws error when nothing was found or when execution fails (SQL related).
     */
    public function getByColumn(string $table, string $column, string $value): ?array
    {
        $this->connect();
        
        $this->sth = $this->dbh
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
     * @throws Error         Throws error when nothing was found or when execution fails (SQL related).
     */
    public function index(string $table): ?array
    {
        $this->connect();
        
        $this->sth = $this->dbh->prepare("SELECT * FROM $table");

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
        
        $this->sth = $this->dbh
            ->prepare("UPDATE $table SET " . $this->formatUpdateValues($data) . " WHERE ID = :id")
            ->bindParam(':id', $id, PDO::PARAM_INT);

        $this->execute();
        $this->close();
    }

    /**
     * Delete method to be used in Controllers.
     * @param  string $table Table to delete a row
     * @param  int    $id    Delete row where ID = ?
     * @return void          Returns nothing.
     * @throws Error         Throws error when execution fails. Possible cause: SQL conflicts
     */
    public function delete(string $table, int $id): void
    {
        $this->connect();
        
        $this->sth = $this->dbh
            ->prepare("DELETE FROM $table WHERE ID = :id")
            ->bindParam(':id', $id, PDO::PARAM_INT);
    
        $this->execute();
        $this->close();
    }
    
    /**
     * Function to prepare an array of values for the SQL INSERT INTO statement.
     * @param   array  $values Values to be formatted/prepared.
     * @return  string         String formatted as follows: 'value1', 'value2', 'value3'
     */
    private function formatInsertValues(array $values): string
    {
        foreach ($values as &$value) {
            $value = "'$value'";
        }

        return implode(', ', $values);
    }

    /**
     * Function to prepare an array of values for the SQL UPDATE statement.
     * @param   array  $array Array with key (columns) and value (to update) pairs.
     * @return  string        String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    private function formatUpdateValues(array $array): string
    {
        $buffer = "";

        foreach ($array as $key => $value) {
            $buffer .= is_numeric($value) ? "$key = $value, " :  "$key = '$value', ";
        }

        return trim($buffer, ", ");
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
            $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }
        
        return $this->sth;
    }
}
