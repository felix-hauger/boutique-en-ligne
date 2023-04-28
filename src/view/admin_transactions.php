<?php
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Controller\Order;

$Order = new Order;
$orders = $Order->findALL();

function table($orders){
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>".$order['order_id']."</td>";
        echo "<td>".$order['user_id']."</td>";
        echo "<td>".$order['name']."</td>";
        echo "<td>".$order['id']."</td>";
        echo "<td>".$order['unit_price']."</td>";
        echo "<td>".$order['price']."</td>";
        echo "<td>".$order['discount_id']."</td>";
        echo "<td>".$order['product_quantity']."</td>";
        echo "<td>".$order['product_size']."</td>";
        echo "</tr>";
    }
}
?>

<table class="TBAffichage">
    <tr class="Desc"><td>ID Commande</td><td>ID User</td><td>Nom Produit</td><td>ID Produit</td><td>Prix Payé</td><td>Prix Actuel</td><td>ID Réduction</td><td>Quantité</td><td>Taille</td></tr>
    <?php table($orders) ?>
</table>