<?php

// require 'class/Article.php';
include_once('assets/include/header.php');

if(isset($_GET['categorie']))
{
    $categorie_id = $_GET['categorie'];
    $getIdCateg = $articles->articles_by_id_categ($categorie_id);

} else {
    $id_categorie = 0; 
}
// var_dump($getIdCateg);

?>

<main class="main-first">
    <section class="container">
        <div class="row">
                <h1>Liste catégorie d'article : </h1>
                <table id="customers">
                    <thead>
                        <th>N°Id</th>
                        <th>Titre</th>
                        <th>Date</th>
                        <th>Images</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach($getIdCateg as $categ => $key){
                            // var_dump($getIdCateg);
                        ?>
                            <tr>
                                <td><?= $key['nom'] ?></td>
                                <td><?= $key['article'] ?></td>
                                <td><?= date_format(date_create($key['date']), 'd/m/Y H:i:s') ?></td>
                                <td><img src="assets/images/articles/<?php echo $key['images'] ?>" alt=""></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
        </div>
    </section>
</main>

<?php
include 'assets/include/footer.php';
?>