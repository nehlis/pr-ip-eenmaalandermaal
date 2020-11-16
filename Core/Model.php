<?php

namespace Core;

use Interfaces\IModel;

abstract class Model implements IModel
{
    public static $fields;
    public static $table;
    
    /**
     * Set's the fields from the model.
     * @param array $fields
     */
    public static function set(array $fields): void
    {
        self::$fields = $fields;
    }
    
    /**
     * Returns all the fields from the model.
     * @return array
     */
    public static function get(): array
    {
        return self::$fields;
    }
    
    /**
     * Initialises all the values that are passed to the user (if they exist).
     * @param array $values
     */
    function init(array $values): void
    {
        if (!self::$fields) {
            return;
        }
        
        foreach (self::$fields as $key => $field) {
            if (array_key_exists($key, $values)) {
                self::$fields[$key] = $values[$key];
            }
        }
    }
}