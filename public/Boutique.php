<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';
use \App\Model\Articles;

include "includes/header.php";
// require "class/Article.php";

$articles = new Articles();

// On determine sur quelle page on se trouve
if (isset($_GET["start"]) && !empty($_GET["start"])) {
    $getStart = htmlspecialchars($_GET["start"]);
    $getStart = (int) ($_GET["start"]);
    // $currentPage = (int) strip_tags($_GET["start"]);
    $currentPage = (int) ($getStart);
} else {
    $currentPage = 1;
}

$nbArticles = $articles->total_number_articles();
//var_dump($nbArticles); //OK

// On détermine le nombre d articles par page 
// /!\ multiple de 2 pour éviter les bugs
$parPage = 10;
// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);

// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$get_page = $articles->get_by_page($premier, $parPage);
//var_dump($get_page);

if ($currentPage > $pages) {
    header('Location: Boutique.php');
}


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
    <link href="style/boutique.css" rel="stylesheet" type="text/css" />

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
</head>

<body>

    <nav class="container-pagination">
        <a href="Boutique.php?start=<?= $currentPage - 1 ?>" class="page-link"><</a>

                <?php for ($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <a href="Boutique.php?start=<?= $page ?>" class="page-link"><?= $page ?></a>

                <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <?php
                if ($currentPage != $pages and $currentPage < $pages) {
                    ?>
                    <a href="Boutique.php?start=<?= $currentPage + 1 ?>" class="page-link">></a>
                    <?php
                }
                ?>
    </nav>

    <section>

        <?php
        $count = 0;

        $nbArticlesPage = count($get_page);
        // Pour Chaque Article dans $get_page
        foreach ($get_page as $article) {
            // var_dump($article);
            //echo $nbArticlesPage,$count;
        
            //si on est au premier ou au à la moitié des articles, on crée une ligne d'article
            if ($count === 0 || $count === ($parPage/2)) {
                echo "<div class='AllArticleContainer'><br>";
            }
            ?>
            <!-- affiche Image Nom et Prix de l'article-->
            <div class="ArticleContainer"><a href="product.php?id=<?= $article["id"] ?>"><img class="ImgArticle"
                        src="<?php echo $article["image"] ?>" alt=""></a><br><br>
                <a class="ArticleInfo" href="product.php?id=<?= $article["id"] ?>"><?= $article["name"] ?></a><br><br>
                <a class="ArticleInfo" href="product.php?id=<?= $article["id"] ?>"><?= $article["price"] . "€" ?></a><br><br>
            </div>

            <?php
            if ($count === ($parPage/2)-1 || $count === $nbArticlesPage-1) {
                echo "</div>";
            } else if ($nbArticlesPage < ($parPage/2) and $nbArticlesPage - 1 === $count) { //si il y a moins de 5 article, et que nous somme au derniers article , on ferme la div
        
                echo "</div>";
            }
            $count++;
        }
        ?>

    </section>
    <nav class="container-pagination">
        <a href="Boutique.php?start=<?= $currentPage - 1 ?>" class="page-link"><</a>

                <?php for ($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <a href="Boutique.php?start=<?= $page ?>" class="page-link"><?= $page ?></a>

                <?php endfor ?>
                <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                <?php
                if ($currentPage != $pages and $currentPage < $pages) {
                    ?>
                    <a href="Boutique.php?start=<?= $currentPage + 1 ?>" class="page-link">></a>
                    <?php
                }
                ?>
    </nav>

    <?php
        include "includes/footer.php";
        ?>
    <body>
       