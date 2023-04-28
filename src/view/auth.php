<?php

use App\Controller\User as UserController;

if (isset($_POST['submit-login'])) {

    $userController = new UserController();

  
    try {
        $userController->connect(
            $_POST['login'], 
            $_POST['password']
        );
    } catch (Exception $e) {
        $login_error = $e->getMessage();
    }
} elseif (isset($_POST['submit-register'])) {
    
    $userController = new UserController();


    try {
        $userController->register(
            $_POST['login'], 
            $_POST['password'], 
            $_POST['confirmation'], 
            $_POST['email'], 
            $_POST['username'], 
            $_POST['firstname'], 
            $_POST['lastname']
        );
    } catch (Exception $e) {
        $register_error = 'Erreur lors de l\'inscription : ' . $e->getMessage();
    }
    
}

?>

<div id="popup-Content" onclick="StopPropa(event)">
    <i id="close-popup" class="fa-sharp fa-solid fa-xmark fa-2xl" onclick="HideUser()"></i><br>

    <form id="login-form" method="post">
        <label class="LabelForm" for="connect-login">Connexion</label><br>
        <input type="text" name="login" id="connect-login" placeholder="Login"><br>
        <input type="password" name="password" id="connect-password" placeholder="Mot de passe"><br>
        <input class="BtSubmit" type="submit" name="submit-login" value="Connexion">
        <div class="form-msg" id="login-form-msg">
            <?php if (isset($login_error)): ?>
                <span class="msg-error"><?= $login_error ?></span>
            <?php endif ?>
        </div>
    </form>

    <form id="register-form" method="post" style="display: none;">
        <label class="LabelForm" for="register-login">Inscription</label><br>
        <input type="text" name="login" id="register-login" placeholder="Login"><br>
        <input type="password" name="password" id="register-password" placeholder="Mot de passe"><br>
        <input type="password" name="confirmation" id="register-confirmation" placeholder="Confirmation"><br>
        <input type="email" name="email" id="register-email" placeholder="Email"><br>
        <input type="text" name="username" id="register-username" placeholder="Nom d'utilisateur"><br>
        <input type="text" name="firstname" id="register-firstname" placeholder="Prénom"><br>
        <input type="text" name="lastname" id="register-lastname" placeholder="Nom de famille"><br>
        <input class="BtSubmit" type="submit" name="submit-register" value="Inscription">
        <div class="form-msg" id="register-form-msg">
            <?php if (isset($register_error)): ?>
                <span class="msg-error"><?= $register_error ?></span>
            <?php endif ?>
        </div>
    </form>

    <hr>

    <button id="BtToggleConnec" onclick="toggleAuth(event)">Pas de compte ?</button>
</div>