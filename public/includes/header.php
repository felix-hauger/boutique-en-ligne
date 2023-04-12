<!DOCTYPE html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <script async src="includes/header.js"></script>
</head>

<body>
    <header>
        <div>
            <a href="index.php">4-Saisons </a> &emsp;
            <a href="Boutique.php">Boutique </a> &emsp;
            <i class="fa-sharp fa-solid fa-magnifying-glass fa-xs" onclick="Recherche()" id="SearchIcon"></i>
            <i class="fa-solid fa-square-minus fa-xs" onclick="Recherche()" id="SearchHide"></i>
            <input id="SearchBar" placeholder="Rechercher"></input>
        </div>
        <div>
            <a id="User" onclick="ShowUser()"><i class="fa-solid fa-user"></i></a>&emsp;
            <a href="panier.php"><i class="fa-solid fa-cart-shopping"></i></a>

        </div>
    </header>
    <!--<i class="fa-solid fa-play" onclick="SetSaisons()"></i> BT changement de saison  -->
    <div id="popup" onclick="HideUser()">

        <?php require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR .  'src' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'auth.php'; ?>

    </div>
</body>

</html>