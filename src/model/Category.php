<?php

namespace App\Model;

use App\Entity\Category as CategoryEntity;
use PDO;

class Category extends AbstractModel
{
    /**
     * Insert category in database
     * @param CategoryEntity $category Entity
     * @return bool depending if request is successfull or not
     */
    public function create(CategoryEntity $category)
    {
        $sql = 'INSERT INTO category (name, description) VALUES (:name, :description)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':name', $category->getName());
        $insert->bindValue(':description', $category->getDescription());

        return $insert->execute();
    }

    /**
     * Find all id & names, doesn't select description to make request more performant
     * @return array|false Category entities if request is successfull, else false
     */
    public function findAll(): array|false
    {
        $sql = 'SELECT id, name FROM category';

        $select = $this->_pdo->prepare($sql);

        $select->execute();

        return $select->fetchAll(PDO::FETCH_CLASS, 'App\Entity\Category');
    }
}