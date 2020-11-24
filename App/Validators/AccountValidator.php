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
    private $rules = [
        'Firstname'      => 'required',
        'Lastname'       => 'required',
        'Password'       => 'required',
        'Street'         => 'required',
        'Housenumber'    => 'required',
        'Zipcode'        => 'required',
        'City'           => 'required',
        'CountryID'      => 'required',
        'QuestionID'     => 'required',
        'QuestionAnswer' => 'required',
        'Birthdate'      => 'required',
    ];
    
    /**
     * AccountValidator constructor.
     * @param $data
     */
    public function __construct(array $data)
    {
        parent::__construct($this->rules, $data);
    }
}