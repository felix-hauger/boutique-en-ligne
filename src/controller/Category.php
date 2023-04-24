<?php

namespace App\Controller;

use App\Model\Category as CategoryModel;

class Category extends AbstractController
{
    public function getAll()
    {
        $category_model = new CategoryModel();

        return $category_model->findAll();
    }
}