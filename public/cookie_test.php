<?php
// setcookie('product[0]', '10' , time()+3600);
// setcookie('product[1]', '2' , time()+3600);
// setcookie('product[2]', 'xl' , time()+3600);

$id = 15;
$size = 'l';
$product = 'product' . '_' . $id . '_' . $size;
var_dump($product);

setcookie($product, '3' , time()+3600);
// setcookie($product . '[size]', 'l' , time()+3600);



// print_r( $_COOKIE );
echo '<br>';
var_dump($_COOKIE);
?>

