<?php
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">';

    error_reporting(E_ERROR | E_PARSE);
    
    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
        or die("Errore di connessione:  . pg_last_error()");
        
    $indirizzo = $_POST["indirizzo"];
    $arr = explode(", ", $indirizzo);
    
    
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($arr[0]) . " " . urlencode($arr[1]) ."," . urlencode($arr[2]) . "&key=AIzaSyCaBYPo-63bn8jwXT7aq13N8NSOflaAKxc";
    $url = str_replace(" ", "+", $url);
    $json = file_get_contents($url);
    $coordinate = json_decode($json);
   
    $latitudine = $coordinate->results[0]->geometry->location->lat;
    $longitudine = $coordinate->results[0]->geometry->location->lng;

    
    $param = array(
        "nome"      => $_POST["nome"],
        "host"      => $_POST["host"],
        "email"     => $_POST["email"],
        "via"       => $arr[0],
        "civico"    => intval($arr[1]),
        "città"     => $arr[2],
        "provincia" => $arr[3],
        "data"        => $_POST["data"],
        "descrizione" => $_POST["descrizione"],
        "latitudine"  => $latitudine,
        "longitudine" => $longitudine
    );

    //controllo se l'evento esiste già
    $query = "select * from evento where nome = $1";
    $result = pg_query_params($dbconn, $query, array($_POST["nome"]));

    if($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)){
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Nome evento già esistente, Scegline un altro!'
            }).then(() => {
              window.location.href = '../organizzazione.html';
            });
          });
      </script>";
    }
    else{

    $res = pg_insert($dbconn, 'evento', $param);

    if ($res) {
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: 'Evento aggiunto con successo!'
            }).then(() => {
              window.location.href = '../organizzazione.html';
            });
          });
      </script>";
    }
    else{
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Error!',
              text: 'Errore nell\'aggiunta dell\'evento!'
            }).then(() => {
              window.location.href = '../organizzazione.html';
            });
          });
      </script>";
    }
  }
?> 