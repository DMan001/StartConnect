$(function() {
  $('#map').vectorMap({
    map: 'it_mill',
    series: {
      regions: [{
        values: {
        },
        attribute: 'fill'
      }]
    }
  });
});
setInterval(function() {
  $.ajax({
    url: "./php/updateEvent.php",
    type: "GET",
    dataType: "json",
    success: function(dati) {
      updateMap(dati);
    },
  });
}, 300); // Fetch data every 0.3 seconds

function updateMap(dati) {
  var map = $('#map').vectorMap('get', 'mapObject');
  map.removeAllMarkers();
  for (var i = 0; i < dati.length; i++) {
    var location = dati[i];
    var marker = {
      name: location.nome,
      descrizione: location.descrizione,
      latLng: [location.latitudine, location.longitudine],
      style: {
        fill: 'yellow',
        stroke: 'black',
        'stroke-width': 2,
        r: 6
      },
    };

  map.addMarker(i, marker);
  var markerElement = $('#map').find('.jvectormap-marker[data-index="' + i + '"]');
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






