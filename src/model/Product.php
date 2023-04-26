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

    /**
     * @param \App\Entity\Product $product Hydrated entity
     * @return bool depending if request is successfull or not
     */
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

    /**
     * overload AbstractMethod::find() method
     * @param int $id The product id
     * @return array|false Array of database rows if query is successfully executed
     */
    public function find(int $id): array|false
    {
        if (!$this->isInDb($id)) {
            throw new Exception('Produit introuvable.');
        }

        $sql =
            'SELECT product.id, product.name, product.description, price, image, quantity_sold, created_at, updated_at, deleted_at,
            category.id AS category_id, category.name AS category_name
            FROM product
            INNER JOIN category ON category.id = product.category_id
            WHERE product.id = :id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':id', $id);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $category_id The category id
     * @return array|false Array of database rows if query is successfully executed
     */
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
    public function findBestSelling(): ?array
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 0, 120), price, image, created_at, quantity_sold FROM product ORDER BY quantity_sold DESC LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        return $select->execute() ? $select->fetchAll(PDO::FETCH_ASSOC) : null;
    }

    /**
     * @return ?array The last added products
     */
    public function findLastAdded(): ?array
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 0, 120), price, image, created_at, quantity_sold FROM product ORDER BY created_at DESC LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        return $select->execute() ? $select->fetchAll(PDO::FETCH_ASSOC) : null;
    }

    /**
     * @param string $season The season
     * @return ?array The products of the selected season
     */
    public function findLastBySeasonName(string $season): ?array
    {
        $seasons = ['printemps', 'été', 'automne', 'hiver'];

        if (!in_array(mb_convert_case($season, MB_CASE_LOWER, 'UTF-8'), $seasons)) {
            $season_string = '';

            foreach ($seasons as $key => $s) {
                if ($key === array_key_last($seasons)) {
                    $season_string .= $s;
                } else {
                    $season_string .= $s . ', ';
                }
            }
            throw new Exception('Veuillez entrer une saison valide (' . $season_string . ').');
        }

        $sql = 'SELECT product.id, product.name, SUBSTRING(product.description, 0, 120), price, image, created_at, quantity_sold
            FROM product
            INNER JOIN product_tag ON product.id = product_tag.product_id
            INNER JOIN tag ON tag.id = product_tag.tag_id
            WHERE LOWER(tag.name) = LOWER(:tag_name)
            ORDER BY created_at DESC
            LIMIT 10';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':tag_name', $season);

        return $select->execute() ? $select->fetchAll(PDO::FETCH_ASSOC) : null;
    }

    /**
     * @param int $tag_id The tag id
     * @return array|false Array of database rows if query is successfully executed
     */
    public function findAllByTag(int $tag_id): array|false
    {
        $sql = 'SELECT product.id, product.name, SUBSTRING(product.description, 0, 120), price, image, created_at, quantity_sold,
            tag.name, tag.description
            FROM product
            INNER JOIN product_tag ON product.id = product_tag.product_id
            INNER JOIN tag ON tag.id = product_tag.tag_id
            WHERE tag.id = :tag_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllPreview(): array|false
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 1, 100) as preview, price, created_at, quantity_sold FROM product';

        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

}

$p = new Product();
// try {
//     var_dump($p->findLastBySeasonName('ÉtÉ'));
// } catch (Exception $e) {
//     echo $e->getMessage();
// }
// $query = $p->findAllByTag(1);
// $ent = new \App\Entity\Product();
// var_dump($query);
// $ent->setName('created_at');
// $ent->setDescription('created_at');
// $ent->setPrice(150);
// $ent->setImage('create.jpg');
// $ent->setQuantitySold(10);
// $ent->setDeletedAt(null);
// $ent->setCategoryId(3);
// $ent->setDiscountId(null);
// $ent->setId(31);

// $p->create($ent);

// var_dump($p->getMoreSold());
// var_dump($p->getLastAdded());
// var_dump($p->find(5));

// $p->create($ent);