$(function() {
  // console.log("Initializing map...");
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





