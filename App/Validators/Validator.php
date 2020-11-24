<?php

namespace App\Validators;

/**
 * Class Validator
 * @package App\Validators
 */
abstract class Validator
{
    /**
     * Data that should be validated.
     * @var array
     */
    private static $data;
    
    /**
     * Fields that should be validated
     * @var
     */
    private static $fields;
    
    /**
     * Rules that apply to the validator.
     * @var
     */
    private static $rules;
    
    /**
     * Validator constructor.
     * @param $data
     * @param $fields
     * @param $rules
     */
    public function __construct($rules, $fields, $data)
    {
        self::setFields($fields);
        self::setData($data);
        self::setRules($rules);
    }
    
    /**
     * Set the data based on the fields prop.
     * @param array $data
     */
    protected static function setData(array $data)
    {
        $newData = [];
        
        foreach ($data as $key => $field) {
            if (in_array($key, self::$fields)) {
                $newData[$key] = $field;
            }
        }
        
        self::$data = $newData;
    }
    
    /**
     * Set the fields to be checked.
     * @param mixed $fields
     */
    public static function setFields($fields): void
    {
        self::$fields = $fields;
    }
    
    /**
     * Set the rules to be matched.
     * @param mixed $rules
     */
    public static function setRules($rules): void
    {
        self::$rules = $rules;
    }
    
    /**
     * Validates the input fields and returns true if succesful.
     * @return bool
     */
    protected static function validate(): bool
    {
        foreach (self::$data as $key => $item) {
            // Skip iteration if field is not in rules.
            if (!isset(self::$rules[$key])) {
                break;
            }
            
            foreach (self::getFieldRules($key) as $rule) {
                // Return false if validation failed.
                if (!self::validateWithRules($item, $rule)) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    /**
     * Gets the rules per field, in array format.
     * @param $field
     * @return array
     */
    public static function getFieldRules($field): array
    {
        if (strpos(self::$rules[$field], '|')) {
            $validators = explode('|', self::$rules[$field]);
        } else {
            $validators = [self::$rules[$field]];
        }
        
        return $validators;
    }
    
    /**
     * Validate the item with the given rule.
     * @param $item
     * @param $rule
     * @return bool
     */
    public static function validateWithRules($item, $rule): bool
    {
        switch ($rule):
            case 'required':
                if (!isset($item) || empty($item)) {
                    return false;
                }
                break;
            case 'email':
                if (!filter_var($item, FILTER_VALIDATE_EMAIL)) {
                    return false;
                }
                break;
        endswitch;
        
        return true;
    }
    
    /**
     * Checks the validator from the validation instance.
     * @return bool
     */
    protected abstract function check(): bool;
}