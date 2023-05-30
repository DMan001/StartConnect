//file contenenete le funzioni per la gestione dell'area personale

// Ajax per logout
$(document).ready(function() {
  // Imposta il logout quando si clicca sul pulsante
  $('#logout').click(function() {
    $.ajax({
      url:  './php/logout.php',
      type:'POST',
      //callback che gestisce il risultato e mostra alert swal.fire
      success: function(not_relevant) {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text:'LogOut avvenuto con successo!',
        }).then(function() {
          window.location.href = './index.html';
        });
      }
    });
  });
});



function Cancella(evento) {
  // Use AJAX to send a request to delete the event
  $.ajax({
    url: './php/cancellazione.php',
    type:'POST',
    data: {evento: evento},
    success: function(ok) {
        Swal.fire('Success', 'Evento cancellato con successo', 'success').then(function() {
          location.reload();
        });
    }
  });
}

// Ajax per ottenere eventi a cui è iscritto l'utente
$(document).ready(function() {
    $.ajax({
      url:  './php/get_events.php',
      type:'POST',
      success: function(dati) {
        for (var i = 0; i < dati.length; i++) {
          console.log(dati[i]);
        }
      }
    });
  });
