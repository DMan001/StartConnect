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
    } else {
        echo "User must have sent wrong inputs\n";
    }
?> 