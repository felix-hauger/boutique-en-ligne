<?php

namespace App\Model;

use PDO;

class Stock extends AbstractModel
{
    /**
     * Insert product stock in database, in stock table
     * @param App\Entity\Stock $stock Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\Stock $stock): bool
    {
        $sql = 'INSERT INTO stock (xs, s, m, l, xl, xxl, product_id) VALUES (:xs, :s, :m, :l, :xl, :xxl, :product_id)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':xs', $stock->getXs());
        $insert->bindValue(':s', $stock->getS());
        $insert->bindValue(':m', $stock->getM());
        $insert->bindValue(':l', $stock->getL());
        $insert->bindValue(':xl', $stock->getXl());
        $insert->bindValue(':xxl', $stock->getXxl());
        $insert->bindValue(':product_id', $stock->getProductId());

        return $insert->execute();
    }

    /**
     * @param int $product_id The product id of the stock
     * @return array|false Row from database if request executed successfully and found, else false
     */
    public function findByProduct(int $product_id): array|false
    {
        $sql = 'SELECT * FROM stock WHERE product_id = :product_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':product_id', $product_id);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }
}