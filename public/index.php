<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Config\DbConnection;

session_start();

$sql = 'SELECT * FROM product';
$select = DbConnection::getPdo()->prepare($sql);
if ($select->execute()) {
    //put everything in $result
    $result = $select->fetch(\PDO::FETCH_ASSOC);
}
// session_destroy();

// var_dump($_SESSION);

// use App\Config\DbConnection;
// use App\Model\User as UserModel;
// use App\Controller\User as UserController;
// use App\Entity\User as UserEntity;
// use App\Model\AbstractModel;
// use App\Controller\Test\Test;

// $userModel = new UserModel();
// $userController = new UserController();
// $userEntity = new UserEntity();


// $m = new AbstractModel();

// var_dump(get_class($m));
// $test = new Test();
// var_dump($test->__toString())


function DisplayArticle($result)
{
    echo '<div class="carte">';
    echo '<img class="image" src="' . $result['image'] . '">';
    echo '<h2 class="NomArticle">' . $result['name'] . '</h2>';
    echo '<h3 class="prix">' . $result['price'] . ' € </h3>';
    echo '<form id="redirection" method="get" action="product.php">';
    echo '<input type="hidden" name="Article" value="' . $result['id'] . '" />';
    echo '<button class="BtVoirArticle" type="submit">Voir cet article</button></form>';
    echo '</div>';
}

?>
<!DOCTYPE html>
<html lang="en">

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
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link href="includes/footer.css" rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    <script async src="includes/header.js"></script>
    <script async src="scripts/index.js"></script>
    <!-- slider de https://swiperjs.com/-->
    <script async src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-element-bundle.min.js"></script>


    <title>Titre</title>

</head>

<body>
    <?php require_once("includes/header.php") ?>


    <section class="sectionShop">
        <h2>Articles les plus vendus</h2>
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" loop="true" space-between="30" 
            slides-per-view="4">
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
        </swiper-container>
    </section>

    <section class="sectionShop">
        <h2>Nos derniers articles</h2>
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" loop="true" space-between="30" 
            slides-per-view="4">
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
        </swiper-container>
    </section>

    <section id="derniereSection" class="sectionShop">
        <h2>Articles de Saison</h2>
        <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" navigation="true" loop="true" space-between="30" 
            slides-per-view="4">
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
            <swiper-slide>
                <?php DisplayArticle($result); ?>
            </swiper-slide>
        </swiper-container>
    </section>


    <?php require_once("includes/footer.php") ?>
</body>

</html>