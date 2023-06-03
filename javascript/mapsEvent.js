// inizializzazione mappa e ricerca indirizzo
function initAutocomplete() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 41.896617077364326, lng: 12.52104926807117 },
    zoom: 13,
    mapTypeId: "roadmap",
  });

  const input = document.getElementById("indirizzo");
  const searchBox = new google.maps.places.SearchBox(input);

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  map.addListener("bounds_changed", () => {
    searchBox.setBounds(map.getBounds());
  });

  map.addListener("click", (event) => {
    const geocoder = new google.maps.Geocoder();
    
    // Reverse Geocoding per ottenere l'indirizzo a partire dalle coordinate al click
    geocoder.geocode({ location: event.latLng }, (results, status) => {
      if (status === "OK") {
        if (results[0]) {
          input.value = results[0].formatted_address;
        } else {
          console.log("No results found");
        }
      } else {
        console.log("Geocoder failed due to: " + status);
      }
    });
  });  

  let markers = [];

  // Ricerca indirizzo
  searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // Rimuove i marker precedenti
    markers.forEach((marker) => {
      marker.setMap(null);
    });
    markers = [];

    const bounds = new google.maps.LatLngBounds();

    // Per ogni risultato trovato, aggiunge un marker
    places.forEach((place) => {
      if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
      }

      const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
      };

      markers.push(
        new google.maps.Marker({
          map,
          icon,
          title: place.name,
          position: place.geometry.location,
        })
      );
      if (place.geometry.viewport) {
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}

window.initAutocomplete = initAutocomplete;