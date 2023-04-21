<?php 


require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;


$sql = "SELECT * FROM user";
$select = DbConnection::getPdo()->prepare($sql);
if ($select->execute()) {
    $users = $select->fetchall(\PDO::FETCH_ASSOC);
}


foreach ($users as $user){

    echo '<div class="user">';
    
    echo 'Utilisateur : <input id="login" name="login" placeholder="'.$user['login'].'"></input>';
    echo 'Nom : <input id="lastname" name="lastname" placeholder="'.$user['lastname'].'"></input>';
    echo 'Nom : <input id="firstname" name="firstname" placeholder="'.$user['firstname'].'"></input>';
    echo 'E-Mail : <input id="mail" name="mail" placeholder="'.$user['email'].'"></input>';
    if($user['role_id']==1){
        echo 'Role : Admin';
    }else if ($user['role_id']==2){
        echo 'Role : User';
    }
   
    echo "</div>";
}
?>

