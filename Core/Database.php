<?php

namespace Core;

use Config\DatabaseConfig;
use PDO;
use PDOException;
use RuntimeException;

/**
 * Database Class
 * 
 * In this class you find all CRUD operations to be used in Controller classes.
 * 
 */
class Database
{
    /**
     * @var $dbh Database handler also known as database connection.
     */
    private $dbh;

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

            // Error handling
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // return $dbh;
        } catch (PDOException $error) {
            echo "Error connecting to Database: {$error->getMessage()} <br>";
        }
    }

    /**
     * Close the database connection.
     */
    private function close(): void
    {
        $this->dbh = null;
    }

    /**
     * Create method to be used in Controllers.
     * @param   string      $table      Insert into which table?
     * @param   array       $data       asd
     * @throws  RuntimeException               Throws  exception when error occurs while executing the query.
     */
    public function create(string $table, array $data): void
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $columns = implode(', ', array_keys($data));
        $values  = $this->formatInsertValues(array_values($data));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        $sth = $this->dbh->prepare($query);

        // Execute query
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Close Database connection
        unset($sth);
        $this->close();
    }

    /**
     * Read method to be used in Controllers.
     * @param   string      $table  Get from which table?
     * @param   id          $id     Row with ID?
     * @return  array               Returns fetched row as an associative Arrays.
     * @throws  RuntimeException           Throws  exception when error occurs while executing the query.
     */
    public function get(string $table, int $id): array
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM $table where ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute query
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Do something with the data.
        $buffer = $sth->fetch(PDO::FETCH_ASSOC);

        // Close Database connection
        unset($sth);
        $this->close();

        // Return data
        return $buffer;
    }

    /**
     * Read method to be used in Controllers.
     * @param   string      $table  Get from which table?
     * @return  array               Returns numeric array with all rows (as an associative arrays).
     * @throws  RuntimeException           Throws  exception when error occurs while executing the query.
     */
    public function getAll(string $table): array
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM $table";

        $sth = $this->dbh->prepare($query);

        // Execute query
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Do something with the data.
        $buffer = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Close Database connection and clear statement handler
        unset($sth);
        $this->close();

        // Return data
        return $buffer;
    }

    /**
     * Update method to be used in Controllers.
     * @param   string      $table  Update row in which table?
     * @param   int         $id     Row with ID?
     * @param   array       $data   Associative array of which the key is the column name to be updated with its value.
     * @throws  RuntimeException           Throws  exception when error occurs while executing the query.
     */
    public function update(string $table, int $id, array $data): void
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "UPDATE $table SET " . $this->formatUpdateValues($data) . " WHERE ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute query
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Close Database connection
        unset($sth);
        $this->close();
    }

    /**
     * Delete method to be used in Controllers.
     * @param   string      $table  Delete from which table?
     * @param   int         $id     Row with ID?
     * @throws  RuntimeException           Throws  exception when error occurs while executing the query.
     */
    public function delete(string $table, int $id): void
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "DELETE FROM $table WHERE ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute query
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Close Database connection
        unset($sth);
        $this->close();
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
     * @param   array   $array      Array with key (columns) and value (to update) pairs.
     * @return  string              String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    private function formatUpdateValues(array $array): string
    {
        $output = "";

        foreach ($array as $key => $value) {
            if (is_numeric($value)) {
                $output .= "$key = $value, ";
            } else {
                $output .= "$key = '$value', ";
            }
        }

        $output = trim($output, ' '); // Trim last space
        $output = trim($output, ','); // Trim trailing comma

        return $output;
    }

    // Test Functie
    public function test()
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "DELETE FROM test WHERE 1=1";
        
        $sth = $this->dbh->prepare($query);

        // Execute query
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Do something with the data.
        $buffer = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Close Database connection
        $this->close();

        // Return data
        return $buffer;
    }
}
