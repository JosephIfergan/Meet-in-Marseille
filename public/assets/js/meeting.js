
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
  let popup = document.querySelector('#meeting_titre').value; 
  let marker = L.marker(tabMarkers[m]).addTo(myMap);
  marker.bindPopup(popup);
  console.log(marker);
  console.log(popup);
  
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




      //  
      // Call Geocode
      // geocode();
  
      // Get location form
      // var locationForm = document.getElementById('location-form');
      var locationForm = document.querySelector('form[name=meeting]');
  
      // Listen for submiot
      locationForm.addEventListener('submit', geocode);
  
      function geocode(e){
        // Prevent actual submit
        e.preventDefault();
  
        // var location = document.getElementById('location-input').value;
        var location = document.getElementById('meeting_adresse').value;
  
        axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
          params:{
            address:location,
            key:'AIzaSyDbAOZnyKZgAwmOYH2FlRlALkgNnfTtXJ8'
          }
        })
        .then(function(response){
          // Log full response
          console.log(response);
  
          // Formatted Address
          var formattedAddress = response.data.results[0].formatted_address;
          var formattedAddressOutput = `
            <ul class="list-group">
              <li class="list-group-item">${formattedAddress}</li>
            </ul>
          `;
  
          // Address Components
          var addressComponents = response.data.results[0].address_components;
          var addressComponentsOutput = '<ul class="list-group">';
          for(var i = 0;i < addressComponents.length;i++){
            addressComponentsOutput += `
              <li class="list-group-item"><strong>${addressComponents[i].types[0]}</strong>: ${addressComponents[i].long_name}</li>
            `;
          }
          addressComponentsOutput += '</ul>';
  
          // Geometry
          var lat = response.data.results[0].geometry.location.lat;
          var lng = response.data.results[0].geometry.location.lng;

          meeting_latitude.value = lat;
          meeting_longitude.value = lng;
          
          var geometryOutput = `
            <ul class="list-group">
              <li class="list-group-item"><strong>Latitude</strong>: ${lat}</li>
              <li class="list-group-item"><strong>Longitude</strong>: ${lng}</li>
            </ul>
          `;
  
          // Output to app
          document.getElementById('formatted-address').innerHTML = formattedAddressOutput;
          document.getElementById('address-components').innerHTML = addressComponentsOutput;
          document.getElementById('geometry').innerHTML = geometryOutput;

          e.target.submit();
        })
        .catch(function(error){
          console.log(error);
        });
      }
