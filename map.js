$(function() {
  console.log("Initializing map...");
  $('#map').vectorMap({
    map: 'it_mill',
    backgroundColor: '#FFFFFF',
    series: {
      regions: [{
        values: {
        },
        attribute: 'fill'
      }]
    }
  });
});





