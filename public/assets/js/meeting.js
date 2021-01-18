var marseille = [43.3, 5.4];

var mymap = L.map('mapid').setView(marseille, 13);
L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
	maxZoom: 20,
}).addTo(mymap);

var marker = L.marker(marseille).addTo(mymap);

marker.bindPopup('<h4>Marseille</h4>');
