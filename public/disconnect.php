<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';
use App\Controller\User;

session_start();

$User = new User;
$User -> logout();

header("location:".$_SESSION['url']);
?>