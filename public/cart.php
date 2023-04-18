<?php

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
    <script async src="scripts/index.js"></script>
    <!-- slider de https://swiperjs.com/-->
    <script async src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>

    <title>Panier | Saisons à la mode</title>
</head>
<body>

    <?php require_once("includes/header.php") ?>

    <main>
        <section id="cart-items">
            <?php for ($i = 0; $i < 10; $i++): ?>
                <div class="cart-item">
                    <p>Article <?= $i+1 ?></p>
                    <div>Prix : 20 €</div>
                </div>
            <?php endfor ?>
        
        </section>
    
        <section id="cart-action">
            <section id="cart-check">

            </section>
        
            <section id="cart-buttons">
    
            </section>
        </section>
    </main>



    <?php require_once("includes/footer.php") ?>

</body>
</html>