<?php
  //Permetto all'utente di iscriversi ad un evento gestendo la sua richiesta fatta dal pulsante iscriviti
  session_start();

  $nome = $_POST['input'];
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
  
  if (($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
          die("Errore");
  }   
  $res = pg_insert($dbconn, "iscrizionieventi", $param);
?>
