<?php

namespace App\Model;

use PDO;
use App\Config\DbConnection;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

class CartProduct
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
     * @param int $cart_id Part 1 of the primary key, the cart id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @param int $product_quantity The quantity of the product
     * @return bool Depending if the request is executed successfully
     */
    public function create(int $cart_id, int $product_id, int $product_quantity, string $product_size): bool
    {
        // fetch cart & product ids, insert them as PRIMARY KEY with product quantity
        $sql = 'INSERT INTO cart_product (cart_id, product_id, product_quantity, product_size) VALUES (:cart_id, :product_id, :product_quantity, :product_size)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
        $insert->bindParam(':product_size', $product_size);

        return $insert->execute();
    }

    /**
     * @param int $cart_id Part 1 of the primary key, the cart id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @return array|false SQL result if the request is executed successfully
     */
    public function find(int $cart_id, int $product_id): array|false
    {
        // fetch cart infos with PRIMARY KEY (cart_id, product_id)
        $sql = 'SELECT * FROM cart_product WHERE cart_id = :cart_id AND product_id = :product_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $select->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $cart_id Part 1 of the primary key, the cart id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @param int $product_quantity The quantity of the product
     * @return bool Depending if the request is executed successfully
     */
    public function update(int $cart_id, int $product_id, int $product_quantity, string $product_size): bool
    {
        $sql = 'UPDATE cart_product SET product_quantity = :product_quantity, product_size = :product_size WHERE cart_id = :cart_id AND product_id = :product_id';

        $update = $this->_pdo->prepare($sql);

        $update->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $update->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
        $update->bindParam(':product_size', $product_size);

        return $update->execute();
    }

    /**
     * @param int $cart_id Part 1 of the primary key, the cart id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @return bool Depending if the request is executed successfully
     */
    public function delete(int $cart_id, int $product_id): bool
    {
        // delete using primary key (foreign keys mix)
        // ? delete if product_quantity is 0?
        $sql = 'DELETE FROM cart_product WHERE cart_id = :cart_id AND product_id = :product_id';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        return $insert->execute();
    }

    /**
     * Delete all entries using cart_id to remove cart infos
     * @return bool Depending if the request is executed successfully
     */
    public function emptyCart(int $cart_id): bool
    {
        $sql = 'DELETE FROM cart_product WHERE cart_id = :cart_id';

        $delete = $this->_pdo->prepare($sql);

        $delete->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);

        return $delete->execute();
    }
}

// $cp = new CartProduct();

// var_dump($cp);

// $cp->create(2, 5, 1);
// $cp->update(2, 5, 2);
// var_dump($cp->find(2, 5));
// $cp->delete(2, 5);