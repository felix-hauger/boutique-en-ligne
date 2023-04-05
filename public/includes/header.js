var icon = document.getElementById("SearchIcon");
var bar = document.getElementById("SearchBar");
var hide = document.getElementById("SearchHide");
var r = document.querySelector(':root');

var Research = 0;
var Saison = 0;

function Recherche() {

    if (Research === 0) {

        icon.style.display = "none"
        bar.style.display = "inline";
        hide.style.display = "inline";
        Research = 1;
    }
    else if (Research === 1) {

        icon.style.display = "inline"
        bar.style.display = "none";
        hide.style.display = "none";
        Research = 0;
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