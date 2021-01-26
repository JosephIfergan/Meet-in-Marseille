
// MAP LEAFLET

var marseille = [43.3, 5.4];

/*var tabMarkers = [
  [43.26, 5.39], [43.26, 5.40], [43.24, 5.37]
]; */

var myMap = L.map('mapid').setView(marseille, 13);
L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
  maxZoom: 15,
  minZoom: 12,
}).addTo(myMap);

var marker = L.marker(marseille).addTo(myMap);
marker.bindPopup('<h4>Marseille</h4>');

for (let m = 0 ; m < tabMarkers.length ; m++) {

  let marker = L.marker(tabMarkers[m]).addTo(myMap);
  marker.bindPopup('popup' + m);
  console.log(marker);
}


// INSCRIPTION A UN MEETING ET OUVRIR LIGHTBOX VALIDER INSCRIPTION MEETING
var lightboxValiderInscription = $('#valider-inscription');

function InscriptionMeeting(event) 
{   
    let id = event.target.getAttribute('data-id');
    lightboxValiderInscription.addClass('active');

    let champId = document.querySelector('#inscrits_id_meeting');

    console.log(champId);
    champId.value = id;

    let boutonSubmit = document.querySelector('form[name=inscrits]');
    boutonSubmit.click();
}   
// FERMER LIGHTBOX INSCRIPTION A UN MEETING
var fermerLightboxInscription = document.querySelector('.fa-times-circle');
console.log(fermerLightboxInscription);

fermerLightboxInscription.addEventListener('click', function () {
  lightboxValiderInscription.removeClass('active');
  console.log(fermerLightboxInscription);
});




