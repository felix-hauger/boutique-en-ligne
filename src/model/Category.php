<?php

namespace App\Model;

use App\Entity\Category as CategoryEntity;

class Category extends AbstractModel
{
    public function create(CategoryEntity $category)
    {
        $sql = 'INSERT INTO category (name, description) VALUES (:name, :description)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindValue(':name', $category->getName());
        $insert->bindValue(':description', $category->getDescription());

        return $insert->execute();
    }
}