<?php

namespace App\Model;

use PDO;
use App\Entity\Tag as TagEntity;

class Tag extends AbstractModel
{
    /**
     * * Overload AbstractModel::findAll()
     * Find all id & names, doesn't select description to make request more performant
     * @param int $product_id The id of the product
     * @return array of Tag entities, or false if request fails
     */
    public function findAll(): array|false
    {
        $sql = 'SELECT id, name FROM tag';

        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_CLASS, '\App\Entity\Tag');
    }

    public function findAllPreview(): array|false
    {
        $sql = 'SELECT id, name, SUBSTRING(description, 1, 100) as preview FROM tag';

        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $product_id The id of the product
     * @return array|false of Tag entities linked to the product with product_tag binding table, or false if request fails
     */
    public function findAllByProduct(int $product_id): array|false
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

    /**
     * @param App\Entity\Tag $tag Entity
     * @return bool depending if request is successfull or not
     */
    public function create(TagEntity $tag): bool
    {
        $sql = 'INSERT INTO tag (name, description) VALUES (:name, :description)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':name', $tag->getName());
        $insert->bindValue(':description', $tag->getDescription());

        return $insert->execute();
    }
}
