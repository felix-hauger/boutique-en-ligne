<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Config\DbConnection;
//Selecte everything from product to redistribute
$sql = 'SELECT * FROM product';
$select = DbConnection::getPdo()->prepare($sql);
if ($select->execute()) {
    //put everything in $result
    $result=$select->fetchAll(\PDO::FETCH_ASSOC);
 }
//get rid of the encapsulating array
$result = $result[0];

//find the id of the category of this article
$idCat = $result['category_id'];
//get all info from this category
$sql = "SELECT * FROM `category` WHERE id = $idCat;";

$select = DbConnection::getPdo()->prepare($sql);

if ($select->execute()) {
    //put everything in $Cat
    $Cat=$select->fetchAll(\PDO::FETCH_ASSOC);
 }
//get rid of the encapsulating array
$Cat = $Cat[0];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/product.css" rel="stylesheet" type="text/css" />
    <script async src="scripts/product.js"></script>
    <title><?= $result['name'] ?></title>
</head>

<body>
    <?php require_once("includes/header.php"); ?>
    <i class="fa-solid fa-play" onclick="SetSaisons()"></i>


    <main>
        <div id="image">
            <img id="imgProduct" src="<?= $result['image'] ?>" width="100%" >
        </div>

        <div id="description">

            <div id="UpperContainer">
                <div id="infoBox">
                    <h1><?= $result['name'] ?></h1><br>
                    <div id="Catégories">&emsp;<?= "#", $Cat['name'] ?></div><br>
                    <div id="Price">&nbsp;&nbsp;<?= $result['price'], "€" ?></div><br><br>
                    <div id="QuantityBox">
                    &emsp;<i id="BtInput" class="fa-sharp fa-solid fa-play fa-flip-horizontal" onclick="InputQuantitySub()"></i>
                        <input id="InputQuantity" placeholder="1"></input>
                        <i id="BtInput" class="fa-sharp fa-solid fa-play" onclick="InputQuantityAdd(<?= $result['quantity'] ?>)"></i>
                    </div>
                </div>

                <div id="BtBox">
                    <button class="BtPanier" id="Ajouter">Ajouter au Panier</button><br>
                    <button class="BtPanier" id="Acheter">Acheter cet article</button>
                </div>

            </div>
            <div id="DescriptionBox">
                <h2>Description du produit : </h2><br>
            <?= $result['description'] ?><br>
            </div>
        </div>

    </main>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>