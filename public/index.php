<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();
// session_destroy();

var_dump($_SESSION);

// use App\Config\DbConnection;
// use App\Model\User as UserModel;
// use App\Controller\User as UserController;
// use App\Entity\User as UserEntity;
// use App\Model\AbstractModel;
// use App\Controller\Test\Test;

// $userModel = new UserModel();
// $userController = new UserController();
// $userEntity = new UserEntity();


// $m = new AbstractModel();

// var_dump(get_class($m));
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