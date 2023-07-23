<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    header('Location: index.php');
    die();
}

use App\Controller\Order;
use App\Controller\User;

$Order = new Order;
$orders = $Order->findForUser($_SESSION['user']->getId());

if (isset($_POST['submit-add-address'])) {
    $user = new User();

    try {
        $user->addAddress(
            $_POST['alias'],
            $_POST['address-line-1'],
            $_POST['address-line-2'],
            $_POST['city'],
            $_POST['postal-code'],
            $_POST['country'],
            $_POST['phone'],
            $_POST['mobile'],
            $_SESSION['user']->getId()
        );
    } catch (Exception $e) {
        $user_address_error = $e->getMessage();
    }
} elseif (isset($_POST['submit-edit-address'])) {
    $user = new User();

    try {
        $user->editAddress(
            $_POST['id'],
            $_POST['alias'],
            $_POST['address-line-1'],
            $_POST['address-line-2'],
            $_POST['city'],
            $_POST['postal-code'],
            $_POST['country'],
            $_POST['phone'],
            $_POST['mobile']
        );
    } catch (Exception $e) {
        $user_address_error = $e->getMessage();
    }
}

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GoogleFont-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link href="style/user.css" rel="stylesheet" type="text/css" />
    <link href="style/main.css" rel="stylesheet" type="text/css" />
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
        <!-- section qui détermine le contenu de la page -->
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
                    <h2>Bienvenue : <?= $_SESSION['user']->getFirstname() ?> <?= $_SESSION['user']->getLastname() ?><br></h2>
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
                    <input value="<?= $_SESSION['user']->getUsername() ?>" placeholder="<?= $_SESSION['user']->getUsername() ?>"><br>

                    <label>Nom :</label><br>
                    <input value="<?= $_SESSION['user']->getFirstname() ?>" placeholder="<?= $_SESSION['user']->getFirstname() ?>"><br>

                    <label>Prénom :</label><br>
                    <input value="<?= $_SESSION['user']->getLastname() ?>" placeholder="<?= $_SESSION['user']->getLastname() ?>"><br>

                    <label>e-mail :</label><br>
                    <input value="<?= $_SESSION['user']->getEmail() ?>" placeholder="<?= $_SESSION['user']->getEmail() ?>"><br>


                    <label>Ancient mot de passe :</label><br>
                    <input value="" placeholder=""><br>

                    <label>Nouveaux mot de passe :</label><br>
                    <input value="" placeholder=""><br>

                    <label>Confirmer mot de passe :</label><br>
                    <input value="" placeholder=""><br>
                </form>
            </section>

            <!-- page pour voir les commandes passées -->
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


            <!-- page pour voir et modifier les adresses stockées -->
            <section class="content" id="Adresses">
                <h2>Ajouter une adresse</h2>
                <form id="add-address-form" class="address-form" action="" method="post">
                    <p>Les champs précédés d'un <span class="mandatory">*</span> sont obligatoires.</p>

                    <label for="alias">Alias
                        <span class="mandatory">*</span>
                    </label>
                    <input type="text" name="alias" id="alias" placeholder="Exemples : maison, travail...">

                    <label for="address-line-1">Adresse
                        <span class="mandatory">*</span>
                    </label>
                    <input type="text" name="address-line-1" id="address-line-1">

                    <label for="address-line-2">Adresse (ligne 2)</label>
                    <input type="text" name="address-line-2" id="address-line-2">

                    <label for="city">Ville
                        <span class="mandatory">*</span>
                    </label>
                    <input type="text" name="city" id="city">

                    <label for="postal-code">Code Postal
                        <span class="mandatory">*</span>
                    </label>
                    <input type="text" name="postal-code" id="postal-code">

                    <label for="country">Pays
                        <span class="mandatory">*</span>
                    </label>
                    <input type="text" name="country" id="country">

                    <label for="phone">Téléphone
                        <span class="mandatory">*</span>
                    </label>
                    <input type="tel" name="phone" id="phone" placeholder="+33XXXXXXXXX">

                    <label for="mobile">Mobile</label>
                    <input type="tel" name="mobile" id="mobile" placeholder="+33XXXXXXXXX">

                    <input type="submit" class="BtSubmit" name="submit-add-address" value="Ajouter">

                    <?php if (isset($user_address_error)) : ?>
                        <div class="validation"><?= $user_address_error ?></div>
                    <?php endif ?>
                    </div>
                </form>

                <h2>Mes adresses</h2>

                <?php

                $user = new User();

                $user_addresses = $user->getAllAddresses($_SESSION['user']->getId());

                ob_start();

                if ($user_addresses) {

                    // To identify each html form in front-end
                    $current_address_form = 1;

                    foreach ($user_addresses as $address) {

                ?>

                        <form id="edit-address-form_<?= $current_address_form ?>" class="address-form" action="" method="post">
                            <p>Les champs précédés d'un <span class="mandatory">*</span> sont obligatoires.</p>

                            <label for="alias_<?= $current_address_form ?>">Alias
                                <span class="mandatory">*</span>
                            </label>
                            <input type="text" name="alias" id="alias_<?= $current_address_form ?>" placeholder="Exemples : maison, travail..." value="<?= $address->getAlias() ?>">

                            <label for="address-line-1_<?= $current_address_form ?>">Adresse
                                <span class="mandatory">*</span>
                            </label>
                            <input type="text" name="address-line-1" id="address-line-1_<?= $current_address_form ?>" value="<?= $address->getAddressLine1() ?>">

                            <label for="address-line-2_<?= $current_address_form ?>">Adresse (ligne 2)</label>
                            <input type="text" name="address-line-2" id="address-line-2_<?= $current_address_form ?>" value="<?= $address->getAddressLine2() ?>">

                            <label for="city_<?= $current_address_form ?>">Ville
                                <span class="mandatory">*</span>
                            </label>
                            <input type="text" name="city" id="city_<?= $current_address_form ?>" value="<?= $address->getCity() ?>">

                            <label for="postal-code_<?= $current_address_form ?>">Code Postal
                                <span class="mandatory">*</span>
                            </label>
                            <input type="text" name="postal-code" id="postal-code_<?= $current_address_form ?>" value="<?= $address->getPostalCode() ?>">

                            <label for="country_<?= $current_address_form ?>">Pays
                                <span class="mandatory">*</span>
                            </label>
                            <input type="text" name="country" id="country_<?= $current_address_form ?>" value="<?= $address->getCountry() ?>">

                            <label for="phone_<?= $current_address_form ?>">Téléphone
                                <span class="mandatory">*</span>
                            </label>
                            <input type="tel" name="phone" id="phone_<?= $current_address_form ?>" placeholder="+33XXXXXXXXX" value="<?= $address->getPhone() ?>">

                            <label for="mobile_<?= $current_address_form ?>">Mobile</label>
                            <input type="tel" name="mobile" id="mobile_<?= $current_address_form ?>" placeholder="+33XXXXXXXXX" value="<?= $address->getMobile() ?>">

                            <input type="hidden" name="isqdqsdd" value="<?= base64_encode($address->getId()) ?>">
                            <input type="hidden" name="id" value="<?= $address->getId() ?>">

                            <input type="submit" class="BtSubmit" name="submit-edit-address" value="Modifier">

                            <?php if (isset($user_address_error)) : ?>
                                <div class="validation"><?= $user_address_error ?></div>
                            <?php endif ?>
                        </form>
                <?php

                        $current_address_form++;
                    }
                } else {
                    echo '<p>Aucune addresse actuellement</p>';
                }


                echo ob_get_clean();

                ?>
            </section>

        </section>

    </main>
    <?php require_once("includes/footer.php") ?>

</body>

</html>