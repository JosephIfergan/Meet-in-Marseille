var marseille = [43.3, 5.4];

var myMap = L.map('mapid').setView(marseille, 13);
L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
  maxZoom: 16,
  minZoom: 13,
}).addTo(myMap);

var marker = L.marker(marseille).addTo(myMap);

marker.bindPopup('<h4>Marseille</h4>');





var creerMeeting = $('.creer-meeting');
var ButtonClose = $('.button-close');
var lightbox = $('.lightbox');

  creerMeeting.on('click', function (event) {
    // IL FAUT AJOUTER LA CLASSE .active SUR LA LIGHTBOX POUR LA VOIR DANS L'ECRAN
	lightbox.addClass('active');
	console.log(creerMeeting);
  });

  // AVEC LA LIGHTBOX, IL FAUT POUVOIR LA CACHER QUAND ON CLIQUE DESSUS
  ButtonClose.on('click', function () {
    lightbox.removeClass('active');
  });
