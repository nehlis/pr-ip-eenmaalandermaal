<?php

namespace Core;

use Config\DatabaseConfig;
use PDO;
use PDOException;
use RuntimeException;

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

    public function test() {
        // Initialize Database connection
        $this->connect();

        // Query
        $query = "SELECT * FROM [Users]";

        $sth = $this->dbh->prepare($query);

        // Error handling
        if (!$sth->execute()) {
            throw new RuntimeException("Error bij uitvoeren query... ", 0);
        }

        $buffer = [];

        while($row = $sth->fetch(PDO::FETCH_LAZY)) {
            $buffer['email'] = $row['Email'];
            $buffer['password'] = $row['Password'];
        }

        // Close Database connection
        $this->close();

        return $buffer;
    }

}
