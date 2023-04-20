<?php

namespace App\Model;

use PDO;
use App\Config\DbConnection;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class ProductTag
{
    /**
     * @var ?PDO used to connect to database
     */
    private ?PDO $_pdo = null;

    /**
     * Initialize database connection
     */
    public function __construct()
    {
        $this->_pdo = DbConnection::getPdo();
    }

    /**
     * @param int $product_id Part 1 of the primary key, the product id foreign key
     * @param int $tag_id Part 2 of the primary key, the tag id foreign key
     * @return bool Depending if the request is executed successfully
     */
    public function create(int $product_id, int $tag_id): bool
    {
        // fetch tag & product ids, insert them as PRIMARY KEY with product quantity
        $sql = 'INSERT INTO product_tag (product_id, tag_id) VALUES (:product_id, :tag_id)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);

        return $insert->execute();
    }

    /**
     * @param int $product_id Part 1 of the primary key, the product id foreign key
     * @param int $tag_id Part 2 of the primary key, the tag id foreign key
     * @return bool Depending if the request is executed successfully
     */
    public function delete(int $product_id, int $tag_id): bool
    {
        // delete using primary key (foreign keys mix)
        $sql = 'DELETE FROM product_tag WHERE tag_id = :tag_id AND product_id = :product_id';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert->bindParam(':tag_id', $tag_id, PDO::PARAM_INT);

        return $insert->execute();
    }
}

// $pt = new ProductTag();

// var_dump($pt);

// $pt->create(8, 12);
// $pt->update(2, 5, 2);
// var_dump($pt->find(2, 5));
// $pt->delete(8, 12);