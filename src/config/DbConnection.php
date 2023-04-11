<?php

namespace App\Config;

class DbConnection
{
    /**
     * @var ?PDO used to represent database connection
     */
    private static ?\PDO $_db = null;

    private function __construct()
    {
        // singleton
    }

    /**
     * @return PDO used for database connection in models
     */
    public static function getPdo(): \PDO
    {
        if (!self::$_db) {
            try {
                // get database infos from ini file in config folder
                $db = parse_ini_file('db.ini');

                // define PDO dsn with retrieved data
                self::$_db = new \PDO($db['type'] . ':dbname=' . $db['name'] . ';host=' . $db['host'] . ';charset=' . $db['charset'], $db['user'], $db['password']);

                // prevent emulation of prepared requests
                self::$_db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\PDOException $e) {
                echo $e->getMessage();
            }
        }
        return self::$_db;
    }
}