console.log('MON CODE JS EST CHARGE');

// SLIDER BACKGROUND PAGE ACCUEIL
let images = [
    'assets/img/slideshow1.jpg',        // INDICE 0
    'assets/img/slideshow2.jpg',        // INDICE 1
    'assets/img/slideshow3.jpg',        // INDICE 2
    'assets/img/slideshow4.jpg',        // INDICE 3
    'assets/img/slideshow5.jpg',        // INDICE 4
    'assets/img/slideshow6.jpg'         // INDICE 5
];
let slideshow = document.querySelector('.slideshow');
srcSuivant = images[compteur];
var compteur = 0;

    setInterval(function() {
        compteur = (compteur +1) % images.length;   // ASTUCE QUI VA FAIRE BOUCLER A ZERO SI ON DEBORDE
        srcSuivant = images[compteur];
        slideshow.style.backgroundImage = "url('" + srcSuivant + "')";
    },
    3000);  // 3s

    var scrollTop = $(".scrollTop");

// CHANGER LE HEADER POUR MOBILE
let headerPc= document.querySelector('.header-pc');
let headerMobile= document.querySelector('.header-mobile');
  if (window.matchMedia("(max-width: 642px)").matches){ //642px
      headerPc.classList.remove("d-flex");
      headerPc.classList.add("d-none");
      headerMobile.classList.remove("d-none");
}

// CHANGER SYMBOLE MENU HAMBURGER
let buttonHamburger = document.querySelector('.navbar-toggle');
let iconeHamburger1 = document.querySelector('.fa-bars');
let iconeHamburger2 = document.querySelector('.fa-times-circle');

buttonHamburger.addEventListener('click', function () {
    iconeHamburger1.classList.toggle("d-none");
    iconeHamburger2.classList.toggle("d-none");
});

// FAIRE APPARAITRE DOUCEMENT LE TITRE PAGE INSCRIPTION
var titreInscription = document.querySelector('.opacity-0');

titreInscription.classList.remove('opacity-0');

// REMONTER EN HAUT DE PAGE AVEC FLECHE PAGE ACCUEIL (EN JQUERY)
$(scrollTop).click(function() {
  $('html, body').animate({
    scrollTop: 0
  }, 1400);
  return false;
});


