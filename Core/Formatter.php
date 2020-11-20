<?php

namespace Core;

/**
 * Class Formatter
 * @package Core
 */
class Formatter
{
    /**
     * Function to prepare an array of values for the SQL UPDATE statement.
     * @param array $values Array with key (columns) and value (to update) pairs.
     * @return  string      String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    public static function formatUpdateValues(array $values): string
    {
        $buffer = "";
    
        foreach ($values as $key => $value) {
            $buffer .= is_numeric($value) ? "$key = $value, " :  "$key = '$value', ";
        }
    
        return trim($buffer, ", ");
    }
    
    /**
     * Method to prepare an array of columns for the SQL UPDATE statement.
     * @param   array $data
     * @return  string      String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    public static function formatInsertColumns(array $data): string
    {
        return implode(', ', array_keys($data));
    }
    
    /**
     * method to prepare an array of values for the SQL UPDATE statement.
     * @param   array $data
     * @return  string      String formatted as follows: 'column1' = 'value1', 'column2' = 'value2'
     */
    public static function formatInsertValues(array $data): string
    {
        $values = array_keys($data);
        
        foreach ($values as &$value) {
            $value = "'$value'";
        }
        
        return implode(', ', $values);
    }
}