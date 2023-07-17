<?php
if (isset($_GET['id'])) {
    $_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?id=" . $_GET['id'];
} else {
    $_SESSION['url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
}

?>

<body>
    <header id="WideScreenView">
        <div>
            <a href="index.php">4-Saisons </a> &emsp;
            <a href="shop.php">Boutique </a> &emsp;
            <i class="fa-sharp fa-solid fa-magnifying-glass fa-xs" onclick="Recherche()" id="SearchIcon"></i>
            <i class="fa-solid fa-square-minus fa-xs" onclick="Recherche()" id="SearchHide"></i>
            <input type="search" id="SearchBar" placeholder="Rechercher"></input>
            <ul id="SearchResult"></ul>
        </div>
        <div>
            <?php
            if (isset($_SESSION['user'])) {
                echo '<a title="Vos Informations" id="User" href="user.php"><i class="fa-solid fa-user"></i></a>&emsp;';
                echo '<a title="Vous Déconnecter" href="disconnect.php"><i class="fa-solid fa-user-slash"></i></a>&emsp;';
                if ($_SESSION['user']->getRoleId() === 1) {
                    echo '<i title="Changer le Theme" class="fa-solid fa-paint-roller" onclick="ChangeSeason()"></i>&emsp;';
                    echo '<a title="Option D\'administration" href="admin.php"><i class="fa-solid fa-toolbox"></i></a>&emsp;';
                    echo '<a title="Ajouter un Article" href="add-product.php"> <i class="fa-solid fa-file-circle-plus"></i></a>&emsp;';
                } else if ($_SESSION['user']->getRoleId() === 3) {
                    echo '<a title="Ajouter un Article" href="add-product.php"> <i class="fa-solid fa-file-circle-plus"></i></a>&emsp;';
                }
            } else {
                echo '<a title="Se Connecter" id="User" onclick="ShowUser()"><i class="fa-solid fa-user"></i></a>&emsp;';
            }
            ?>
            <span title="Nombre d'articles dans votre panier" id="CartCount"></span>
            <a title="Votre Panier" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>

        </div>

    </header>

    <header id="MobileScreenView">
        <a href="index.php">4-Saisons </a>
        <a href="shop.php">Boutique </a>
    </header>

    <div id="OptionMobile">
        <div>
            <i id="SearchIconMobile" class="fa-sharp fa-solid fa-magnifying-glass fa-2xl" onclick="Recherche()"></i>
            <i id="SearchHideMobile" class="fa-solid fa-square-minus fa-2xl" onclick="Recherche()"></i>
            <input id="SearchBarMobile" placeholder="Rechercher"></input>
        </div>

        <a id="UserMobile" onclick="ShowUser()"><i class="fa-solid fa-user fa-2xl"></i></a>
        <a id="CartMobile" href="panier.php"><i class="fa-solid fa-cart-shopping fa-2xl"></i></a>
    </div>

    <div id="popup" onclick="HideUser()">

        <?php require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'auth.php'; ?>

    </div>
</body>

</html>