<?php

namespace App\Model;
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use PDO;

class Tag extends AbstractModel
{
    public function findAllByProduct(int $product_id)
    {
        $sql = 
            'SELECT tag.id, tag.name
            FROM tag
            INNER JOIN product_tag ON tag.id = product_tag.tag_id
            INNER JOIN product ON product.id = product_tag.product_id
            WHERE product.id = :product_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_CLASS, '\App\Entity\Tag');
    }
}

// $t = new Tag();

// $t->findAllByProduct(6);
// var_dump($t->findAllByProduct(6));