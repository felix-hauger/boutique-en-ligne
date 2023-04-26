<?php

namespace App\Controller;

use App\Model\Tag as TagModel;

class Tag extends AbstractController
{
    public function getAll()
    {
        $category_model = new TagModel();

        return $category_model->findAll();
    }


    public function getAllPreview()
    {
        $category_model = new TagModel();

        return $category_model->findAllPreview();
    }
}