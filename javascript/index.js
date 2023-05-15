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

$(document).ready(function() {
  $('#iscriviti').click(function() {
    var input=$('#nome').text();
    console.log(input);
    // Esegue lo script per l'iscrizione
    $.ajax({
      url:'./php/iscriviti.php',
      data: { input: input },
      type: 'POST',
      //callback che gestisce il risultato e mostra alert swal.fire
      success: function(exit_status) {
        if(exit_status==="Errore"){
          Swal.fire({
            icon: 'error',
            title:'Error!',
            text: 'Sei già iscritto a questo evento',
          }).then(function() {
            window.location.href ='./index.html';
          });
        }
        else{
        Swal.fire({
          icon: 'success',
          title:'Success!',
          text: 'Iscrizione avvenuta con successo!',
        }).then(function() {
            window.location.href ='./index.html';
        });
      }
    }
  });
});
});










