<body>
    <header id="WideScreenView">
        <div>
            <a href="index.php">4-Saisons </a> &emsp;
            <a href="Boutique.php">Boutique </a> &emsp;
            <i class="fa-sharp fa-solid fa-magnifying-glass fa-xs" onclick="Recherche()" id="SearchIcon"></i>
            <i class="fa-solid fa-square-minus fa-xs" onclick="Recherche()" id="SearchHide"></i>
            <input id="SearchBar" placeholder="Rechercher"></input>
        </div>
        <div>
            <?php 
            if (isset($_SESSION['user'])){
                echo '<a id="User" href="user.php"><i class="fa-solid fa-user"></i></a>&emsp;';
                if ($_SESSION['role']=="admin"){
                    echo '<i class="fa-solid fa-play" onclick="SetSaisons()"></i>';
                    echo '<a href="admin.php"><i class="fa-solid fa-toolbox"></i></a>';
                }
            }
            ?>
            <a id="User" onclick="ShowUser()"><i class="fa-solid fa-user"></i></a>&emsp;
            <a href="panier.php"><i class="fa-solid fa-cart-shopping"></i></a>

        </div>
    </header>

    <header id="MobileScreenView">
        <a href="index.php">4-Saisons </a>
        <a href="Boutique.php">Boutique </a>
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

        <?php require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .  'src' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'auth.php'; ?>

    </div>
</body>

</html>