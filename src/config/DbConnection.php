<?php

namespace App\Config;

class DbConnection
{
    private static ?\PDO $_db = null;

    private function __construct()
    {
        // singleton
    }

    public static function getDb()
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

// -------- HOW TO USE ---------

// $sql = 'SELECT id, name, description FROM product';

// $select = DbConnection::getDb()->prepare($sql);

// if ($select->execute()) {
//     return $select->fetchAll(\PDO::FETCH_ASSOC);
// }