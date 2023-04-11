<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;
// use App\Controller\Test\Test;


var_dump(DbConnection::getDb());
// $test = new Test();
// var_dump($test->__toString())

?><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php require_once("includes/header.php") ?>



    <?php require_once("includes/footer.php") ?>
</body>
</html>