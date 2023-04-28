<?php


require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'autoload.php';

use App\Controller\User;

$Users = new User;
$users = $Users->getAllInfo();


?>
<table class="TBAffichage">
    <tr class="Desc">
        <td><b>Utilisateur : </b></td>
        <td><b>&ensp;Id :&ensp;</b></td>
        <td><b>Nom : </b></td>
        <td><b>Prénom : </b></td>
        <td><b>E-Mail : </b></td>
        <td><b>Role : </b></td>
        <td colspan="3"><b>Commandes </b></td>
    </tr>

    <?php
    foreach ($users as $user) {

        ?>
        <tr>
            <td>
                <?= $user['login']; ?>
            </td>

            <td>
                <?= $user['id']; ?>
            </td>

            <td>
                <?= $user['lastname']; ?>
            </td>

            <td>
                <?= $user['firstname']; ?>
            </td>

            <td>
                <?= $user['email']; ?>
            </td>

            <td>
                <?php
                if ($user['role_id'] == 1) {
                    echo '<b>Admin</b>';
                } else if ($user['role_id'] == 2) {
                    echo '<b>User</b>';
                } else if ($user['role_id'] == 3) {
                    echo '<b>Commercial</b>';
                }

                ?>
            </td>




            <td>
                <form action="" methode="post">
                    <input name="updateRoleID" value="<?= $user['id']; ?>" hidden />
                    <select name="updateRole">

                        <option value="2">Utilisateur</option>
                        <option value="3">Commercial</option>
                        <option value="1">Admin</option>

                    </select> &emsp;
                    <button type="submit" formmethod="post">Valider les Changements</button>

                </form>
            </td>

            <td>
                <?php    
            if ($user['role_id']===1){
            }else{
                ?> 
                <form method="post" onsubmit="return validateForm(<?=$user['role_id']?>);">
                    <input id="DeleteUserID" name="DeleteUserID" value="<?= $user['id']; ?>" hidden />
                    <button type="submit" formmethod="post" class="Supprimer">Supprimer l'user</button>
                </form>
                <?php
            }?>
            </td>

            <?php

    }
    echo "</table>";
    ?>