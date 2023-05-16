$(document).ready(function() {
    // Ajax per ottenere le informazioni sullo stato del login
    $.ajax({
      url: './php/stato_login.php',
      type:'GET',
      dataType:'json',
      // nasconde login e signup se loggato
      success: function(infos) {
        if (infos.loggedin) {
          $('#login').attr('hidden', true);
          $('#signup').attr('hidden', true);
          $('#logout').attr('hidden', false);
        }
        else {
            $('#login').attr('hidden', false);
            $('#signup').attr('hidden', false);
            $('#logout').attr('hidden', true);
        }
      },
    });
  });

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
  