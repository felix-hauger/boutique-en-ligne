<?php
//check if an article is selected, if not the user will be redirected to index

//session start apres l'autoload sinon bug lors de la connexion

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    header('Location: index.php');
    die();
} elseif ($_SESSION['user']->getRoleId() == 2) {
    http_response_code(403);
    header('Location: index.php');
    die();
}
// var_dump($_POST);

use App\Controller\Category;
use App\Controller\Product;
use App\Controller\Tag;

if (isset($_POST['product-submit'])) {
    try {
        $product_controller = new Product();

        $db_product_id = $product_controller->add();
    } catch (Exception $e) {
        $add_product_error = $e->getMessage();
    }
}

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
    <link href="style/add-product.css" rel="stylesheet" type="text/css" />

    <!-- FontAwesome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- GoogleFont-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script defer src="includes/header.js"></script>
    <script defer src="scripts/add-product.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <title>Ajouter un nouvel article | Saisons à la mode</title>

</head>

<body>
    <?php require_once("includes/header.php"); ?>

    <main>

        <form id="form" method="post" enctype="multipart/form-data">
            <h1>Ajouter un nouvel article</h1><br>

            <section id="UpperBox">
                <div id="ImageSelect">
                    <!-- IMAGE -->
                    <label for="image">Image de l'article: </label><br>
                    <input type="file" name="image" id="image"><br>
                    <img id="selectedImage" src="" alt="Preview image" />
                </div>

                <div id="ArticleInfo">
                    <!-- NAME -->
                    <input class="inputs" type="text" name="name" id="name" placeholder="Nom de l'article"><br>

                    <!-- DESCRIPTION -->
                    <textarea class="inputs" name="description" id="description" placeholder="Description de l'article"></textarea><br>

                    <!-- PRICE -->
                    <input class="inputs" type="number" name="price" id="price" placeholder="Prix"><br>

                    <!-- CATEGORY -->
                    <select name="category" id="category">
                        <option value="">--- Catégorie ---</option>

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

                </div>
            </section>

            <section id="LowerBox">
                <!-- TAGS -->
                <fieldset id="product-tags">
                    <legend>Tags</legend>

                    <?php
                    $tag_controller = new Tag();

                    // Get all ids & names using model & PDO::FETCH_CLASS
                    // which return an array of Category entities
                    $tags = $tag_controller->getAll();

                    // Display checkbox to select Tags, "tags[]" convert them into an array
                    foreach ($tags as $tag) {
                        echo '<label><input type="checkbox" name="tags[]" value="' . $tag->getId() . '">' . $tag->getName() . '</label>';
                    }
                    ?>
                </fieldset>

                <fieldset id="product-stock">
                    <legend>Définir les stocks disponibles</legend>

                    <label for="xs">XS</label>
                    <input type="number" name="stock[xs]" id="xs" placeholder="xs" value="0">

                    <label for="s">S</label>
                    <input type="number" name="stock[s]" id="s" placeholder="s" value="0">

                    <label for="m">M</label>
                    <input type="number" name="stock[m]" id="m" placeholder="m" value="0">

                    <label for="l">L</label>
                    <input type="number" name="stock[l]" id="l" placeholder="l" value="0">

                    <label for="xl">XL</label>
                    <input type="number" name="stock[xl]" id="xl" placeholder="xl" value="0">

                    <label for="xxl">XXL</label>
                    <input type="number" name="stock[xxl]" id="xxl" placeholder="xxl" value="0">
                </fieldset>

                <div id="BTbox">
                    <input class="BtSubmit" type="submit" name="product-submit" value="Ajouter l'article au magasin">
                </div>

                <div class="form-msg" id="add-product-form-msg">
                    <?php if (isset($add_product_error)): ?>
                        <span class="msg-error">
                            <?= $add_product_error ?>
                        </span>
                    <?php elseif(isset($db_product_id)): ?>
                        <span>
                            Produit ajouté avec succès
                        </span>
                    <?php endif ?>
                </div>
            </section>
        </form>

    </main>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>