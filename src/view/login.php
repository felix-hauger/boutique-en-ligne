<?php

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

use App\Controller\User as UserController;

$userController = new UserController();

$login = 'toto';
$password = 'toto';

try {
    $userController->connect($login, $password);
} catch (Exception $e) {
    echo $e->getMessage();
}

var_dump($_SESSION);