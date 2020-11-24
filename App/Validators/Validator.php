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
    private $data;
    
    /**
     * Rules that apply to the validator.
     * @var array
     */
    private $rules;
    
    /**
     * Seperator for the rules.
     * @var string
     */
    private $seperator = '|';
    
    /**
     * Validator constructor.
     * @param $data
     * @param $rules
     */
    public function __construct($rules, $data)
    {
        $this->setRules($rules);
        $this->setData($data);
    }
    
    /**
     * Set the data based on the if they are in the rules property.
     * @param array $data
     */
    protected function setData(array $data): void
    {
        $newData = [];
        
        foreach ($data as $key => $field) {
            if (in_array($key, array_keys($this->rules))) {
                $newData[$key] = $field;
            }
        }
        
        $this->data = $newData;
    }
    
    /**
     * Set the rules to be matched.
     * @param mixed $rules
     */
    public function setRules($rules): void
    {
        $this->rules = $rules;
    }
    
    /**
     * Validates the input fields and returns true if succesful.
     * @return bool
     */
    public function validate(): bool
    {
        foreach ($this->data as $key => $item) {
            // Skip iteration if field is not in rules.
            if (!isset($this->rules[$key])) {
                break;
            }
            
            foreach ($this->getFieldRules($key) as $rule) {
                // Return false if validation failed.
                if (!$this->validateWithRules($item, $rule)) {
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
    public function getFieldRules($field): array
    {
        if (strpos($this->rules[$field], $this->seperator)) {
            $validators = explode($this->seperator, $this->rules[$field]);
        } else {
            $validators = [$this->rules[$field]];
        }
        
        return $validators;
    }
    
    /**
     * Validate the item with the given rule.
     * @param $item
     * @param $rule
     * @return bool
     */
    public function validateWithRules($item, $rule): bool
    {
        switch ($rule):
            case 'required':
                return isset($item) && !empty($item);
            case 'email':
                return filter_var($item, FILTER_VALIDATE_EMAIL);
        endswitch;
        
        return true;
    }
    
    /**
     * Get's the valid data.
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}