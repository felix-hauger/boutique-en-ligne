<?php

require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\User as UserController;

$userController = new UserController();

$login = 'titi';
$password = 'toto';
$password_confirm = 'titi';
$email = 'toto@toto.fr';
$username = 'toto';
$firstname = 'toto';
$lastname = 'caca';

try {
    $userController->register($login, $password, $password_confirm, $email, $username, $firstname, $lastname);
} catch (Exception $e) {
    echo $e->getMessage();
}
