<?php

namespace App\Model;

use App\Config\DbConnection;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class CartProduct
{
    /**
     * @var ?PDO used to connect to database
     */
    private ?\PDO $_pdo = null;

    public function __construct()
    {
        $this->_pdo = DbConnection::getPdo();
    }

    public function create()
    {
        // récupère les id cart & product, insert la quantité du product
    }

    public function find()
    {
        // récupère les infos du cart avec la clé primaire (id cart & product)
    }

    public function update()
    {
        // update product quantity, delete if quantity is 0
    }

    public function delete()
    {
        // delete en utilisant le mix des clés étrangères
    }
}

$cp = new CartProduct();

var_dump($cp);