<?php

namespace App\Validators;

/**
 * Class AccountValidator
 */
class AccountValidator extends Validator
{
    /**
     * Rules to check for
     * @var string[]
     */
    private static $rules = [
        'Firstname'      => 'required',
        'Lastname'       => 'required',
        'Password'       => 'required',
        'Street'         => 'required',
        'Housenumber'    => 'required',
        'Zipcode'        => 'required',
        'City'           => 'required',
        'CountryID'      => 'required',
        'QuestionAnswer' => 'required',
        'Birthdate'      => 'required',
    ];
    
    /**
     * AccountValidator constructor.
     * @param $data
     */
    public function __construct(array $data)
    {
        parent::__construct(self::$rules, $data);
    }
    
    /**
     * Checks if it's validated.
     * @return bool
     */
    public function check(): bool
    {
        return parent::validate() ?? false;
    }
}