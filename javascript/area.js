//file contenenete le funzioni per la gestione dell'area personale

function Cancella(evento) {
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