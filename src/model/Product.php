<?php

namespace App\Model;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class Product extends AbstractModel
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'product';
    }

    /**
     * insert user in database
     * @param App\Entity\User $user Entity
     * @return bool depending if request is successfull or not
     */
    public function create(\App\Entity\Product $product): bool
    {
        $sql = 'INSERT INTO product (name, description, price, image, created_at, category_id) VALUES (:name, :description, :price, :image, NOW(), :category_id)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':name', $product->getName());
        $insert->bindValue(':description', $product->getDescription());
        $insert->bindValue(':price', $product->getPrice());
        $insert->bindValue(':image', $product->getImage());
        $insert->bindValue(':category_id', $product->getCategoryId());

        return $insert->execute();
    }

    /**
     * @return ?array The best-selling products
     */
    public function getMoreSold(): ?array
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 0, 120), price, image, created_at, quantity_sold FROM product ORDER BY quantity_sold DESC LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        return $select->execute() ? $select->fetchAll(\PDO::FETCH_ASSOC) : null;
    }

    /**
     * @return ?array The last added products
     */
    public function getLastAdded(): ?array
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 0, 120), price, image, created_at, quantity_sold FROM product ORDER BY created_at DESC LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        return $select->execute() ? $select->fetchAll(\PDO::FETCH_ASSOC) : null;
    }
}

$p = new Product();

// var_dump($p->getMoreSold());
var_dump($p->getLastAdded());