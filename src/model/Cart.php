<?php

namespace App\Model;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use PDO;

class Cart extends AbstractModel
{
    /**
     * insert cart in database
     * @param App\Entity\Cart $cart Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\Cart $cart)
    {
        $sql = 'INSERT INTO cart user_id = :user_id';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':user_id', $cart->getUserId());

        return $insert->execute();
    }

    /**
     * When the cart has no items, remove created_at, updated_at
     * @param int $id The cart id
     * @return bool depending if request is successfull or not
     */
    public function empty(int $id)
    {
        $sql = 'UPDATE cart SET created_at = NULL, updated_at = NULL WHERE id = :id';

        $update = $this->_pdo->prepare($sql);

        $update->bindParam(':id', $id);

        return $update->execute();
    }

    /**
     * * Overload AbstractModel::find(int $id)
     * Use INNER JOIN to get infos from cart products
     * @param int $id The cart id
     * @return array|false Find all products linked to the cart with 
     * the binding table cart_product, or false if request fails
     */
    public function find(int $id): array|false
    {
        $sql = 'SELECT 
            cart.id, cart.created_at, cart.updated_at, cart.total_amount, 
            cart_product.quantity, 
            product.id, product.name, SUBSTRING(product.description, 0, 120) AS overview, product.image, product.price, 
            category.name AS category
            FROM cart
            INNER JOIN cart_product ON cart.id = cart_product.cart_id
            INNER JOIN product ON product.id = cart_product.product_id
            INNER JOIN category ON category.id = product.category_id
            WHERE cart.id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Use INNER JOIN to get infos from cart products
     * @param int $user_id The id of the cart owner
     * @return array|false Find all products linked to the cart with 
     * the binding table cart_product, or false if request fails
     */
    public function findByUser(int $user_id)
    {
        $sql = 
            'SELECT 
            id, created_at, updated_at, total_amount, user_id
            FROM cart
            WHERE user_id = :user_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }
}

$cart = new Cart();

// var_dump($cart->find(1));
var_dump($cart->findByUser(1));