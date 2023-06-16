<?php

namespace App\Controller;

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Entity\Cart as CartEntity;
use App\Entity\Product;
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

        $cart_product->create($cart_id, $product_id, $size, $quantity);
    }

    public function getCookieItemInfos(int $id)
    {
        $product_model = new ProductModel();

        return $product_model->findWithPreview($id);
    }


    public static function toHtmlItem(array $cart_item)
    {
        $result = 
        // Item image, name, size & quantity
        '<tr>
            <td class="Tdbg" rowspan="2" class="TdImage"><img class="imageCart" src="' . $cart_item['image'] . '"></td>
            <td class="Tdbg" ><b>' . $cart_item['name'] . '</b></td>
            <td class="Tdbg" >Taille : <b>' . strtoupper($cart_item['size']) . '</b></td>
            <td class="Tdbg" >Quantité : <b>' . $cart_item['quantity'] . '</b></td>';

        // Price depending of the number of items
        if ($cart_item['quantity'] > 1) {
            $Nprice = $cart_item['price'] * $cart_item['quantity'];
            $result .= 
                '<td class="Tdbg" ><b>' . $Nprice . '€</b><br>
                (' . $cart_item['price'] . '€ x ' . $cart_item['quantity'] . ')
                </td>';
        } else {
            $result .= '<td class="Tdbg" ><b>' . $cart_item['price'] . '€</b></td></tr>';
        }

        $result .= 
        
        '<tr>
            <td class="TdDesc" colspan="3">' . $cart_item['preview'] . '</td>
            <td class="BoxBtSuppCookie"><form><button class="BtSuppCookie">Supprimer L\'article</button></form></td>
        </tr>';

        return $result;
    }

    public static function toHtmlCookieItem(array $cart_item)
    {
        $result = 
        // Item image, name, size & quantity
        '<tr>
            <td class="Tdbg" rowspan="2" class="TdImage"><img class="imageCart" src="' . $cart_item['image'] . '"></td>
            <td class="Tdbg" ><b>' . $cart_item['name'] . '</b></td>
            <td class="Tdbg" >Taille : <b>' . strtoupper($cart_item['size']) . '</b></td>
            <td class="Tdbg" >Quantité : <b>' . $cart_item['quantity'] . '</b></td>';

        // Price depending of the number of items
        if ($cart_item['quantity'] > 1) {
            $Nprice = $cart_item['price'] * $cart_item['quantity'];
            $result .= 
                '<td class="Tdbg" ><b>' . $Nprice . '€</b><br>
                (' . $cart_item['price'] . '€ x ' . $cart_item['quantity'] . ')
                </td>';
        } else {
            $result .= '<td class="Tdbg" ><b>' . $cart_item['price'] . '€</b></td></tr>';
        }

        $result .= 
        
        '<tr>
            <td class="TdDesc" colspan="3">' . $cart_item['preview'] . '</td>
            <td class="BoxBtSuppCookie"><button class="BtSuppCookie" onclick="SupprimerCookie(\'product_' . $cart_item['id'] . '_' . $cart_item['size'] . '\')">Supprimer L\'article</button></td>
        </tr>';

        return $result;
    }

    /**
     * Transfer cart items from cookie to database
     * To use when user log in
     */
    public function transferCookieCartItemsToLoggedUser(): void
    {
        // Find cart of logged user
        $user_cart = $this->getByUser($_SESSION['user']->getId());

        $cart_product = new CartProduct();

        foreach($_COOKIE as $key => $value) {
            if (substr($key, 0, 8) === 'product_') {
                // todo: check product format with regex

                // 0 => id, 1 => size
                $product = explode('_', substr($key, 8));

                // todo: check if value is int
                $quantity = $value;

                // Insert in cart_product
                $cart_product->create($user_cart->getId(), $product[0], $product[1], $quantity);

                // Remove cookie
                setcookie($key, '', -1);
                
            }
        }
    }
}

// $c = new Cart();

// // var_dump($c->getByUser(1));

// $c->addProductToUserCart(1, 8, 2, 'xl');