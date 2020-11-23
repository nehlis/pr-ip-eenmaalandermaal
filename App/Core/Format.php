<?php

namespace App\Core;

/**
 * Class Format
 * @package Core
 */
class Format
{
    /**
     * Function to prepare an array of values for the SQL UPDATE statement.
     * @param array $array Array with key (columns) and value (to update) pairs.
     * @return  string          String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    public static function updateValues(array $array): string
    {
        $buffer = "";
        
        foreach ($array as $key => $value) {
            $buffer .= is_numeric($value) ? "$key = $value, " : "$key = '$value', ";
        }
        
        $buffer = trim($buffer, " "); // Trim last space
        $buffer = trim($buffer, ","); // Trim trailing comma
        
        return $buffer;
    }
    
    /**
     * Function to prepare an array of values for the SQL INSERT INTO statement.
     * @param array $data
     * @return  string              String formatted as follows: 'value1', 'value2', 'value3'
     */
    public static function insertValues(array $data): string
    {
        foreach (array_keys($data) as &$value) {
            $value = "'$value'";
        }
        
        return implode(', ', $data);
    }
    
    /**
     * Formats the SQL insert columns.
     * @param array $data
     * @return string
     */
    public static function insertColumns(array $data): string
    {
        return implode(', ', array_keys($data));
    }
}