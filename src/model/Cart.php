<?php

namespace App\Model;

class Cart extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();

        $this->_table = 'cart';
    }

    public function create(\App\Entity\Cart $cart)
    {
        $sql = 'INSERT INTO cart user_id = :user_id';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':user_id', $cart->getUserId());

        return $insert->execute();
    }
}