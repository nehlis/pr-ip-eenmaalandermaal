<?php

namespace Core;

use Interfaces\IModel;
use mysqli;

/**
 * Class Database
 */
class Database
{
    /**
     * Database host.
     */
    private const DB_HOST = 'localhost';
    
    /**
     * Database user.
     */
    private const DB_USER = 'root';
    
    /**
     * Database password.
     */
    private const DB_PASS = '';
    
    /**
     * Database name.
     */
    private const DB_NAME = 'crud';
    
    /**
     * @var mysqli
     */
    private $connection;
    
    /**
     * Create method for Controllers.
     * @param array  $args
     * @param IModel $model
     * @return void
     */
    public function create(array $args, IModel $model): void
    {
        $this->insertQuery($args, $model);
    }
    
    /**
     * Insert into query method with it's functionality.
     * @param array  $args
     * @param IModel $model
     * @return void
     */
    private function insertQuery(array $args, IModel $model): void
    {
        $args = $this->merge($args, $model);
        $args = $this->formatArguments($args);
        
        $keys   = implode(', ', array_keys($args));
        $values = implode(', ', array_values($args));
        
        $this->connect();
        
        $this->connection->query("INSERT INTO `{$model::$table}` ({$keys}) VALUES ({$values});");
        
        $this->close();
    }
    
    /**
     * Merge the basic fields from the model with the inputted data.
     * @param array  $args
     * @param IModel $model
     * @return array
     */
    public function merge(array $args, IModel $model): array
    {
        $newArgs = $model::$fields;
        
        foreach ($model::$fields as $key => $field) {
            if (array_key_exists($key, $args)) {
                $newArgs[$key] = $args[$key];
            }
        }
        
        return $newArgs;
    }
    
    /**
     * Formats the arguments for SQL queries.
     * @param array $args
     * @return array
     */
    public function formatArguments(array $args): array
    {
        $keys = $values = [];
        
        foreach (array_keys($args) as $key) {
            $newKey = "`{$key}`";
            array_push($keys, $newKey);
        }
        
        foreach (array_values($args) as $value) {
            if ($value === 'NULL') {
                array_push($values, $value);
                continue;
            }
            
            $newValue = "'{$value}'";
            array_push($values, $newValue);
        }
        
        return array_combine($keys, $values);
    }
    
    /**
     * Connect to the database using the credentials.
     */
    private function connect(): void
    {
        $this->connection = new mysqli(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
    }
    
    /**
     * Closes the database connection.
     */
    private function close(): void
    {
        $this->connection->close();
    }
    
    /**
     * Get method for Controllers
     * @param string $table
     * @param int    $id
     * @return array
     */
    public function get(string $table, int $id): array
    {
        return $this->simpleQuery("SELECT * FROM {$table} WHERE `id` = {$id}");
    }
    
    /**
     * Basic query method (get, index, delete).
     * @param string $query
     * @param bool   $delete
     * @return array|null
     */
    private function simpleQuery(string $query, bool $delete = false): ?array
    {
        $this->connect();
        
        $result = $this->connection->query($query);
        
        $this->close();
        
        return !$delete ? mysqli_fetch_assoc($result) : null;
    }
    
    /**
     * Update method for Controllers.
     * @param string $table
     * @param array  $args
     * @param int    $id
     * @return array
     */
    public function update(string $table, array $args, int $id): array
    {
        $statments = [];
        
        foreach ($args as $key => $arg) {
            array_push($updateStatements, "{$key} = {$arg}");
        }
        
        $formattedStatements = implode(',', $statments);
        
        $result = $this->connection->query("UPDATE `{$table}` SET {$formattedStatements} WHERE `id` = {$id}");
        
        $this->close();
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Index method for Controllers.
     * @param string $table
     * @return array
     */
    public function index(string $table): array
    {
        return $this->simpleQuery("SELECT * FROM {$table}");
    }
    
    /**
     * Delete method for Controllers.
     * @param string $table
     * @param int    $id
     * @return void
     */
    public function delete(string $table, int $id): void
    {
        $this->simpleQuery("DELETE FROM {$table} WHERE `id` = {$id}", true);
    }
}