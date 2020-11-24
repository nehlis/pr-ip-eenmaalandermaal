<?php

namespace App\Validators;

/**
 * Class AccountValidator
 */
class AccountValidator extends Validator
{
    /**
     * Data to be checked
     * @var
     */
    private $data;
    
    /**
     * Rules to check for
     * @var string[]
     */
    private static $rules = [
        'Email' => 'required',
    ];
    
    /**
     * AccountValidator constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function validateThis(): bool
    {
        if (isset($this->data) && isset(self::$rules))
            return parent::validate($this->data, self::$rules);
        else
            return false;
    }
}