<?php

namespace App\Model;

use PDO;
use App\Config\DbConnection;

class OrderProduct
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
     * @param int $order_id Part 1 of the primary key, the order id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @param int $product_quantity The quantity of the product
     * @return bool Depending if the request is executed successfully
     */
    public function create(int $order_id, int $product_id, int $unit_price, int $product_quantity, string $product_size): bool
    {
        // fetch order & product ids, insert them as PRIMARY KEY with product quantity
        $sql = 'INSERT INTO order_product (order_id, product_id, unit_price, product_quantity, product_size) VALUES (:order_id, :product_id, :unit_price, :product_quantity, :product_size)';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $insert->bindParam(':unit_price', $unit_price, PDO::PARAM_INT);
        $insert->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
        $insert->bindParam(':product_size', $product_size);

        return $insert->execute();
    }

    /**
     * @param int $order_id Part 1 of the primary key, the order id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @return array|false SQL result if the request is executed successfully
     */
    public function find(int $order_id, int $product_id): array|false
    {
        // fetch order infos with PRIMARY KEY (order_id, product_id)
        $sql = 'SELECT * FROM order_product WHERE order_id = :order_id AND product_id = :product_id';

        $select = $this->_pdo->prepare($sql);

        $select->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $select->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        $select->execute();

        return $select->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $order_id Part 1 of the primary key, the order id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @param int $product_quantity The quantity of the product
     * @return bool Depending if the request is executed successfully
     */
    public function update(int $order_id, int $product_id, int $product_quantity, string $product_size): bool
    {
        $sql = 'UPDATE order_product SET product_quantity = :product_quantity, product_size = :product_size WHERE order_id = :order_id AND product_id = :product_id';

        $update = $this->_pdo->prepare($sql);

        $update->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $update->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
        $update->bindParam(':product_size', $product_size);

        return $update->execute();
    }

    /**
     * @param int $order_id Part 1 of the primary key, the order id foreign key
     * @param int $product_id Part 2 of the primary key, the product id foreign key
     * @return bool Depending if the request is executed successfully
     */
    public function delete(int $order_id, int $product_id): bool
    {
        // delete using primary key (foreign keys mix)
        // ? delete if product_quantity is 0?
        $sql = 'DELETE FROM order_product WHERE order_id = :order_id AND product_id = :product_id';

        $insert = $this->_pdo->prepare($sql);

        $insert->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $insert->bindParam(':product_id', $product_id, PDO::PARAM_INT);

        return $insert->execute();
    }
}