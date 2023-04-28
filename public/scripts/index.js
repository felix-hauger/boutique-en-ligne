const swiperPopulaire = document.getElementById("swiperPopulaire")
const swiperRecent = document.getElementById("swiperRecent")
const swiperSaison = document.getElementById("swiperSaison")
let w = window.innerWidth;


if (w <= 800) {
    swiperPopulaire.setAttribute("slides-per-view", "3");
    swiperRecent.setAttribute("slides-per-view", "3");
    swiperSaison.setAttribute("slides-per-view", "3");

    swiperPopulaire.setAttribute("navigation", "false");
    swiperRecent.setAttribute("navigation", "false");
    swiperSaison.setAttribute("navigation", "false");
}

