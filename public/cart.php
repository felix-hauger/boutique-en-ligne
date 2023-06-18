<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;
use App\Controller\Cart as CartController;
use App\Controller\Order;
use App\Controller\Product as ProductController;
use App\Entity\Cart as CartEntity;

session_start();

$cart_controller = new CartController();

$cart = new CartEntity();

$product_controller = new ProductController();

$cookies_cart_items = [];


if (isset($_SESSION['user'])) {
    $logged_user_cart = $cart_controller->getByUser($_SESSION['user']->getId());

    if (isset($_POST['confirm-order'])) {
        $order_controller = new Order();

        $order_controller->createFromCart($logged_user_cart);
    } elseif (isset($_POST['delete-cart-item'])) {
        $cart_controller->deleteItem($_POST['delete-cart-item']);
    }

    // $cart_controller->transferCookieCartItemsToLoggedUser();

    // var_dump($_SESSION);

    // if (!empty($cookies_cart_items)) {
    //     var_dump($cookies_cart_items);
    // }


    // $logged_user_cart = $cart_controller->getByUser($_SESSION['user']->getId());

    // if ($logged_user_cart) {
    //     var_dump($logged_user_cart);
    // }
} else {

    foreach ($_COOKIE as $key => $val) {

        if (substr($key, 0, 7) == "product") {
            // le cookie est divisé en plusieures partie    product(string)  id   taille => quantité
            list($ignore, $product_id, $size) = explode("_", $key);
            //pour etre sur que l'on récupere que les cookie de notre panier

            // $product = $product_controller->get

            $item = $cart_controller->getCookieItemInfos($product_id);

            $item['size'] = $size;
            $item['quantity'] = $val;
            // $item->setSize($size);

            //on récupere les info de l'article
            $cookies_cart_items[] = $item;
        }
    }

    // var_dump($cart_items);
}
// var_dump($_COOKIE);

function GetProduct($product_id)
{
    $sql = "SELECT * FROM product WHERE id = " . $product_id;
    $select = DbConnection::getPdo()->prepare($sql);
    if ($select->execute()) {
        $products = $select->fetch(\PDO::FETCH_ASSOC);
        return $products;
    }
}

$TOTAL = [];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- MetaData -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- FontAwesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GoogleFont-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="style/index.css" rel="stylesheet" type="text/css" />
    <link href="style/cart.css" rel="stylesheet" type="text/css" />
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link href="includes/footer.css" rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    <script async src="includes/header.js"></script>
    <script async src="scripts/cart.js"></script>

    <title>Panier | Saisons à la mode</title>
</head>

<body>

    <?php require_once("includes/header.php") ?>

    <main>
        <section id="cart-items">
            <table>
                <?php

                if (isset($logged_user_cart)) {
                    // var_dump($_SESSION);

                    if (!empty($cookies_cart_items)) {
                        // Move cookies in user cart in database
                    }

                    $logged_user_cart = $cart_controller->getByUser($_SESSION['user']->getId());

                    // var_dump($logged_user_cart);

                    foreach ($logged_user_cart->getItems() as $item) {
                        echo CartController::toHtmlItem($item);

                        if ($item['quantity'] > 1) {
                            // var_dump($item);
                            $Nprice = $item['price'] * $item['quantity'];
                            array_push($TOTAL, [$item['name'] . "<b> x " . $item['quantity'] . "</b>", $Nprice]);
                        } else {
                            array_push($TOTAL, [$item['name'], $item['price']]);
                        }
                    }

                    // var_dump($logged_user_cart);
                } else {
                    foreach ($cookies_cart_items as $item) {
                        echo CartController::toHtmlCookieItem($item);

                        if ($item['quantity'] > 1) {
                            $Nprice = $item['price'] * $item['quantity'];
                            array_push($TOTAL, [$item['name'] . "<b> x " . $item['quantity'] . "</b>", $Nprice]);
                        } else {
                            array_push($TOTAL, [$item['name'], $item['price']]);
                        }
                    }
                }

                ?>
            </table>
        </section>

        <section id="cart-action">
            <section id="cart-check">
                <table>
                    <td><b>Nom du Produit: </b></td>
                    <td class='TOTALPrix'><b>Prix : </b></td>
                    <?php

                    $PRIX_TOTAL = 0;

                    foreach ($TOTAL as $T_Subarray) {
                        echo "<tr>";

                        foreach ($T_Subarray as $elements) {
                            //si l'élément récupéré est une string ( nom du produit )
                            if (is_string($elements)) {
                                echo "<td class='TOTALNom'>&ensp;-&ensp;" . $elements . " </td>";
                            }
                            //sinon c'est un int ( prix du produit)
                            else {
                                echo "<td class='TOTALPrix'>" . $elements . "€</td>";
                                $PRIX_TOTAL = $PRIX_TOTAL + $elements;
                            }
                        }
                    }
                    ?>
                </table>

            </section>

            <section id="cart-buttons">
                <div id="Total"><b>TOTAL : <?= $PRIX_TOTAL ?>€</b></div>
                <form action="" method="post">
                    <button type="submit" name="confirm-order">Passer Commande</button>
                </form>
            </section>
        </section>
    </main>



    <?php require_once("includes/footer.php") ?>

</body>

</html>