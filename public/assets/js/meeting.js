
// MAP LEAFLET

var marseille = [43.3, 5.4];

var tabMarkers = [
  [43.26, 5.39], [43.26, 5.40], [43.24, 5.37]
];

var myMap = L.map('mapid').setView(marseille, 12);
L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
  maxZoom: 16,
  minZoom: 11,
}).addTo(myMap);

var marker = L.marker(marseille).addTo(myMap);
marker.bindPopup('<h4>Marseille</h4>');

for (let m = 0 ; m < tabMarkers.length ; m++) {

  let marker = L.marker(tabMarkers[m]).addTo(myMap);
  console.log(marker);
}





