<?php

namespace App\Validators;

class Validator
{
    /**
     * Validates the input fields and returns true if succesful.
     * @param array $data
     * @param array $rules
     * @return bool
     */
    protected static function validate(array $data, array $rules): bool
    {
        foreach ($data as $key => $item) {
            if (isset($rules[$key])) {
                $validators = strpos($rules[$key], '|') ? explode($rules[$key], '|') : [$rules[$key]];
        
                foreach ($validators as $validator) {
                    switch ($validator):
                        case 'required':
                            if (!isset($item) || empty($item)) return false;
                            break;
            
                    endswitch;
                }
            }
        }
        
        return true;
    }
}