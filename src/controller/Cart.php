<?php

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Entity\Cart as CartEntity;
use App\Model\Cart as CartModel;
use App\Model\CartProduct;
use App\Model\Product as ProductModel;
use App\Model\User;

class Cart extends AbstractController
{
    public function getAll()
    {

    }

    /**
     * @param int $user_id The cart owner id
     * @return CartEntity Hydrated with retrieved data
     */
    public function getByUser(int $user_id): CartEntity
    {
        // Instanciate Cart model to retrieve cart data
        $cart_model = new CartModel();

        // Retrieve cart infos using user id
        $cart_infos = $cart_model->findByUser($user_id);

        // Instanciate Product model to retrieve cart products data
        $product_model = new ProductModel();

        // Store in cart infos cart Product entities containing product data, using retrieved cart id
        $cart_infos['items'] = $product_model->findAllByCart($cart_infos['id']);

        // Instanciate Cart entity to hydrate
        $cart_entity = new CartEntity();

        // Hydrate Cart entity with cart infos
        $cart_entity->hydrate($cart_infos);

        // We can use Cart entity setters, getters & hydrate on it
        return $cart_entity;
    }

    public function addProductToUserCart($user_id, $product_id, $quantity, $size)
    {
        $cart_product = new CartProduct();

        $cart_model = new CartModel();

        $cart_id = $cart_model->findIdWithField('user_id', $user_id);

        $cart_product->create($cart_id, $product_id, $quantity, $size);
    }
}

// $c = new Cart();

// // var_dump($c->getByUser(1));

// $c->addProductToUserCart(1, 8, 2, 'xl');