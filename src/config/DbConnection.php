<?php

namespace App\Config;

class DbConnection
{
    /**
     * @var ?PDO Database connection
     */
    private static ?\PDO $_db = null;

    private function __construct()
    {
        // Singleton
    }

    /**
     * @return PDO Used for database connection in models
     */
    public static function getPdo(): \PDO
    {
        if (!self::$_db) {
            try {
                // Get database infos from ini file in config folder
                $db = parse_ini_file('db.ini');

                // Define PDO dsn & auth infos with retrieved data
                self::$_db = new \PDO($db['type'] . ':dbname=' . $db['name'] . ';host=' . $db['host'] . ';charset=' . $db['charset'], $db['user'], $db['password']);

                // Prevent emulation of prepared requests
                self::$_db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$_db;
    }
}