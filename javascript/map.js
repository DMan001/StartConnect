// crea mappa
$(function() {
  $('#map').vectorMap({
    map: 'it_mill',
    backgroundColor: '#264653',
    size: {
      height: 300,
      width: 00
    },
    series: {
      regions: [{
        values: {
        },
        attribute: 'fill'
      }]
    }
  });
});

// Fetch data every 0.3 seconds
setInterval(function() {
  $.ajax({
    url: "./php/updateEvent.php",
    type: "GET",
    dataType: "json",
    success: function(dati) {
      aggiungimarker(dati);
    },
  });
}, 300); 

// aggiorna posizione dei marker sulla mappa
function aggiungimarker(dati) {
  var map = $('#map').vectorMap('get', 'mapObject');
  
  map.removeAllMarkers();
  for (var id = 0; id < dati.length; id++) {
    var posizione = dati[id];
    
    var marker = {
      name: posizione.nome,
      descrizione: posizione.descrizione,
      latLng: [posizione.latitudine, posizione.longitudine],
      style: {
        fill: 'yellow',
        stroke: 'black',
        'stroke-width': 2,
        r: 6
      },
    };

  map.addMarker(id, marker);
  
  var markerElement = $('#map').find('.jvectormap-marker[data-index="' + id + '"]');   // aggiunge attributi ai marker
  $(markerElement).data('style', marker.style);
  $(markerElement).data('name', marker.name);
  $(markerElement).data('descrizione', marker.descrizione);   
  
  $(markerElement).click(function() {
    var descrizione= $(this).data('descrizione');
    var name = $(this).data('name');
    $('#text-content').html(descrizione);
    $('#nome').html(name);
  });
  }
}






