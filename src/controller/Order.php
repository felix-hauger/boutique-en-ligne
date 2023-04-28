<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Order as OrderEntity;
use App\Model\Cart as CartModel;
use App\Model\CartProduct;
use App\Model\Order as OrderModel;
use App\Model\OrderProduct;
use Exception;

class Order extends AbstractController
{
    public function find(int $id)
    {
        $order_model = new OrderModel();

        return $order_model->find($id);
    }

    public function findForUser(int $id)
    {
        $category_model = new OrderModel();

        return $category_model->findForUser($id);
    }

    public function findALL()
    {
        $order_model = new OrderModel();

        return $order_model->findALL();
    }
    public function getAllInfo()
    {
        $order_model = new OrderModel();

        return $order_model->getAllInfo();
    }

    public function createFromCart(Cart $cart)
    {

        $order_model = new OrderModel();

        try {
            $order_model->getPdo()->beginTransaction();

            $order_entity = new OrderEntity();

            $order_entity->setUserId($cart->getUserId());

            $order_model->create($order_entity);

            $db_order_id = $order_model->getPdo()->lastInsertId();

            $order_product_model = new OrderProduct();

            foreach($cart->getItems() as $item) {
                $order_product_model->create($db_order_id, $item['id'], $item['price'], $item['quantity'], $item['size']);
            }
            
            $cart_product_model = new CartProduct();

            $cart_product_model->emptyCart($cart->getId());

            return $order_model->getPdo()->commit();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
?>