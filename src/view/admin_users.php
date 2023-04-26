<?php


require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\User;

$Users = new User;
$users=$Users->getAllInfo();


echo '<table class="TBAffichage">';
echo '<tr class="Desc"><td><b>Utilisateur : </b></td><td><b>&ensp;Id :&ensp;</b></td><td><b>Nom : </b></td><td><b>Prénom : </b></td><td><b>E-Mail : </b></td><td><b>Role : </b></td><td colspan="3"><b>Commandes </b></td></tr>';
foreach ($users as $user) {


    echo '<tr>';
    echo '<td>';
    echo $user['login'];
    echo '</td>';

    echo '<td>';
    echo $user['id'];
    echo '</td>';

    echo '<td>';
    echo $user['lastname'];
    echo '</td>';

    echo '<td>';
    echo $user['firstname'];
    echo '</td>';

    echo '<td>';
    echo $user['email'];
    echo '</td>';

    echo '<td>';
    if ($user['role_id'] == 1) {
        echo '<b>Admin</b>';
    } else if ($user['role_id'] == 2) {
        echo '<b>User</b>';
    }
    echo '</td>';

    echo '<td><button>Changer de Role</button></td>';
    echo '<td><button>Reset Password</button></td>';
    echo '<td><button class="Supprimer">Supprimer l\'user</button></td>';


}
echo "</table>";
?>