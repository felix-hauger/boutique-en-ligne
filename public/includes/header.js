var icon = document.getElementById("SearchIcon");
var bar = document.getElementById("SearchBar");
var hide = document.getElementById("SearchHide");

var popup = document.getElementById("popup");

var iconMobile = document.getElementById("SearchIconMobile");
var barMobile = document.getElementById("SearchBarMobile");
var hideMobile = document.getElementById("SearchHideMobile");

var r = document.querySelector(':root');

var Research = 0;
var Saison = 0;

//affiche ou non la barre de recherche
function Recherche() {

    if (Research === 0) {

        iconMobile.style.display = "none"
        barMobile.style.display = "inline";
        hideMobile.style.display = "inline";

        icon.style.display = "none"
        bar.style.display = "inline";
        hide.style.display = "inline";

        Research = 1;
    }
    else if (Research === 1) {

        iconMobile.style.display = "inline"
        barMobile.style.display = "none";
        hideMobile.style.display = "none";

        icon.style.display = "inline"
        bar.style.display = "none";
        hide.style.display = "none";

        Research = 0;
    }


}
//affiche la popup de connexion
function ShowUser() {
    popup.style.display = "inline"
}
//cache la popup de connexion
function HideUser() {

    popup.style.display = "none"
}
//empeche la propagation d'une action d'un parent a ses enfants
function StopPropa(event){
    event.stopPropagation();
}

// toggle display between login form & register form
function toggleAuth(event) {
    let loginForm = document.getElementById('login-form'),
        registerForm = document.getElementById('register-form');

    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        event.target.innerHTML = "Pas de compte ?";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        event.target.innerHTML = "Déjà inscrit ?";
    }
}

// change les variables du css en fonction de la saison
//permet de changer manuellement de saison pour démonstration
function SetSaisons() {

    if (Saison === 0) {
        // Couleurs d'été
        r.style.setProperty('--bg-color', '#FEF9E8');
        r.style.setProperty('--detail-color', '#E76F00');
        r.style.setProperty('--hover-color', '#ff9838');
        Saison++;
    } else if (Saison === 1) {
        // Couleurs d'automne
        r.style.setProperty('--bg-color', '#FFEBCD');
        r.style.setProperty('--detail-color', '#AA1155');
        r.style.setProperty('--hover-color', '#db2376');
        Saison++;
    } else if (Saison === 2) {
        // Couleurs d'hivert
        r.style.setProperty('--bg-color', '#F1FFFF');
        r.style.setProperty('--detail-color', '#5A48A3');
        r.style.setProperty('--hover-color', '#7861d4');
        Saison++;
    } else if (Saison === 3) {
        // Couleurs de printemps
        r.style.setProperty('--bg-color', '#c0ffd8');
        r.style.setProperty('--detail-color', '#0a460a');
        r.style.setProperty('--hover-color', '#27c422');
        Saison = 0;
    }

}

// Change la variable saison en accord avec la saison actuelle 
function CurrentSaison() {
    //printemps : 1er mars au 31 mai
    //été : 1er juin au 31 août
    //automne : 1er septembre au 30 novembre 
    //hiver : 1er décembre au 28 (ou 29) février 

    var dateObj = new Date();
    var month = dateObj.getUTCMonth() + 1;
    var day = dateObj.getUTCDate();

    if ((day >= 1 && month >= 3) && (day <= 31 && month <= 5)) {
        Saison = 3;
        SetSaisons()
    } else if ((day >= 1 && month >= 6) && (day <= 31 && month <= 8)) {
        Saison = 0;
        SetSaisons()
    } else if ((day >= 1 && month >= 9) && (day <= 30 && month <= 11)) {
        Saison = 1;
        SetSaisons()
    } else if ((day >= 1 && month >= 12) || (day <= 29 && month <= 2)) {
        Saison = 2;
        SetSaisons()
    }
}

CurrentSaison()