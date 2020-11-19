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

            // Uncomment bottom line when debugging
            // $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            exit("Kan geen verbinding maken met database!");

            // Uncomment bottom line when debugging
            // echo "Error connecting to Database: {$error->getMessage()} <br>";
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
     * @param   string      $table      Table to insert data in.
     * @param   array       $data       Associative array of which the key represents the column name.
     * @throws  RuntimeException        Throws  exception when error occurs while executing the query.
     */
    public function create(string $table, array $data): void
    {
        $this->connect();

        $columns = implode(', ', array_keys($data));
        $values  = $this->formatInsertValues(array_values($data));

        $query = "INSERT INTO $table ($columns) VALUES ($values)";

        $sth = $this->dbh->prepare($query);

        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        unset($sth);
        $this->close();
    }

    /**
     * Read method to be used in Controllers.
     * @param   string      $table  Table to fetch data from.
     * @param   id          $id     Row with ID.
     * @return  array               Returns fetched row as an associative Arrays.
     * @throws  RuntimeException    Throws  exception when error occurs while executing the query.
     */
    public function get(string $table, int $id): array
    {
        $this->connect();

        $query = "SELECT * FROM $table where ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        // Do something with the data.
        $buffer = $sth->fetch(PDO::FETCH_ASSOC);

        unset($sth);
        $this->close();

        return $buffer;
    }

    /**
     * Read method to be used in Controllers.
     * @param   string      $table  Table to fetch data from.
     * @return  array               Returns numeric array with all rows (as an associative arrays).
     * @throws  RuntimeException    Throws  exception when error occurs while executing the query.
     */
    public function index(string $table): array
    {
        $this->connect();

        // Query
        $query = "SELECT * FROM $table";

        $sth = $this->dbh->prepare($query);

        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        $buffer = $sth->fetchAll(PDO::FETCH_ASSOC);

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
     * @throws  RuntimeException    Throws  exception when error occurs while executing the query.
     */
    public function update(string $table, int $id, array $data): void
    {
        $this->connect();

        $query = "UPDATE $table SET " . $this->formatUpdateValues($data) . " WHERE ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        unset($sth);
        $this->close();
    }

    /**
     * Delete method to be used in Controllers.
     * @param   string      $table  Delete from which table?
     * @param   int         $id     Row with ID?
     * @throws  RuntimeException    Throws  exception when error occurs while executing the query.
     */
    public function delete(string $table, int $id): void
    {
        $this->connect();

        $query = "DELETE FROM $table WHERE ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

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
        $buffer = "";

        foreach ($array as $key => $value) {
            $buffer .= is_numeric($value) ? "$key = $value, " :  "$key = '$value', ";
        }

        trim($buffer, ' '); // Trim last space
        trim($buffer, ','); // Trim trailing comma

        return $buffer;
    }
}
