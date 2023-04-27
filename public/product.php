<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\Cart;
use App\Controller\Product;

//session start apres l'autoload sinon bug lors de la connexion
session_start();

// Handle cart for logged user, in asynchronous javascript
if (isset($_SESSION['user'])) {
    // If all necessary inputs are send using fetch & FormData
    if (isset($_POST['product_id']) && isset($_POST['product_quantity']) && isset($_POST['product_size'])) {
        $cart_controller = new Cart();

        // Add product to user cart, using logged user id
        $cart_controller->addProductToUserCart(
            $_SESSION['user']->getId(), 
            $_POST['product_id'], 
            $_POST['product_quantity'], 
            $_POST['product_size']
        );

        // Stop code execution
        die();
    }
}

//check if an article is selected, if not the user will be redirected to index
if (!isset($_GET['id'])) {
    header('Location: index.php');
    die();
}

// Test with regex if product id is an integer
if (preg_match('/^\d+$/', $_GET['id'])) {
    try {
        $product_controller = new Product();

        // * RETURN PRODUCT ENTITY CONTAINING PRODUCT DATA
        $product = $product_controller->getPageInfos($_GET['id']);

    } catch (Exception $e) {
        http_response_code(404);
        die('<div style="text-align:center;margin-top:5%"><h1>' . $e->getMessage() .'&ensp; :\'(</h1><p>Le produit que vous cherchez n\'existe pas, ou plus</p><br><a style="font-size:1.5em" href="index.php">Retour à l\'accueil</a><br><img style="margin-top:5%;opacity: 0.07;" src="https://art.pixilart.com/b416025df4c07f8.gif">');
    }
} else {
    http_response_code(404);
    die('<h1>Page introuvable.</h1><a href="index.php">Retour à l\'accueil</a>');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- MetaData -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link href="includes/footer.css" rel="stylesheet" type="text/css" />
    <link href="style/product.css" rel="stylesheet" type="text/css" />

    <!-- FontAwesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GoogleFont-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script async src="includes/header.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script async src="scripts/product.js"></script>
   
    

    <title>
        <?= $product->getName() . ' | Saisons à la mode' ?>
    </title>

</head>

<body>
    <?php require_once("includes/header.php"); ?>


    <main>

        <div id="image">
            <img id="imgProduct" src="<?= $product->getImage() ?>" width="100%">
        </div>

        <div id="description">

            <div id="UpperContainer">
                <div id="infoBox">
                    <h1>
                        <?= $product->getName() ?>
                    </h1><br>
                    <div id="Catégories">&emsp;                       
                        <?= "#", $product->getCategoryName() ?>
                        <?php
                        foreach ($product->getTags() as $tag) {
                            echo ' #', $tag->getName();
                        }
                        ?>
                    </div><br>
                    <div id="Price">&nbsp;&nbsp;
                        <?= $product->getPrice(), "€" ?>
                    </div>
                </div>

                <form id="BtBox">
                    <?php if (isset($_SESSION['user'])): ?>

                        <button class="BtPanier" id="AddLogged" value="<?= $product->getId(); ?>" >Ajouter au Panier</button><br>
                        

                    <?php else: ?>

                        <button class="BtPanier" id="AddNotLogged"onclick='Cookie(<?= $product->getId(); ?>)'>Ajouter au Panier</button><br>
                        <button class="BtPanier" id="BuyNotLogged">Acheter cet article</button>

                    <?php endif ?>
                </form>
            </div>

            <div id="QuantityBox">
                <table>
                    <caption>Tailles disponibles</caption>
                    <tr>
                        <td><button id="XS" class="BtSize"
                                onclick='SizeSelected("xs",<?= $product->getStock()->getXs() ?>)'>XS</button></td>
                        <td><button id="S" class="BtSize"
                                onclick='SizeSelected("s",<?= $product->getStock()->getS() ?>)'>S</button></td>
                        <td><button id="M" class="BtSize"
                                onclick='SizeSelected("m", <?= $product->getStock()->getM() ?>)'>M</button></td>
                        <td><button id="L" class="BtSize"
                                onclick='SizeSelected("l", <?= $product->getStock()->getL() ?>)'>L</button></td>
                        <td><button id="XL" class="BtSize"
                                onclick='SizeSelected("xl", <?= $product->getStock()->getXl() ?>)'>XL</button></td>
                        <td><button id="XXL" class="BtSize"
                                onclick='SizeSelected("xxl", <?= $product->getStock()->getXxl() ?>)'>XXL</button></td>
                    </tr>
                    <tr>
                        <td>
                            <?= $product->getStock()->getXs() ?>
                        </td>
                        <td>
                            <?= $product->getStock()->getS() ?>
                        </td>
                        <td>
                            <?= $product->getStock()->getM() ?>
                        </td>
                        <td>
                            <?= $product->getStock()->getL() ?>
                        </td>
                        <td>
                            <?= $product->getStock()->getXl() ?>
                        </td>
                        <td>
                            <?= $product->getStock()->getXxl() ?>
                        </td>
                    </tr>
                </table>


                <div id="BtInputBox">
                    <i id="BtInputSub" class="fa-sharp fa-solid fa-play fa-xl fa-flip-horizontal"
                        onclick="InputQuantitySub()"></i>
                    <input id="InputQuantity" placeholder="1"></input>
                    <i id="BtInputAdd" class="fa-sharp fa-solid fa-play fa-xl" onclick="InputQuantityAdd()"></i>
                </div>
            </div>


            <div id="DescriptionBox">
                <h2>Description du produit : </h2><br>
                <?= $product->getDescription() ?><br>
            </div>

        </div>

        </div>

    </main>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>