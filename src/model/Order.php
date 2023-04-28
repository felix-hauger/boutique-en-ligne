<?php

namespace App\Model;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class Order extends AbstractModel
{
    /**
     * insert cart in database
     * @param \App\Entity\Order $order Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\Order $order)
    {
        $sql = 'INSERT INTO `order` (user_id) VALUES (:user_id)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':user_id', $order->getUserId());

        return $insert->execute();
    }

    public function find(int $id): array|false
    {
        $sql = 'SELECT * FROM `order` 
        INNER JOIN `order_product` ON `order_product`.`order_id`= `order`.`id`
        INNER JOIN `product` ON `order_product`.product_id = `product`.`id`
        where `order`.`id` = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id, \PDO::PARAM_INT);

        $select->execute();

        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findALL(): array|false
    {
        $sql = 'SELECT * FROM `order` 
        INNER JOIN `order_product` ON `order_product`.`order_id`= `order`.`id`
        INNER JOIN `product` ON `order_product`.product_id = `product`.`id`';
       
        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllInfo(): array|false
    {
        $sql = 'SELECT * FROM `order`';
            
        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(\PDO::FETCH_ASSOC);
    }
}

// $order = new Order();

// var_dump($order->find(1));