<?php

namespace App\Controller;
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Model\Product as ProductModel;
use App\Entity\Product as ProductEntity;
use App\Entity\Stock as StockEntity;
use App\Model\Tag as TagModel;
use App\Model\Stock as StockModel;
use DateTime;
use Exception;

class Product extends AbstractController
{
    public function getPageInfos(int $id): ProductEntity
    {
        try {
            // Instanciate Product model to fetch product data
            $product_model = new ProductModel();

            // Fetch product infos in associative array
            $db_product = $product_model->find($id);

            // Instanciate product entity
            $product_entity = new ProductEntity();

            // Instanciate Stock model to fetch product stock data
            $stock_model = new StockModel();

            // Instanciate Stock entity to store in instanciated Product entity
            $stock_entity = new StockEntity();

            // Fetch product stock data
            $product_stock = $stock_model->find($id);

            // Hydrate instanciated Stock entity with retrieved data
            $stock_entity->hydrate($product_stock);

            // Instanciate tag model to make query
            $tag_model = new TagModel();

            // Fetch product tags to store in instanciated Product entity
            $product_tags = $tag_model->findAllByProduct($id);

            // Hydrate product entity with retrieved product data
            $product_entity->hydrate($db_product);

            // Add product tags & stocks
            $product_entity
                ->setTags($product_tags)
                ->setStock($stock_entity);

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

            case $month > 6 && $month < 9:
                return 'été';

            case $month > 9 && $month < 12:
                return 'automne';

            case $month === 12 || $month < 2:
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