//file js per la gestione dell'area personale e dell'iscrizione agli ceventi


$(document).ready(function() {
  // Ajax per ottenere le informazioni sullo stato del login
  $.ajax({
    url: './php/stato_login.php',
    type:'GET',
    dataType:'json',
    //callback che gestisce il risultato e aggiorna il pulsante iscriviti
    success: function(infos) {
      var iscriviti = $('#iscriviti');
      if (!infos.loggedin) {
        iscriviti.prop('disabled', true);
      }
      else{
        iscriviti.prop('disabled', false);
      }
    },
  });
});












