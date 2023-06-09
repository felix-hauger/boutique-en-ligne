<?php

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

use App\Config\DbConnection;
use App\Controller\Product;
use App\Controller\User;

$Users = new User;


if (isset($_POST["updateRoleID"]) AND isset($_POST["updateRole"])) {
    $new_role_id = $_POST["updateRole"];
    $id = $_POST["updateRoleID"];
   
    $Users->updateRole($id, $new_role_id);
}
if (isset($_POST["DeleteUserID"])){
    $Users->delete($_POST["DeleteUserID"]);
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
    <link href="style/admin.css" rel="stylesheet" type="text/css" />

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
    <script defer src="scripts/admin.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <title>Pannel d'administration</title>

</head>

<body>
    <?php require_once("includes/header.php"); ?>

    <div id="ControlPanel">
        <h1>Panel d'administration</h1>

        <div id="CPbuttons">

            <button value="users">Users</button>
            <button value="articles">Articles</button>
            <button value="transactions">Transactions</button>
            <button value="categories">Catégories</button>
            <button value="tags">tags</button>

        </div>
    </div>

    
    <!-- Content fetched from admin_pages will be added in here :  -->
    <div id="Main">

    </div>

    <?php require_once("includes/footer.php"); ?>
</body>

</html>