<?php



require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;
use App\Controller\Product;

session_start();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
    <script async src="scripts/product.js"></script>

    <title>Panier | Saisons à la mode</title>
</head>

<body>

    <?php require_once("includes/header.php") ?>

    <main>
        <section id="cart-items">
            <table>
                <?php
                foreach ($_COOKIE as $key => $val) {
                    // le cookie est divisé en plusieures partie    product(string)  id   taille  quantité
                    list($checkCookie, $product_id, $size) = explode("_", $key);
                    //pour etre sur que l'on récupere que les cookie de notre panier
                    if ($checkCookie == "product") {
                        //on récupere les info de l'article 
                        $product = GetProduct($product_id);

                        echo '<tr>';
                        echo "<td class='Tdbg' rowspan='2' class='TdImage'><img class='imageCart' src='" . $product['image'] . "'></td>";
                        echo "<td class='Tdbg' ><b>" . $product['name'] . "</b></td>";
                        echo "<td class='Tdbg' >Taille : <b>" . $size . "</b></td>";
                        echo "<td class='Tdbg' >Quantité : <b>" . $val . "</b></td>";

                        if ($val > 1) {
                            $Nprice = $product['price'] * $val;
                            array_push($TOTAL, [$product['name'], $Nprice]);
                            echo "<td class='Tdbg' ><b>" . $Nprice . "€</b><br>";
                            echo "(" . $product['price'] . "€ x " . $val . ")";
                            echo "</td>";
                        } else {
                            echo "<td class='Tdbg' ><b>" . $product['price'] . "€</b></td>";
                            array_push($TOTAL, [$product['name'], $product['price']]);
                        }

                        echo '</tr>';

                        echo '<tr>';
                            echo "<td class='TdDesc' colspan='3'>" . $product['description'] . "</td>";
                            echo "<td><button onclick='SupprimerCookie(\"".$key."\")'>Supprimer L'article</button></td>";
                        echo '</tr>';


                    }
                }


                ?>
            </table>
        </section>

        <section id="cart-action">
            <section id="cart-check">
                <table>
                    <?php foreach ($TOTAL as $T_array) {
                        echo "<tr>";

                        foreach ($T_array as $T_prix) {
                            if (is_string($T_prix)) {
                                echo "<td>" . $T_prix . "</td>";
                            } else {
                                echo "<td>" . $T_prix . "€</td>";
                            }

                        }
                    } ?>
                </table>
            </section>

            <section id="cart-buttons">
                <button>Passer Commande</button>
            </section>
        </section>
    </main>



    <?php require_once("includes/footer.php") ?>

</body>

</html>