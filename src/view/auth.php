<div id="popup-Content" onclick="StopPropa(event)">
    <i id="close-popup" class="fa-sharp fa-solid fa-xmark fa-2xl" onclick="HideUser()"></i><br>

    <form id="login-form" method="post">
        <input type="text" name="login" id="login" placeholder="Login"><br>
        <input type="password" name="password" id="password" placeholder="Mot de passe"><br>
        <input type="submit" name="submit-login" value="Connexion">
    </form>
    
    <form id="register-form" method="post" style="display: none;">
        <input type="text" name="login" id="login" placeholder="Login"><br>
        <input type="password" name="password" id="password" placeholder="Mot de passe"><br>
        <input type="password" name="confirmation" id="confirmation" placeholder="Confirmation"><br>
        <input type="email" name="email" id="email" placeholder="Email"><br>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom"><br>
        <input type="text" name="lastname" id="lastname" placeholder="Nom de famille"><br>
        <input type="submit" name="submit-register" value="Inscription">
    </form>

    <hr>

    <button onclick="toggleAuth(event)">Pas de compte ?</button>
</div>

