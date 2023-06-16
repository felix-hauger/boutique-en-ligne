<?php


require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';


use \App\Model\Articles;

include "includes/header.php";
// require "class/Article.php";

$articles = new Articles();

// On determine sur quelle page on se trouve
if(isset($_GET["start"]) && !empty($_GET["start"])){
    $getStart = htmlspecialchars($_GET["start"]);
    $getStart = (int)($_GET["start"]);
    // $currentPage = (int) strip_tags($_GET["start"]);
    $currentPage = (int)($getStart);
}else{
    $currentPage = 1;
}


$nbArticles = $articles->total_number_articles();
 //var_dump($nbArticles); //OK

// On détermine le nombre d articles par page
$parPage = 5;
// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);
echo $pages;

// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$get_page = $articles->get_by_page($premier,$parPage);

//var_dump($get_page);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- MetaData -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link href="includes/footer.css" rel="stylesheet" type="text/css" />

    <!-- FontAwesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GoogleFont-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script async src="includes/header.js"></script>

<main class="main-first">
    <div class="row">
        <section>
        <h1 class="title-main">Liste des articles</h1>
            <table id="customers">
                <thead>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Images</th> 
                </thead>
                <tbody>
                    <?php
                    foreach($get_page as $article){
                        // var_dump($article);
                    ?>
                        <div>
                        <div><a href="product.php?id=<?= $article["id"] ?>"><img src="public/images/<?php echo $article["image"] ?>" alt=""></a></div>
                            <div><a href="product.php?id=<?= $article["id"] ?>"><?= $article["name"] ?></a></div>
                            <div><a href="product.php?id=<?= $article["id"] ?>"><?= $article["price"] ?></a></div>
                            
                      </div>
                    <?php
                    }
                    ?>
                
            
            <nav class="container-pagination">
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="Boutique.php?start=<?= $currentPage - 1 ?>" class="page-link"><</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="Boutique.php?start=<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                        <?php 
                        if ($currentPage == $pages){
                            ?>
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            </li>
                            <?php
                        }else{
                            ?>
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="Boutique.php?start=<?= $currentPage + 1 ?>" class="page-link">></a>
                            <?php
                        }
                        ?>
                        
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</main>


<?php
include "includes/footer.php";
?>