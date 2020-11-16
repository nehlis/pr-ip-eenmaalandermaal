# Basic object oriented PHP crud framework. Works with SQL.

## How to use.
#### Controllers
Controllers should always implement IControllers and should be located in the Controller directory. See the UserController.php for CRUD examples.
#### Models
All models should extend the abstract class 'Model'. These are the fields that are nesessary for basic Controller usage.
```php
     /**
     * Basic db columns ('NULL' necessary).
     * @var array|null[]
     */
    public static array $fields = [
        'id'        => 'NULL',
        'name'      => 'NULL',
        'email'     => 'NULL',
        'last_name' => 'NULL',
    ];
    
    /**
     * Database column that should be selected.
     * @var string
     */
    public static string $table = 'users';
```

