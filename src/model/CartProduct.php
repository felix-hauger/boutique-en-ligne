<?php

namespace App\Model;

use PDO;
use App\Config\DbConnection;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class CartProduct
{
    /**
     * @var ?PDO used to connect to database
     */
    private ?PDO $_pdo = null;

    public function __construct()
    {
        $this->_pdo = DbConnection::getPdo();
    }

    public function create($cart_id, $product_id, $product_quantity)
    {
        // récupère les id cart & product, insert la quantité du product
        $sql = 'INSERT INTO cart_product (cart_id, product_id, product_quantity) VALUES (:cart_id, :product_id, :product_quantity)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);

        return $insert->execute();
    }

    public function find($cart_id, $product_id)
    {
        // récupère les infos du cart avec la clé primaire (id cart & product)
        $sql = 'SELECT * FROM cart_product WHERE cart_id = :cart_id AND product_id = :product_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $select->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    public function update($cart_id, $product_id, $product_quantity)
    {
        // update product quantity (? delete if quantity is 0 ?)
        $sql = 'UPDATE cart_product SET product_quantity = :product_quantity WHERE cart_id = :cart_id AND product_id = :product_id';

        $update = $this->_pdo->prepare($sql);

        $update->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $update->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);

        return $update->execute();
    }

    public function delete($cart_id, $product_id)
    {
        // delete en utilisant la clé primaire (mix des clés étrangères)
        // update product quantity (? delete if quantity is 0 ?)
        $sql = 'DELETE FROM cart_product WHERE cart_id = :cart_id AND product_id = :product_id';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        return $insert->execute();
    }
}

$cp = new CartProduct();

var_dump($cp);

// $cp->create(2, 5, 1);
// $cp->update(2, 5, 2);
// var_dump($cp->find(2, 5));
// $cp->delete(2, 5);