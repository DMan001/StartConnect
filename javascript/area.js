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
