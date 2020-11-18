<?php

namespace Core;

use Config\DatabaseConfig;
use Exception;
use PDO;
use PDOException;

/**
 * Class Database
 */
class Database
{
    /**
     * @var $dbh Database handler also known as database connection.
     */
    private $dbh;

    /**
     * Connect to the database using the credentials.
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
     * Get method to be used in Controllers.
     * @param   string      $table  Get from which table?
     * @param   string      $id     Row with ID?
     * @return  array               Returns fetched row as an associative Arrays.
     * @throws  Exception           Throws  exception when error occurs while executing the query.
     */
    public function get(string $table, string $id): array
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM $table where ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute query
        if (!$sth->execute()) {
            throw new Exception("Error bij uitvoeren query... ", 0);
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
     * getAll method to be used in Controllers.
     * @param   string      $table  Get from which table?
     * @return  array               Returns numeric array with all rows (as associative arrays).
     * @throws  Exception           Throws  exception when error occurs while executing the query.
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
            throw new Exception("Error bij uitvoeren query... ", 0);
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
     * Delete method to be used in Controllers.
     * @param   string      $table  Delete from which table?
     * @param   string      $id     Row with ID?
     * @throws Exception            Throws  exception when error occurs while executing the query.
     */
    public function delete(string $table, string $id): void
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "DELETE FROM $table WHERE ID = :id";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute query
        if (!$sth->execute()) {
            throw new Exception("Error bij uitvoeren query... ", 0);
        }

        // Close Database connection
        unset($sth);
        $this->close();
    }

    // Test Functie
    public function test()
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $table = 'test';
        $id = 3;

        $query = "SELECT * FROM $table WHERE ID = :id";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':id', $id);

        // Execute query
        if (!$sth->execute()) {
            throw new Exception("Error bij uitvoeren query... ", 0);
        }

        // Do something with the data.
        $buffer = $sth->fetchAll(PDO::FETCH_ASSOC);

        // Close Database connection
        $this->close();

        // Return data
        return $buffer;
    }
}
