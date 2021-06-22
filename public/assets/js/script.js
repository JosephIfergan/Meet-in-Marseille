  // SLIDER BACKGROUND PAGE ACCUEIL
  var current = 0,
  slides = document.getElementsByClassName("slider");

  setInterval(function() {
  for (var i = 0; i < slides.length; i++){
      slides[i].style.opacity = 0;
    }
    current = (current != slides.length - 1) ? current + 1 : 0;
    slides[current].style.opacity = 1;
  } ,5000);
  
  // SLIDER BACKGROUND PAGE ACCUEIL
// let images = [
//   'assets/img/slideshow1.jpg',        // INDICE 0
//   'assets/img/slideshow2.jpg',        // INDICE 1
//   'assets/img/slideshow3.jpg',        // INDICE 2
//   'assets/img/slideshow4.jpg',        // INDICE 3
//   'assets/img/slideshow5.jpg',        // INDICE 4
//   'assets/img/slideshow6.jpg'         // INDICE 5
// ];
// let slideshow = document.querySelector('.slideshow');
// srcSuivant = images[compteur];
// var compteur = 0;

//   setInterval(function() {
//       compteur = (compteur +1) % images.length;   // ASTUCE QUI VA FAIRE BOUCLER A ZERO SI ON DEBORDE
//       srcSuivant = images[compteur];
//       slideshow.style.backgroundImage = "url('" + srcSuivant + "')";
//   },
//   3000);  // 3s

// ANIMATION ETAPES 
AOS.init({
duration: 1200,
})

// CHANGER VALEUR DATA-AOS POUR MOBILE
var datas = document.getElementsByClassName('bloc');
for (let data of datas) {
    if (window.matchMedia("(max-width: 560px)").matches){
      var fadeLeft = data.getAttribute("data-aos");
      if( fadeLeft == "fade-left"){
      dataAos = "fade-right";
      data.setAttribute("data-aos", dataAos);
      }
    };
}

// AFFICHER ET FERMER LIGHTBOX AFFICHER PARTICIPANTS (SECTION PROFIL)
var bouttonAfficherParticipant = $('#voirParticipant');
var lightboxAfficherParticipant = $('.afficher-participant');
var fermerLightboxAfficherParticiper = $('.fa-times');

$(bouttonAfficherParticipant).click(function() {
lightboxAfficherParticipant.addClass('active');

});

$(fermerLightboxAfficherParticiper).click(function() {
lightboxAfficherParticipant.removeClass('active');
});

// DESINSCRIPTION A UN MEETING ET OUVRIR LIGHTBOX SE DESINSCRIRE A UN MEETING
var lightboxValiderDesinscription = $('#valider-desinscription');

function DesinscriptionMeeting(event) 
{   
  let id = event.target.getAttribute('data-id');
  lightboxValiderDesinscription.addClass('active');

  let champId = document.querySelector('#inscrits_id_meeting');

  console.log(champId);
  champId.value = id;

  let boutonSubmit = document.querySelector('form[name=inscrits]');
  boutonSubmit.click();
}   
// FERMER LIGHTBOX INSCRIPTION A UN MEETING
var fermerLightboxDesinscription = document.querySelector('.fa-times-circle');

fermerLightboxDesinscription.addEventListener('click', function () {
lightboxValiderDesinscription.removeClass('active');
});










