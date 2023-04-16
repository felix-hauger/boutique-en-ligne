<?php

namespace App\Model;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class Cart extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();

        $this->_table = 'cart';
    }

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
}

$cart = new Cart();