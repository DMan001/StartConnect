$(document).ready(function() {
  // Imposta il logout quando si clicca sul pulsante
  $('#logout').click(function() {
    $.ajax({
      url:  './php/logout.php',
      type:  'POST',
      dataType: 'text',
      //callback che gestisce il risultato e mostra alert swal.fire
      success: function(not_relevant) {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'LogOut avvenuto con successo!',
        }).then(function() {
          window.location.href = './index.html';
        });
      }
    });
  });
});