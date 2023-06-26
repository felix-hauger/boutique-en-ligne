<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    header('Location: index.php');
    die();
}

use App\Controller\Order;

$Order = new Order;
$orders = $Order->findForUser($_SESSION['user']->getId());


function table($orders)
{
    $counter = 0;
    foreach ($orders as $order) {
        echo "<tr id='row" . $counter . "'>";
        echo "<td>" . $order['order_id'] . "</td>";
        echo "<td>" . $order['name'] . "</td>";
        echo "<td>" . $order['id'] . "</td>";
        echo "<td>" . $order['unit_price'] . "</td>";
        echo "<td>" . $order['product_quantity'] . "</td>";
        echo "<td>" . $order['product_size'] . "</td>";
        echo "</tr>";
        $counter++;
    }
}

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
    <link href="style/user.css" rel="stylesheet" type="text/css" />
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link href="includes/footer.css" rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    <script defer src="includes/header.js"></script>
    <script defer src="scripts/user.js"></script>

    <title>Utilisateur | Saisons à la mode</title>
</head>

<body>
    <?php require_once("includes/header.php") ?>
    <main>
        <!-- section qui détéermine le contenu de la page -->
        <section id="LeftMenu">
            <h1>Bienvenue
                <?= $_SESSION['user']->getUsername() ?>
            </h1>
            <div id="options">
                <button id="Btmodifprofil" onclick="SelectContent('modifprofil')">Modifier Votre Profil</button><br>
                <button id="BtVoirAchats" onclick="SelectContent('VoirAchats')">Voir mes Achats</button><br>
                <button id="BtAdresses" onclick="SelectContent('Adresses')">Adresses Stockées</button><br>
            </div>
        </section>




        <!-- le contenu de la page -->
        <section id="RightContent">
            <!-- page d'acceuil , affichage par defaut -->
            <section class="content" id="Acceuil">
                <div>
                    <h2>Bienvenue : <?= $_SESSION['user']->getFirstname() ?>  <?= $_SESSION['user']->getLastname() ?><br></h2>
                    <hr>
                    <h3>Votre Identifiant :</h3><?= $_SESSION['user']->getUsername() ?><br><br>
                    <h3>Votre adresse e-mail :</h3><?= $_SESSION['user']->getEmail() ?><br><br>
                    <h3>Inscrit depuis :</h3>27/04/23
                </div>

                <div>
                   
                    
                    
                    
                </div>

               

            </section>

            <!-- page de modification de profil -->
            <section class="content" id="modifprofil">
                <form>
                    <label>Username :</label><br>
                    <input value="<?= $_SESSION['user']->getUsername() ?>"
                        placeholder="<?= $_SESSION['user']->getUsername() ?>"><br>

                    <label>Nom :</label><br>
                    <input value="<?= $_SESSION['user']->getFirstname() ?>"
                        placeholder="<?= $_SESSION['user']->getFirstname() ?>"><br>

                    <label>Prénom :</label><br>
                    <input value="<?= $_SESSION['user']->getLastname() ?>"
                        placeholder="<?= $_SESSION['user']->getLastname() ?>"><br>

                    <label>e-mail :</label><br>
                    <input value="<?= $_SESSION['user']->getEmail() ?>"
                        placeholder="<?= $_SESSION['user']->getEmail() ?>"><br>


                    <label>Ancient mot de passe :</label><br>
                    <input value="" placeholder=""><br>

                    <label>Nouveaux mot de passe :</label><br>
                    <input value="" placeholder=""><br>

                    <label>Confirmer mot de passe :</label><br>
                    <input value="" placeholder=""><br>
                </form>
            </section>

            <!-- page pour voir les commandes passés -->
            <section class="content" id="VoirAchats">
                <table class="TBAffichage">
                    <tr class="Desc">
                        <td>ID Commande</td>
                        <td>Nom Produit</td>
                        <td>ID Produit</td>
                        <td>Prix Payé</td>
                        <td>Quantité</td>
                        <td>Taille</td>
                    </tr>
                    <?php table($orders) ?>
                </table>
            </section>


            <!-- page pour voir et modifier les adresses stockées-->
            <section class="content" id="Adresses">
                Fonction encore non implémenté

            </section>

        </section>

    </main>
    <?php require_once("includes/footer.php") ?>

</body>

</html>