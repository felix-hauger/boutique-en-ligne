function SupprimerCookie(cookie) {
    console.log(cookie)
    //Supprime le cookie en lui passant une date d'expiration passée
    document.cookie = cookie + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC'
    document.location.href = "cart.php";
}