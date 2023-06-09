//file javascript per la pagina index.html

// Funzione che gestisce il click sul pulsante iscriviti rendendolo disabilitato
$(document).ready(function() {
  // Ajax per ottenere le informazioni sullo stato del login
  $.ajax({
    url: './php/stato_login.php',
    type: 'GET',
    dataType: 'json',
    // Callback che gestisce il risultato e aggiorna il pulsante iscriviti
    success: function(infos) {
      var iscriviti = $('#iscriviti');
      var alert = $('#iscritto');

      if (!infos.loggedin) {
        iscriviti.prop('disabled', true);
        alert.text('Effettua il login per iscriverti');
        alert.css('font-size', '2vh');
      } else {
        iscriviti.prop('disabled', false);
        alert.text(''); // Rimuove il testo se l'utente è loggato
      }
    },
  });
});