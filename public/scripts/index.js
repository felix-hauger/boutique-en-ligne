const swiperPopulaire = document.getElementById("swiperPopulaire")
const swiperRecent = document.getElementById("swiperRecent")
const swiperSaison = document.getElementById("swiperSaison")
var w = window.innerWidth;


if (w <= 800) {
    swiperPopulaire.setAttribute("slides-per-view", "3");
    swiperRecent.setAttribute("slides-per-view", "3");
    swiperSaison.setAttribute("slides-per-view", "3");
}