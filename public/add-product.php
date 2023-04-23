<?php
//check if an article is selected, if not the user will be redirected to index

//session start apres l'autoload sinon bug lors de la connexion

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    header('Location: index.php');
    die();
} elseif ($_SESSION['user']->getRoleId() !== 1) {
    http_response_code(403);
    header('Location: index.php');
    die();
}


use App\Controller\Category;
use App\Controller\Product;
use App\Controller\Tag;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- MetaData -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link href="includes/header.css" rel="stylesheet" type="text/css" />
    <link href="includes/footer.css" rel="stylesheet" type="text/css" />
    <link href="style/product.css" rel="stylesheet" type="text/css" />

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script async src="scripts/product.js"></script>

    <title>Ajouter un nouvel article | Saisons à la mode</title>

</head>

<body>
    <?php require_once("includes/header.php"); ?>

    <main>

        <form id="form" method="post" enctype="multipart/form-data">
            <label class="LabelForm" for="name">Ajouter un nouvel article</label><br>

            <input type="text" name="name" id="name" placeholder="Nom de l'article"><br>

            <textarea name="description" id="description" placeholder="Description de l'article"></textarea><br>

            <input type="number" name="price" id="price" placeholder="Prix"><br>

            <label for="image">Image de l'article
                <input type="file" name="image" id="image"><br>
            </label><br />

            <select name="category" id="category">
                <option>--- Catégorie ---</option>

                <?php
                $category_controller = new Category();

                // Get all ids & names using model & PDO::FETCH_CLASS
                // which return an array of Category entities
                $categories = $category_controller->getAll();

                // Display category names for user & use id to set category to product
                foreach ($categories as $category) {
                    echo '<option value="' . $category->getId() . '">' . $category->getName() . '</option>';
                }
                ?>
            </select><br />

            <fieldset id="product-tags">
                <legend>Tags</legend>
                <select name="category" id="category">

                <option>--- Catégorie ---</option>

                <?php
                $tag_controller = new Tag();

                $tags = $tag_controller->getAll();

                foreach ($tags as $tag) {
                    echo '<option value="' . $tag->getId() . '">' . $tag->getName() . '</option>';
                }
                ?>

                </select>
                <button id="add-tag">Ajouter Tag</button>
            </fieldset>

            <fieldset id="product-stock">
                <legend>Définir les stocks disponibles</legend>
                <input type="number" name="xs" id="xs" placeholder="xs">
                <input type="number" name="s" id="s" placeholder="s">
                <input type="number" name="m" id="m" placeholder="m">
                <input type="number" name="l" id="l" placeholder="l">
                <input type="number" name="xl" id="xl" placeholder="xl">
                <input type="number" name="xxl" id="xxl" placeholder="xxl">
            </fieldset>



            <input class="BtSubmit" type="submit" name="product-submit" value="Ajouter l'article au magasin">
            
            <div class="form-msg" id="add-product-form-msg">
                <?php if (isset($add_product_error)): ?>
                    <span class="msg-error"><?= $add_product_error ?></span>
                <?php endif ?>
            </div>
        </form>

    </main>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>