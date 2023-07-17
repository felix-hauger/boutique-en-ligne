let icon = document.getElementById("SearchIcon");
let bar = document.getElementById("SearchBar");
let hide = document.getElementById("SearchHide");

let popup = document.getElementById("popup");

let iconMobile = document.getElementById("SearchIconMobile");
let barMobile = document.getElementById("SearchBarMobile");
let hideMobile = document.getElementById("SearchHideMobile");

let r = document.querySelector(':root');

let Research = 0;
let Saison = 0;

const searchResult = document.querySelector("#SearchResult");

//affiche ou non la barre de recherche
function Recherche() {

    if (Research === 0) {

        iconMobile.style.display = "none";
        barMobile.style.display = "inline";
        hideMobile.style.display = "inline";

        icon.style.display = "none";
        bar.style.display = "inline";

        // Focus on search bar
        bar.focus();

        hide.style.display = "inline";

        searchResult.style.display = "block";

        Research = 1;
    }
    else if (Research === 1) {

        iconMobile.style.display = "inline";
        barMobile.style.display = "none";
        hideMobile.style.display = "none";

        icon.style.display = "inline";
        bar.style.display = "none";
        hide.style.display = "none";

        searchResult.style.display = "none";

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
function StopPropa(event) {
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
        r.style.setProperty('--bg-color', '#fffbf0');
        r.style.setProperty('--detail-color', '#528E74');
        r.style.setProperty('--hover-color', '#6DD0A5');
        r.style.setProperty('--lightbg-color', '#fffbf0');

    } else if (Saison === 1) {
        // Couleurs d'automne
        r.style.setProperty('--bg-color', '#FFF0E4');
        r.style.setProperty('--detail-color', '#B15F83');
        r.style.setProperty('--hover-color', '#db2376');
        r.style.setProperty('--lightbg-color', '#FFF0E4');
 
    } else if (Saison === 2) {
        // Couleurs d'hivert
        r.style.setProperty('--bg-color', '#F1FFFF');
        r.style.setProperty('--detail-color', '#5A48A3');
        r.style.setProperty('--hover-color', '#7861d4');
        r.style.setProperty('--lightbg-color', '#f8fffe');

    } else if (Saison === 3) {
        // Couleurs de printemps
        r.style.setProperty('--bg-color', '#e9fff2');
        r.style.setProperty('--detail-color', '#0a460a');
        r.style.setProperty('--hover-color', '#27c422');
        r.style.setProperty('--lightbg-color', '#f3fdf1');
    }

}

function ChangeSaison(){
    if (Saison === 0) {
        Saison++;
        SetSaisons();

    } else if (Saison === 1) {
        Saison++;
        SetSaisons();

    } else if (Saison === 2) {
        Saison++;
        SetSaisons();

    } else if (Saison === 3) {
        Saison = 0;
        SetSaisons();

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



// AUTOCOMPLETION

const searchBar = document.querySelector("#SearchBar");

searchBar.addEventListener("input", async (ev) => {

    const searchResult = document.querySelector("#SearchResult");

    // There must be at least 3 characters in search bar
    if (ev.target.value.length > 2) {

        // Empty existing result in html container
        searchResult.innerHTML = "";

        // Promise with search bar input value as get parameter
        let request = await fetch("search.php?query=" + ev.target.value);

        // Get response
        let response = await request.json();

        // Result string
        let htmlResult = "";

        // Add found products in html result
        for (const product of response) {
            htmlResult += 
            `<li class="search-result-item">
                <a href="product.php?id=${product.id}">

                    <img src="${product.image}">

                    <p class="product-name">${product.name}</p>

                    <p class="product-price">${product.price} €</p>

                </a>
            </li>`;
        }

        // Display found results
        searchResult.innerHTML = htmlResult;
    } else {
        searchResult.innerHTML = "";
    }

});

function changeColor() {
    document.getElementById("CartCount").style.color = 'orange';
    document.getElementById("CartCount").classList.remove('fadein');
}

function fadeColor() {
    document.getElementById("CartCount").style.color = 'var(--detail-color-)';
    document.getElementById("CartCount").classList.add('fadein');
}

function CartCount() {
    var myCookies = document.cookie;
    var count = 0;
    const cookies = myCookies.split('; ');

    cookies.forEach(element => {
        if (element.substring(0, 7) == "product") {
            count++;

            changeColor();

            setTimeout(fadeColor, 500);
        }
    });

    if (count != 0) {
        document.getElementById('CartCount').innerHTML = count
    }
}

async function loggedCartCount(){
    const request = await fetch('cart-count.php');

    const count = await request.text();

    changeColor();

    setTimeout(fadeColor, 500);

    if(count != 0){
        document.getElementById('CartCount').innerHTML=count
    }
}

CurrentSaison();
CartCount();
loggedCartCount();