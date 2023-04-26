<?php
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Controller\Admin;

$admin = new Admin;
$products=$admin->getAllInfoPreview();

echo '<div id="BoxButton" onclick="RedirectAddProduct()"><button id="AddButton">Ajouter un article</button></div>';


echo '<table class="TBAffichage">';
echo '<tr class="Desc"><td><b>Produit : </b></td><td><b>Description : </b></td><td><b>&emsp;Prix : &emsp;</b></td><td><b>Quantité vendue : </b></td><td colspan="2"><b>Commandes </b></td></tr>';
foreach ($products as $product) {


    echo '<tr>';
    echo '<td>';
    echo $product['name'];
    echo '</td>';

    echo '<td class="description">';
    echo $product['preview']." ...";
    echo '</td>';

    echo '<td>';
    echo $product['price'].' €';
    echo '</td>';


    echo '<td>';
    echo $product['quantity_sold'];
    echo '</td>';

   
    echo '<td><button>modifier l\'Article</button></td>';
    echo '<td><button class="Supprimer">Supprimer l\'article</button></td>';


}
echo "</table>";
?>