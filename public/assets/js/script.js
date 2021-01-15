console.log('MON CODE JS EST CHARGE');

let images = [
    'assets/img/slideshow1.jpg',        // INDICE 0
    'assets/img/slideshow2.jpg',        // INDICE 1
    'assets/img/slideshow3.jpg',        // INDICE 2
    'assets/img/slideshow4.jpg',        // INDICE 2
    'assets/img/slideshow5.jpg',         // INDICE 2
    'assets/img/slideshow6.jpg'         // INDICE 2
];
let slideshow = document.querySelector('.slideshow');
srcSuivant = images[compteur];
var compteur = 0;

    setInterval(function() {
        compteur = (compteur +1) % images.length;   // ASTUCE QUI VA FAIRE BOUCLER A ZERO SI ON DEBORDE
        srcSuivant = images[compteur];
        slideshow.style.backgroundImage = "url('" + srcSuivant + "')";

    },
    2000);  // 2s

    var scrollTop = $(".scrollTop");

$(scrollTop).click(function() {
  $('html, body').animate({
    scrollTop: 0
  }, 1400);
  return false;
});