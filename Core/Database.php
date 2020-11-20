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
     * Close the database connection.
     */
    private function close(): void
    {
        unset($this->sth);
        $this->dbh = null;
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
        $this->connect();

        $columns = implode(', ', array_keys($data));
        $values  = $this->formatInsertValues(array_values($data));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        $this->sth = $this->dbh->prepare($query);

        try {
            $result = $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }

        $this->close();

        if ($result === false) {
            throw new Error("[Database] Error executing create query!");
        }
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
        $this->connect();

        $query = "SELECT * FROM $table where ID = :id";

        $this->sth = $this->dbh->prepare($query);
        $this->sth->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }

        $result = $this->sth->fetch(PDO::FETCH_ASSOC);

        $this->close();

        if ($result && sizeof($result) > 0) {
            return $result;
        } else {
            throw new Error("[Database] Row where ID = $id not found!");
        }
    }

    /**
     * Read method to be used in Controllers.
     * @param   string  $table      Table to fetch data from.
     * @param   string  $column     Row where column = 'value'.
     * @param   string  $value      
     * @return  array               Returns fetched row as an associative Arrays.
     * @throws  Error               Throws error when nothing was found or when execution fails (SQL related).
     */
    public function getByColumn(string $table, string $column, string $value): ?array
    {
        $this->connect();

        $query = "SELECT * FROM $table where $column = :value";

        $this->sth = $this->dbh->prepare($query);
        $this->sth->bindParam(':value', $value, PDO::PARAM_STR);

        try {
            $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }

        $result = $this->sth->fetch(PDO::FETCH_ASSOC);

        $this->close();

        if ($result && sizeof($result) > 0) {
            return $result;
        } else {
            throw new Error("[Database] No rows where $column = '$value' found!");
        }
    }

    /**
     * Read method to be used in Controllers.
     * @param   string  $table  Table to fetch data from.
     * @return  array           Returns numeric array with all rows (as an associative arrays).
     * @throws  Error           Throws error when nothing was found or when execution fails (SQL related).
     */
    public function index(string $table): ?array
    {
        $this->connect();

        // Query
        $query = "SELECT * FROM $table";

        $this->sth = $this->dbh->prepare($query);

        try {
            $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }

        $result = $this->sth->fetchAll(PDO::FETCH_ASSOC);

        $this->close();

        // exit ($result);

        if ($result && sizeof($result) > 0) {
            return $result;
        } else {
            throw new Error("[Database] No rows found!");
        }
    }

    /**
     * Update method to be used in Controllers.
     * @param   string  $table  Update row in which table?
     * @param   int     $id     Row with ID?
     * @param   void    $data   Associative array of which the key is the column name to be updated with its value.
     * @throws  Error           Throws error when execution fails. Possible cause: SQL conflicts
     */
    public function update(string $table, int $id, array $data): void
    {
        $this->connect();

        $query = "UPDATE $table SET " . $this->formatUpdateValues($data) . " WHERE ID = :id";

        $this->sth = $this->dbh->prepare($query);
        $this->sth->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $result = $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }


        $this->close();

        if (!$result) {
            throw new Error("[Database] Error executing update query!");
        }
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
        $this->connect();

        $query = "DELETE FROM $table WHERE ID = :id";

        $this->sth = $this->dbh->prepare($query);
        $this->sth->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $result = $this->sth->execute();
        } catch (PDOException $ex) {
            $this->handlePDOException($ex->getMessage());
        }


        $this->close();

        if (!$result) {
            throw new Error("[Database] Error executing delete query!");
        }
    }


    // Helper Functions
    /**
     * Function to prepare an array of values for the SQL INSERT INTO statement.
     * @param   array   $values     Values to be formatted/prepared.
     * @return  string              String formatted as follows: 'value1', 'value2', 'value3'
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
     * @param   array   $array  Array with key (columns) and value (to update) pairs.
     * @return  string          String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    private function formatUpdateValues(array $array): string
    {
        $buffer = "";

        foreach ($array as $key => $value) {
            $buffer .= is_numeric($value) ? "$key = $value, " :  "$key = '$value', ";
        }

        $buffer = trim($buffer, " "); // Trim last space
        $buffer = trim($buffer, ","); // Trim trailing comma        

        return $buffer;
    }

    private function handlePDOException(string $message): void
    {
        echo '<div class="alert alert-danger" role="alert">' . $message . ' </div>';
    }
}
