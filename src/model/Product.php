<?php

namespace App\Model;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use Exception;
use PDO;

class Product extends AbstractModel
{
    /**
     * Insert user in database
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

    public function update(\App\Entity\Product $product)
    {
        $sql = 'UPDATE product SET
        name = :name,
        description = :description,
        price = :price,
        image = :image,
        quantity_sold = :quantity_sold,
        updated_at = NOW(),
        deleted_at = :deleted_at,
        category_id = :category_id,
        discount_id = :discount_id
        WHERE id = :id';

        $update = $this->_pdo->prepare($sql);

        $update->bindValue(':name', $product->getName());
        $update->bindValue(':description', $product->getDescription());
        $update->bindValue(':price', $product->getPrice());
        $update->bindValue(':image', $product->getImage());
        $update->bindValue(':quantity_sold', $product->getQuantitySold());
        $update->bindValue(':deleted_at', $product->getDeletedAt());
        $update->bindValue(':category_id', $product->getCategoryId());
        $update->bindValue(':discount_id', $product->getDiscountId());
        $update->bindValue(':id', $product->getId());

        return $update->execute();
    }

    public function find(int $id): array|false
    {
        if (!$this->isInDb($id)) {
            throw new Exception('Produit introuvable.');
        }

        $sql =
            'SELECT product.id, product.name, product.description, price, image, quantity_sold, created_at, updated_at, deleted_at,
            category.id as category_id, category.name as category_name 
            FROM product
            INNER JOIN category ON category.id = product.category_id
            WHERE product.id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    public function findAllByCategory(int $category_id)
    {
        $sql = 'SELECT * FROM product WHERE category_id = :category_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':category_id', $category_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return ?array The best-selling products
     */
    public function getMoreSold(): ?array
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 0, 120), price, image, created_at, quantity_sold FROM product ORDER BY quantity_sold DESC LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        return $select->execute() ? $select->fetchAll(PDO::FETCH_ASSOC) : null;
    }

    /**
     * @return ?array The last added products
     */
    public function getLastAdded(): ?array
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 0, 120), price, image, created_at, quantity_sold FROM product ORDER BY created_at DESC LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        return $select->execute() ? $select->fetchAll(PDO::FETCH_ASSOC) : null;
    }
}

$p = new Product();
// $ent = new \App\Entity\Product();

// $ent->setName('update');
// $ent->setDescription('update');
// $ent->setPrice(150);
// $ent->setImage('update.jpg');
// $ent->setQuantitySold(10);
// $ent->setDeletedAt(null);
// $ent->setCategoryId(3);
// $ent->setDiscountId(null);
// $ent->setId(31);

// $p->update($ent);

// var_dump($p->getMoreSold());
// var_dump($p->getLastAdded());
// var_dump($p->find(5));

// $p->create($ent);