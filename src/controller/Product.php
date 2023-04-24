<?php

namespace App\Controller;
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Model\Product as ProductModel;
use App\Entity\Product as ProductEntity;
use App\Entity\Stock as StockEntity;
use App\Model\Tag as TagModel;
use App\Model\Stock as StockModel;
use App\Model\ProductTag as ProductTagModel;
use Exception;

class Product extends AbstractController
{
    const MAX_UPLOADED_FILE_NAME_LENGTH = 175;

    private static $_max_uploaded_file_size = 3000000;

    /**
     * @param int $id The product id
     * @return ProductEntity Product entity hydrated with product, stock, category & tags infos
     */
    public function getPageInfos(int $id): ProductEntity
    {
        try {
            // Instanciate Product model to fetch product data
            $product_model = new ProductModel();

            // Fetch product infos in associative array
            $db_product = $product_model->find($id);

            // Instanciate Product entity
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
     * @param string $name The name of the product
     * @param string $description The description of the product
     * @param int $price The price of the product
     * @param string $image The image path of the product
     * @param int $category_id The category id of the product
     * @param int $discount_id The discount id of the product
     * @param array $tags The tags of the product
     * @param array $stock The product stock
     */
    public function add(string $name, string $description, int $price, string $image, int $category_id, ?int $discount_id = null, array $tags, array $stock)
    {
        try {
            // Get arguments values in an array
            $args = func_get_args();

            // Get parameters names using reflection
            $args_names = $this->getMethodArgNames(__CLASS__, __FUNCTION__);

            // Combine them into an associative array
            $product_input = array_combine($args_names, $args);

            // Unset stock from product as it is useless
            // before product is inserted in database
            unset($product_input['stock']);

            // Instanciate Product entity
            $product = new ProductEntity();

            // Instanciate Product model to insert data
            $product_model = new ProductModel();

            //* Begin transaction to make sure all request
            //* are successfull before committing to the database
            $product_model->getPdo()->beginTransaction();

            // Hydrate Product entity with product parameters
            $product->hydrate($product_input);

            // Create product entry in database using Product entity as parameter
            $product_model->create($product);

            // Get last inserted id using AbstractModel $_pdo property
            $db_product_id = $product_model->getPdo()->lastInsertId();

            // Instanciate Stock entity
            $stock_entity = new StockEntity();

            // Hydrate stock entity
            $stock_entity->hydrate($stock);

            // Set product id to create Stock
            $stock_entity->setProductId($db_product_id);

            // Instanciate stock to insert data
            $stock_model = new StockModel();

            // Create stock entry in database using Stock entity as parameter
            $stock_model->create($stock_entity);

            // Instanciate ProductTag model to bind product & tags
            $product_tag_model = new ProductTagModel();

            foreach ($tags as $tag) {
                // Create entries in product_tag using last inserted id & tag id
                $product_tag_model->create($db_product_id, $tag);
            }

            // Commit changes if all databases queries are successfull
            return $product_model->getPdo()->commit() ? $db_product_id : false;

            // $this->getImageFile($image, $image['name'], $image_path);

        } catch (Exception $e) {
            //throw $th;
            $product_model->getPdo()->rollBack();

            // var_dump($image);

            // unlink($image);

            echo $e->getMessage();
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

    /**
     * @return array Index page informations
     */
    public function index(): array
    {
        $product_model = new ProductModel();

        $current_season = $this->checkSeason();

        return [
            'last_added' => $product_model->findLastAdded(),
            'last_by_season' => $product_model->findLastBySeasonName($current_season),
            'best_selling' => $product_model->findBestSelling()
        ];
    }

    /**
     * @param array $product The product infos
     * @return string Html product thumbnail
     */
    public static function toHtmlThumbnail(array $product): string
    {
        return '<div class="card">
            <a href="product.php?id=' .$product['id']. '"><img class="image" src="' . $product['image'] . '"></a>
            <h2 class="ArticleName">' . $product['name'] . '</h2>
            <h3 class="prix">' . $product['price'] . ' € </h3>
            <a href="product.php?id=' .$product['id']. '"><button class="linkToArticleBtn">Voir cet article</button></a>
        </div>';
    }

    /**
     * Check if a file name is too long
     * @param string $filename The uploaded file name
     * @return bool Depending if the uploaded file name is too long or not
     */
    public function checkUploadedFileNameLength(string $filename): bool
    {
        return mb_strlen($filename, 'UTF-8') <= Product::MAX_UPLOADED_FILE_NAME_LENGTH;
    }

    /**
     * Check if a file name has only alphanumeric characters
     * @param string $filename The uploaded file name
     * @return bool Depending if the uploaded file match with the regex
     */
    public function checkUploadedFileName(string $filename): bool
    {
        return (bool) preg_match("`^[-0-9A-Z_\.]+$`i", $filename);
    }

    /**
     * Check if a file name has only alphanumeric characters
     * @param string $filename The uploaded file name
     * @return bool Depending if the uploaded file match with the regex
     */
    public function checkUploadedFileSize(int $filesize): bool
    {
        return $filesize <= static::$_max_uploaded_file_size;
    }

    /**
     * Send image $file to $destination_path and return its $name concatenated with its extension
     * @param array $image_file Image file from $_FILES
     * @param string $name To rename the file
     * @param string $destination_path Define where the image is uploaded
     * @return string $image_name $name + image extension
     */
    public function getImageFile(array $image_file, string $destination_path) {
        // Test if file exists and has no error
        if (isset($image_file) && $image_file['error'] === 0) {

            // var_dump($name);
            // var_dump($image_file);

            $image_infos = pathinfo($image_file['name']);

            $image_name = $image_infos['filename'];

            if (!$this->checkUploadedFileNameLength($image_name)) {
                // Limit image file name length
                throw new Exception('Nom du fichier trop long. Longueur max : ' . Product::MAX_UPLOADED_FILE_NAME_LENGTH);
            } elseif (!$this->checkUploadedFileName($image_name)) {
                // Limit which characters image file name can contain
                throw new Exception('Seuls des caractères alphanumériques sans accent et des tirets sont acceptés pour le nom de l\'image');
            } elseif (!$this->checkUploadedFileSize($image_file['size'])) {
                // Limit image size
                throw new Exception('Taille maximum de l\'image : ' . static::$_max_uploaded_file_size / 1000000 . 'mo');
            } else {
                // Get image extension
                $image_extension = pathinfo($image_file['name'], PATHINFO_EXTENSION);

                // Accepted extensions array
                $extensions_array = ['png', 'gif', 'jpg', 'jpeg', 'webp'];

                if (in_array($image_extension, $extensions_array)) {
                    // Set path to using $destination_path parameter with image name
                    $image_path = $destination_path . $image_name . '.' . $image_extension;

                    // To make sure an existing file is not overwritten
                    while (file_exists($image_path)) {
                        $image_path = $destination_path .  uniqid() . '_' . rand() . '_' . $image_name . '.' . $image_extension;
                    }

                    // Attempt to move image file to image folder
                    if(move_uploaded_file($image_file['tmp_name'], $image_path)) {
                        // If successful, return image path to be stored in database and/or entity
                        return $image_path;
                    }
                } else {
                    // If the format is not accepted
                    $extensions_string = '';

                    foreach ($extensions_array as $key => $extension) {
                        if ($key === array_key_last($extensions_array)) {
                            $extensions_string .= $extension;
                        } else {
                            $extensions_string .= $extension . ', ';
                        }
                    }
                    throw new Exception('Format du fichier non accepté. Formats acceptés : ' . $extensions_string);
                }
            }
        }
        throw new Exception('Erreur dans le téléchargement de l\'image. Veuillez sélectionner un fichier de ' . static::$_max_uploaded_file_size / 1000000 . 'mo maximum, dont le nom comporte uniquement des caractères alphanumériques sans accent et des tirets, avec une extension d\'image correcte');
    }
}

// $p = new Product();
// $p->add(
//     'a',
//     'b', 
//     1, 
//     'img', 
//     5, 
//     null, 
//     [11, 13], 
//     ['xs' => 10, 's' => 11, 'm' => 12, 'l' => 13, 'xl' => 14, 'xxl' => 15]
// );
// echo $p->checkSeason();
// $test = $p->index();
// var_dump($p->get(80));

// var_dump($test);