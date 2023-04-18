<?php

include 'public/includes/header.php';
// require 'class/Article.php';

// On determine sur quelle page on se trouve
if(isset($_GET['start']) && !empty($_GET['start'])){
    $getStart = htmlspecialchars($_GET['start']);
    $getStart = (int)($_GET['start']);
    // $currentPage = (int) strip_tags($_GET['start']);
    $currentPage = (int)($getStart);
}else{
    $currentPage = 1;
}

$nbArticles = $p->total_number_articles();
// var_dump($nbArticles); //OK

// On détermine le nombre d'articles par page
$parPage = 5;
// On calcule le nombre de pages total
$pages = ceil($nbArticles / $parPage);


// Calcul du 1er article de la page
$premier = ($currentPage * $parPage) - $parPage;

$get_page = $p->get_by_page($premier,$parPage);
// var_dump($get_page);

?>
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
                        <div><a href="product.php?id=<?= $article['id'] ?>"><img src="public/images/<?php echo $article['image'] ?>" alt=""></a></div>
                            <div><a href="product.php?id=<?= $article['id'] ?>"><?= $article['name'] ?></a></div>
                            <div><a href="product.php?id=<?= $article['id'] ?>"><?= $article['price'] ?></a></div>
                            
                      </div>
                    <?php
                    }
                    ?>
                
            
            <nav class="container-pagination">
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="product.php?start=<?= $currentPage - 1 ?>" class="page-link"><</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                            <a href="product.php?start=<?= $page ?>" class="page-link"><?= $page ?></a>
                        </li>
                    <?php endfor ?>
                        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="product.php?start=<?= $currentPage + 1 ?>" class="page-link">></a>
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</main>


<?php
include 'public/includes/footer.php';
?>