$(function() {
  console.log("Initializing map...");
  $('#map').vectorMap({
    map: 'it_mill',
    backgroundColor: '#FFFFFF',
    series: {
      regions: [{
        values: {
          'IT-21': '#3B729F',
          'IT-25': '#3B729F',
          'IT-34': '#3B729F'
        },
        attribute: 'fill'
      }]
    }
  });
});





