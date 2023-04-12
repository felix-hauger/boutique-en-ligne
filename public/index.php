<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

// use App\Config\DbConnection;
use App\Model\User;
// use App\Model\AbstractModel;
// use App\Controller\Test\Test;

$user = new User();

var_dump($user);

// var_dump(DbConnection::getPdo());

// $m = new AbstractModel();

// var_dump(get_class($m));
// $test = new Test();
// var_dump($test->__toString())

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

    <title>Document</title>

</head>

<body>
    <?php require_once("includes/header.php") ?>



    <?php require_once("includes/footer.php") ?>
</body>
</html>