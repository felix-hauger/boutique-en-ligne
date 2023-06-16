<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    die();
}

use App\Controller\User;

$user_controller = new User();

echo $user_controller->countCartItems($_SESSION['user']->getId());