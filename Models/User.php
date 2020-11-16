<?php

namespace Models;

use Core\Model;

/**
 * Class User
 */
class User extends Model
{
    /**
     * Basic db columns ('NULL' necessary).
     * @var array|null[]
     */
    public static $fields = [
        'id'        => 'NULL',
        'name'      => 'NULL',
        'email'     => 'NULL',
        'last_name' => 'NULL',
    ];
    
    /**
     * Database column that should be selected.
     * @var string
     */
    public static $table = 'users';
    
    /**
     * User constructor.
     * @param array $user
     */
    public function __construct(array $user = [])
    {
        parent::set(self::$fields);
        
        if (!empty($user)) {
            $this->init($user);
        }
    }
}