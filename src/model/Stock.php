<?php

namespace App\Model;

class Stock extends AbstractModel
{
    /**
     * Insert product stock in database, in stock table
     * @param App\Entity\Stock $stock Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\Stock $stock): bool
    {
        $sql = 'INSERT INTO stock (xs, s, m, l, xl, xxl) VALUES (:xs, :s, :m, :l, :xl, :xxl)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':xs', $stock->getXs());
        $insert->bindValue(':s', $stock->getS());
        $insert->bindValue(':m', $stock->getM());
        $insert->bindValue(':l', $stock->getL());
        $insert->bindValue(':xxl', $stock->getXxl());

        return $insert->execute();
    }
}