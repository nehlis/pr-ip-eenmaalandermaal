<?php

namespace Config;

class DatabaseConfig
{
    public const HOST = 'mssql.iproject.icasites.nl';
    public const DATABASE = 'iproject3';
    public const USER = 'iproject3';
    public const PASSWORD = 'aeedZ8u8';
    
    /**
     * Returns the DSN needed for the database connection with PDO.
     * @return string
     */
    public static function getDSN(): string
    {
        return "sqlsrv:server=" . self::HOST . "; Database=" . self::DATABASE;
    }
}
