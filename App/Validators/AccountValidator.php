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
        'Email'          => 'required|email',
        'Username'       => 'required',
        'Firstname'      => 'required',
        'Lastname'       => 'required',
        'Password'       => 'required',
        'Street'         => 'required',
        'Housenumber'    => 'required',
        'Zipcode'        => 'required',
        'City'           => 'required',
        'Country'        => 'required',
        'QuestionAnswer' => 'required',
        'Birthdate'      => 'required',
    ];
    
    /**
     * Fields to validate and send to backend.
     * @var string[]
     */
    private static $fields = [
        'Email',
        'Username',
        'Firstname',
        'Lastname',
        'Password',
        'Street',
        'Housenumber',
        'Zipcode',
        'City',
        'Country',
        'QuestionAnswer',
        'Birthdate',
        'Blocked',
    ];
    
    /**
     * AccountValidator constructor.
     * @param $data
     */
    public function __construct(array $data)
    {
        parent::__construct(self::$rules, self::$fields, $data);
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