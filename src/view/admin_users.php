<?php


require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Config\DbConnection;


$sql = "SELECT * FROM user";
$select = DbConnection::getPdo()->prepare($sql);
if ($select->execute()) {
    $users = $select->fetchall(\PDO::FETCH_ASSOC);
}
echo '<table class="TBAffichage">';

foreach ($users as $user) {


    echo '<tr>';
    echo '<td>';
    echo 'Utilisateur : ' . $user['login'];
    echo '</td>';

    echo '<td>';
    echo 'Nom : ' . $user['lastname'];
    echo '</td>';

    echo '<td>';
    echo 'Prénom : ' . $user['firstname'];
    echo '</td>';

    echo '<td>';
    echo 'E-Mail : ' . $user['email'];
    echo '</td>';

    echo '<td>';
    if ($user['role_id'] == 1) {
        echo 'Role : <b>Admin</b>';
    } else if ($user['role_id'] == 2) {
        echo 'Role : <b>User</b>';
    }
    echo '</td>';

    echo '<td><button>Changer de Role</button></td>';
    echo '<td><button>Reset Password</button></td>';
    echo '<td><button class="Supprimer">Supprimer l\'user</button></td>';


}
echo "</table>";
?>