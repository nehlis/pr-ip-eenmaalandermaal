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
     * @param string $table From which table?
     * @param string $id    What ID?
     * @return  array   Returns retrieved row
     * @throws Exception
     */
    public function get(string $table, string $id)
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM [$table] where [ID] = '{$id}'";

        $sth = $this->dbh->prepare($query);

        // Execute query
        if (!$sth->execute()) {
            throw new Exception("Error bij uitvoeren query... ", 0);
        }

        // Do something with the data.
        $buffer = $sth->fetch(PDO::FETCH_ASSOC);

        // Close Database connection
        $this->close();

        // Return data
        return $buffer;
    }
    
    /**
     * getAll method to be used in Controllers.
     * @param string $table From which table?
     * @return  array   Returns array with all data pulled from given table.
     * @throws Exception
     */
    public function getAll(string $table): array
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM :table";

        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':table', $table, PDO::PARAM_STR_CHAR);

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
    
    /**
     * Index method to be used in Controllers.
     * @param string $table From which table?
     * @param string $id
     * @return void Returns array with all data pulled from given table.
     * @throws Exception
     */
    public function delete(string $table, string $id): void
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "DELETE FROM [:table] WHERE [ID] = :id";

        $sth = $this->dbh->prepare($query);

        $sth->bindParam(':table', $table, PDO::PARAM_STR_CHAR);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);

        // Execute query
        if (!$sth->execute()) {
            throw new Exception("Error bij uitvoeren query... ", 0);
        }

        // Close Database connection
        $this->close();
    }











    // Test Functie, het werkt
    public function test()
    {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM test";

        $sth = $this->dbh->prepare($query);

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
