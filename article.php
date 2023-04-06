<?php
$title = 'Article';
include 'assets/include/header.php';
// require 'class/Article.php';
// var_dump($userinfos);
// var_dump($_SESSION);
 

    if(isset($_GET['id']) AND !empty($_GET['id']))
    {
        $get_id = htmlspecialchars($_GET['id']);
        $get_id = (int)($_GET['id']);
        $single_art = $articles->single_article($get_id);
        // var_dump($single_art);

        $countArt  = $articles->count_singl_art($get_id);
        // var_dump($countArt);
        $countArt = (int)$countArt;
        // var_dump($countArt);

        //vérifie si l'article existe bien
        if($countArt == 1)
        {       
            $titre =  $single_art['article'];
            $image =  $single_art['images'];
            $prix =  $single_art['price'];
        } else {
            die("Cet article n'existe pas !");
        }
    } else {
        header('Location : index.php');
    }

$result_art = $articles->single_article($get_id);
// var_dump($result_art);

$result_art_user = $articles->commentInf($get_id);
// var_dump($result_art);

$result_art_cat = $articles->commentCount($get_id);
// var_dump($result_art);

$result_com = $articles->commentUser($get_id);
// var_dump($result_com);

if (isset($_POST['btn-com'])) {
    if (!empty($_POST['commentaire'])) {
        $commentaire = htmlspecialchars($_POST['commentaire']);
        $insertcom = $articles->insertComment($commentaire, $get_id, $_SESSION['user']['id_utilisateurs']);

        $message = 'Votre commentaire a bien été posté';

        header("Refresh:0");
    } else {
        $commentaire = 'Veuillez remplir tous les champs';
    }
} else {
    $noisset = 'Créer un commentaire';
}


$error = "";

?>
<main class="main-first">
    <section>
        <h2><?= $titre ?></h2>
        <img src="assets/images/articles/<?= $image ?>" alt="">
        <p><?= $prix ?></p>

    </section>
    <div id="article">
            <!-- <span>
                <h1 id="h1_art">Article</h1>
                <p class="p_article">Le: <?= $result_art['date'] ?> </p>
                <p class="p_article">Catégorie: <?= $result_art_cat['nom'] ?> </p>
                <p class="article"><?= $result_art['article'] ?></p>
            </span> -->
        </div>
        <h2 id="com-article">Commentaires liés à l'article</h2>
        <div class="cadre-table-scroll" id="style-1">
            <table id="table_art">
                <?php
                foreach ($result_com as $com => $key) :
                ?>
                <tr>
                    <td><span> Posté par : <?= $key['login']; ?></span>
                    </td>

                    <td><span>le</span>
                        <em><?=  date_format(date_create($key['date']), 'd/m/Y H:i:s'); ?></em>
                    </td>

                    <td> - <?= $key['commentaire']; ?></td>
                    <?php ?>
                </tr>
                <?php
                endforeach;
                ?>
            </table>
        </div>

        <article>
            <div class="contener-flex">
                <h1>Ecrire un commentaire</h1>
                <?php if (isset($_SESSION['user']['id_utilisateurs'])) { ?>
                    <form action="" method="POST">
                        <div class="login-container">
                            <textarea name="commentaire" placeholder="Contenu du commentaire"></textarea>
                        </div>
                        <div class="login-container">
                            <button class="btn-submit" type="submit" name="btn-com">Envoyer le commentaire</button>
                        </div>
                    </form>
                    <?php if (isset($message)) { ?>
                        <p style="color: green;"><?php echo $message; ?></p>
                    <?php } elseif (isset($commentaire)) { ?>
                        <p style="color: red;"><?php echo $commentaire; ?></p>
                    <?php } elseif (isset($noisset)) { ?>
                        <p style="color: rgb(203, 188, 178);"><?php echo $noisset; ?></p>
                    <?php } ?>
                <?php } else { ?>
                    <div class="nocolink">
                        <p>Connectez-Vous en cliquant <a href="./connexion.php">ici</a>... </p>
                    </div>
                <?php } ?>

            </div>
        </article>
</main>

<?php
include 'assets/include/footer.php';
?>