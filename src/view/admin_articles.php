<?php


require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;


$sql = "SELECT * FROM product";
$select = DbConnection::getPdo()->prepare($sql);
if ($select->execute()) {
    $products = $select->fetchall(\PDO::FETCH_ASSOC);
}
echo '<table class="TBAffichage">';

foreach ($products as $product) {


    echo '<tr>';
    echo '<td>';
    echo 'Produit : ' . $product['name'];
    echo '</td>';

    echo '<td>';
    echo 'Prix : ' . $product['price'];
    echo '</td>';


    echo '<td>';
    echo 'E-Mail : ' . $product['quantity_sold'];
    echo '</td>';

   
    echo '<td><button>modifier l\'Article</button></td>';
    echo '<td><button class="Supprimer">Supprimer l\'user</button></td>';


}
echo "</table>";
?>