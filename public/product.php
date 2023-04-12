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

    <title><?= $result['name'] ?></title>

</head>

<body>
    <?php require_once("includes/header.php"); ?>


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