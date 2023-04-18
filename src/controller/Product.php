<?php

namespace App\Controller;
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use \App\Model\Product as ProductModel;
use \App\Entity\Product as ProductEntity;
use DateTime;
use Exception;

class Product extends AbstractController
{
    public function get(int $id): ProductEntity
    {
        $product_model = new ProductModel();
        
        try {
            $db_product = $product_model->find($id);
            
            // var_dump($db_product);
            // isset($db_product['updated_at']) ? new DateTime($db_product['updated_at']): null;
            $product_entity = new ProductEntity();
    
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
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return string The season name
     * mars - mai : printemps
     * juin - août : été
     * septembre - novembre : automne
     * décembre - février : hiver
     */
    public function checkSeason(): string
    {
        $date_time = new \DateTime();

        $month = $date_time->format('n');

        switch (true) {
            case $month > 2 && $month < 6:
                return 'printemps';

            case $month < 9:
                return 'été';

            case $month < 12:
                return 'automne';
            
            default:
                return 'hiver';
        }
    }

    public function index()
    {
        $product_model = new ProductModel();

        $current_season = $this->checkSeason();

        return [
            'last_added' => $product_model->findLastAdded(),
            'last_by_season' => $product_model->findLastBySeasonName($current_season),
            'best_selling' => $product_model->findBestSelling()
        ];
    }

    public static function toHtmlThumbnail(array $product): string
    {
        return '<div class="card">
            <a href="product.php?id=' .$product['id']. '"><img class="image" src="' . $product['image'] . '"></a>
            <h2 class="ArticleName">' . $product['name'] . '</h2>
            <h3 class="prix">' . $product['price'] . ' € </h3>
            <a href="product.php?id=' .$product['id']. '"><button class="linkToArticleBtn">Voir cet article</button></a>
        </div>';
    }
}

// $p = new Product();
// echo $p->checkSeason();
// $test = $p->index();
// var_dump($p->get(80));

// var_dump($test);