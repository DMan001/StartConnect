// crea mappa
$(function() {
  $('#map').vectorMap({
    map: 'it_mill',
    backgroundColor: "#17b2ff",
    zoomMax:100,
    series: {
      regions: [{
        values: {
        },
        attribute: 'fill'
      }]
    }
  });
});

// carica i dati dal database
$.ajax({
    url: "./php/updateEvent.php",
    type: "GET",
    dataType: "json",
    success: function(dati) {
      aggiungimarker(dati);
    },
  });

// array globale per mantenere markers
var markers = [];
var markelements = [];

// variabile globale per mantenere data odierna
var oggi = new Date();

// aggiorna posizione dei marker sulla mappa
function aggiungimarker(dati) {
  var map = $('#map').vectorMap('get', 'mapObject');
  
  map.removeAllMarkers();
  for (var id = 0; id < dati.length; id++) {
    var posizione = dati[id];
    
    var marker = {
      name: posizione.nome,
      descrizione: posizione.descrizione,
      data: posizione.data,
      latLng: [posizione.latitudine, posizione.longitudine],
      style: {
        fill: 'yellow',
        stroke: 'black',
        'stroke-width': 1.75,
        r: '0.8vh',
      },
    };

    //non mostrare eventi passati
    data_evento= new Date(posizione.data);
    if (data_evento.getTime() > oggi.getTime()) {
      map.addMarker(id, marker);
    }
    
    var markerElement = $('#map').find('.jvectormap-marker[data-index="' + id + '"]');   // aggiunge attributi ai marker
    $(markerElement).data('style', marker.style);
    $(markerElement).data('name', marker.name);
    $(markerElement).data('descrizione', marker.descrizione);
    $(markerElement).data('data', marker.data);

    markers.push(marker.name);
    markelements.push(markerElement);   // array per mantenere markerElement


    $(markerElement).click(function() {
    var descrizione= $(this).data('descrizione');
    var name = $(this).data('name');
    var data= $(this).data('data');
    $('#text-content').html(descrizione);
    $('#input_p').val(name);
    $('#nome').html(name);
    $('#data').html(data);
  });
  }
}

// aggiorna mappa in base a input utente
$(document).ready(function() {    // esegue all'avvio del DOM
  $('#bar').keyup(function() {    
    var input= $(this).val();
    filtra(input);
  });
});

// funzione per filtrare i marker
function filtra(input) {
  threshold = {
  keys: ['name'],
  threshold: 0.1
  };
  oggetti = markers.map(name =>({name}));
  const fuse = new Fuse(oggetti,threshold);
  risultati = fuse.search(input);
  nomi = risultati.map(element=>element.item.name);
  if(input==''){
    for(j=0; j<markelements.length ; j++){
      markelements[j].show();
    }
    return true;
  }
  for (i=0;i<markelements.length;i++) {
    if(nomi.includes(markelements[i].data('name'))){
      markelements[i].show();
    }
    else{
      markelements[i].hide();
    }
  }
}











