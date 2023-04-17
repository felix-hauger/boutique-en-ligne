<?php

namespace App\Controller;
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use \App\Model\Product as ProductModel;
use \App\Entity\Product as ProductEntity;
use DateTime;

class Product extends AbstractController
{
    public function find(int $id)
    {
        $product_model = new ProductModel();
        $product_entity = new ProductEntity();

        $db_product = $product_model->find($id);

        // var_dump($db_product);
        // isset($db_product['updated_at']) ? new DateTime($db_product['updated_at']): null;

        $product_entity
            ->setId($db_product['id'])
            ->setName($db_product['name'])
            ->setDescription($db_product['description'])
            ->setPrice($db_product['price'])
            ->setImage($db_product['image'])
            ->setQuantitySold($db_product['quantity_sold'])
            ->setCreatedAt(new DateTime($db_product['created_at']))
            ->setUpdatedAt(isset($db_product['updated_at']) ? new DateTime($db_product['updated_at']): null)
            ->setDeletedAt(isset($db_product['deleted_at']) ? new DateTime($db_product['deleted_at']): null)
            ->setCategoryId($db_product['category_id'])
            ->setCategoryName($db_product['category_name']);

        return $product_entity;
    }
}

$p = new Product();
var_dump($p->find(28));

