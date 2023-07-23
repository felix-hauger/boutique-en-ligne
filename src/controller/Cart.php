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
     * 
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

    /**
     * @param int $user_id The id of the cart owner
     * @param int $product_id The id of the selected product
     * @param string $product_size The selected size of the product
     * @param int $product_quantity The selected quantity of the product
     * 
     * @return bool Depending if the item is successfully added to cart
     */
    public function addProductToUserCart(int $user_id, int $product_id, string $product_size, int $product_quantity): bool
    {
        $cart_product = new CartProduct();

        $cart_model = new CartModel();

        $cart_id = $cart_model->findIdWithField('user_id', $user_id);

        return $cart_product->create($cart_id, $product_id, $product_size, $product_quantity);
    }

    /**
     * Get product info of cart item for non logged user
     * 
     * @param int $id The product id
     * 
     * @return array|false Retrieved data if request is successfull
     */
    public function getCookieItemInfos(int $id): array|false
    {
        $product_model = new ProductModel();

        return $product_model->findWithPreview($id);
    }

    /**
     * Delete item from logged user cart
     * 
     * @param int $cart_product_id The primary key of the binding table
     * 
     * @return bool Depending if request is successfull
     */
    public function deleteItem(int $cart_product_id): bool
    {
        $cart_product = new CartProduct();

        return $cart_product->delete($cart_product_id);
    }

    /**
     * To display cart items for non logged user, with cart_product id to delete item from cart
     * 
     * @param array $cart_item Contains product data
     * 
     * @return string HTML element
     */
    public static function toHtmlItem(array $cart_item): string
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
            <td class="BoxBtnSupp"><form method="post"><button type="submit" name="delete-cart-item" value="' . $cart_item['cart_product_id'] . '" class="BtnSupp">Supprimer L\'article</button></form></td>
        </tr>';

        return $result;
    }

    /**
     * To display cart items for non logged user
     * 
     * @param array $cart_item Contains product data
     * 
     * @return string HTML element
     */
    public static function toHtmlCookieItem(array $cart_item): string
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
            <td class="BoxBtnSupp"><button class="BtnSupp" onclick="SupprimerCookie(\'product_' . $cart_item['id'] . '_' . $cart_item['size'] . '\')">Supprimer L\'article</button></td>
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
                // 0 => id, 1 => size
                $product = explode('_', substr($key, 8));

                $quantity = $value;

                // Check if id & quantity are integers & if size has only alphanumeric characters
                if (preg_match('/\d{1,11}/', $product[0]) && preg_match('/[A-Za-z0-9]{1,5}/', $product[1]) && preg_match('/\d{1,5}/', $quantity)) {
                    // Insert in cart_product
                    $cart_product->create($user_cart->getId(), $product[0], $product[1], $quantity);

                    // Remove cookie
                    setcookie($key, '', -1);
                }
            }
        }
    }
}