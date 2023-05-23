<?php
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">';

    error_reporting(E_ERROR | E_PARSE);
    
    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
        or die("Errore di connessione:  . pg_last_error()");

    // gestione indirizzo con coordinate
    $indirizzo = $_POST["indirizzo"];
    $arr = explode(", ", $indirizzo);

    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($arr[0]) . " " . urlencode($arr[1]) ."," . urlencode($arr[2]) . "&key=AIzaSyCaBYPo-63bn8jwXT7aq13N8NSOflaAKxc";
    $url = str_replace(" ", "+", $url);
    $json = file_get_contents($url);
    $coordinate = json_decode($json);
   
    $latitudine = $coordinate->results[0]->geometry->location->lat;
    $longitudine = $coordinate->results[0]->geometry->location->lng;

    // upload immagine
    $upload_dir = getcwd().DIRECTORY_SEPARATOR.'/uploads/';
    $save_path = '';

    if($_FILES['image']['error'] == UPLOAD_ERR_OK)
    {
      $temp_name = $_FILES['image']['tmp_name'];    // percorso temporaneo
      $name = basename($_FILES['image']['name']);   // nome immagine
      $save_path = $upload_dir.$name;
      move_uploaded_file($temp_name, $save_path);   // sposta in uploads

      /* NON NECESSARIO
      $fh = fopen($save_path, 'rb');    // lettura binaria
      $fbytes = fread($fh, filesize($save_path));   // legge fino alla dimensione del file
      */

      $relative_path = 'php/uploads/'.$name;
    }
    
    // query
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
        "longitudine" => $longitudine,
        // "image"       => base64_encode($fbytes),
        "urlimmagine" => $relative_path
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
      echo $save_path;
      echo $param["urlimmagine"];

      //   echo "<script>
      //   document.addEventListener('DOMContentLoaded', function() {
      //       Swal.fire({
      //         icon: 'error',
      //         title: 'Error!',
      //         text: 'Errore nell\'aggiunta dell\'evento! ". pg_last_error() ."'
      //       }).then(() => {
      //         window.location.href = '../organizzazione.html';
      //       });
      //     });
      // </script>";
    }
  }
?> 