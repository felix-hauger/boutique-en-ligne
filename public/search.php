<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\Product;

$product = new Product();

echo $product->search(htmlspecialchars(trim($_GET['query'])), ENT_QUOTES);