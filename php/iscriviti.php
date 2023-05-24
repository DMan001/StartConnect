<?php
  echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
  echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">';
  
  //Permetto all'utente di iscriversi ad un evento gestendo la sua richiesta fatta dal pulsante iscriviti
  session_start();

  $nome = $_POST['input_p'];
  $email=$_SESSION['email'];


  $dbconn = pg_connect("host=localhost port=5432 dbname=StartConnect 
  user=postgres password=biar") 
  or die('Could not connect: ' . pg_last_error());

  $param = array(
        "nome" => $nome, 
        "email" => $email,
      );
  $q1 = "select * from iscrizionieventi where nome = $1 and email = $2";
  $result = pg_query_params($dbconn, $q1, array($nome,$email));

  $q2 = "select * from evento where nome = $1";
  $result2 = pg_query_params($dbconn, $q2, array($nome));
  $tuple = pg_fetch_array($result2, null, PGSQL_ASSOC);

  if($tuple==false){
    echo 
    "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title:'Error!',
            text: 'Evento non trovato!'
        }).then(() => {
        window.location.href = '../index.html';
        });
    });
    </script>";
  }
  else{
  
    if (($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
      echo 
      "<script>
      document.addEventListener('DOMContentLoaded', function() {
          Swal.fire({
              icon: 'error',
              title:'Error!',
              text: 'Sei già iscritto a questo evento!'
          }).then(() => {
          window.location.href = '../index.html';
          });
      });
      </script>";
    }
    else{ 
      $res = pg_insert($dbconn, "iscrizionieventi", $param);
      if($res){
        echo 
        "<script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title:'Success!',
              text: 'Ti sei iscritto correttamente!'
          }).then(() => {
          window.location.href = '../index.html';
          });
        });
        </script>";
      }
    }
  }
?>
