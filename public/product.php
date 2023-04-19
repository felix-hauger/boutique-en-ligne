<?php

//check if an article is selected, if not the user will be redirected to index
if (!isset($_GET['id'])) {
    header('Location: index.php');
    die();
}


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;
use App\Controller\Product;

//session start apres l'autoload sinon bug lors de la connexion
session_start();

$product_controller = new Product();


if (preg_match('/^\d+$/', $_GET['id'])) {
    try {
        $product = $product_controller->get($_GET['id']);
    } catch (Exception $e) {
        http_response_code(404);
        die('<h1>' . $e->getMessage() . '</h1><a href="index.php">Retour à l\'accueil</a>');
    }
} else {
    http_response_code(404);
    die('<h1>Page introuvable.</h1><a href="index.php">Retour à l\'accueil</a>');
}

// var_dump($product);
// die();

//Select everything from product to redistribute
$sql = "SELECT * FROM product WHERE id = " . $_GET["id"] . "";
$select = DbConnection::getPdo()->prepare($sql);
if ($select->execute()) {
    //put everything in $result
    $result = $select->fetch(\PDO::FETCH_ASSOC);
}


//find the id of the category of this article
//get all info from this category
$sql = "SELECT * FROM `category` WHERE id = " . $result['category_id'] . ";";

$select = DbConnection::getPdo()->prepare($sql);

if ($select->execute()) {
    //put everything in $Cat
    $Cat = $select->fetch(\PDO::FETCH_ASSOC);
}
$sql = "SELECT * FROM `stock` WHERE `product_id` = " . $result['id'] . "";

$select = DbConnection::getPdo()->prepare($sql);

if ($select->execute()) {
    //put everything in $Cat
    $stock = $select->fetch(\PDO::FETCH_ASSOC);
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
        <?= $result['name'] ?>
    </title>

</head>

<body>
    <?php require_once("includes/header.php"); ?>


    <main>

        <div id="image">
            <img id="imgProduct" src="<?= $result['image'] ?>" width="100%">
        </div>

        <div id="description">

            <div id="UpperContainer">
                <div id="infoBox">
                    <h1>
                        <?= $result['name'] ?>
                    </h1><br>
                    <div id="Catégories">&emsp;
                        <?= "#", $Cat['name'] ?>
                    </div><br>
                    <div id="Price">&nbsp;&nbsp;
                        <?= $result['price'], "€" ?>
                    </div>
                </div>

                <div id="BtBox">
                    <button class="BtPanier" id="Ajouter">Ajouter au Panier</button><br>
                    <button class="BtPanier" id="Acheter">Acheter cet article</button>
                </div>
            </div>

            <div id="QuantityBox">
                <table>
                    <caption>Tailles disponibles</caption>
                    <tr>
                        <td><button id="XS" class="BtSize"
                                onclick='SizeSelected("xs", <?= json_encode($stock) ?>)'>XS</button></td>
                        <td><button id="S" class="BtSize"
                                onclick='SizeSelected("s", <?= json_encode($stock) ?>)'>S</button></td>
                        <td><button id="M" class="BtSize"
                                onclick='SizeSelected("m", <?= json_encode($stock) ?>)'>M</button></td>
                        <td><button id="L" class="BtSize"
                                onclick='SizeSelected("l", <?= json_encode($stock) ?>)'>L</button></td>
                        <td><button id="XL" class="BtSize"
                                onclick='SizeSelected("xl", <?= json_encode($stock) ?>)'>XL</button></td>
                        <td><button id="XXL" class="BtSize"
                                onclick='SizeSelected("xxl", <?= json_encode($stock) ?>)'>XXL</button></td>
                    </tr>
                    <tr>
                        <td>
                            <?= $stock['xs'] ?>
                        </td>
                        <td>
                            <?= $stock['s'] ?>
                        </td>
                        <td>
                            <?= $stock['m'] ?>
                        </td>
                        <td>
                            <?= $stock['l'] ?>
                        </td>
                        <td>
                            <?= $stock['xl'] ?>
                        </td>
                        <td>
                            <?= $stock['xxl'] ?>
                        </td>
                    </tr>
                </table>

                <input id="SizeSelected" value="x" hidden></input>

                <div id="BtInputBox">
                    <i id="BtInputSub" class="fa-sharp fa-solid fa-play fa-xl fa-flip-horizontal"
                        onclick="InputQuantitySub()"></i>
                    <input id="InputQuantity" placeholder="1"></input>
                    <i id="BtInputAdd" class="fa-sharp fa-solid fa-play fa-xl" onclick="InputQuantityAdd()"></i>
                </div>
            </div>


            <div id="DescriptionBox">
                <h2>Description du produit : </h2><br>
                <?= $result['description'] ?><br>
            </div>

        </div>

        </div>

    </main>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>