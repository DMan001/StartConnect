<?php
session_start();
//se l'utente è loggato mostra la pagina personale,in caso contrario mostra una pagina in cui lo inviti a loggarsi
if(isset($_SESSION['loggedin'])==false) {
    header("Location: ./log.html");
}
?>
<!DOCTYPE html>
<html >
  <head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/area.css">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="javascript\area.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

    <script>
      // Recupera l'username da sessionStorage
      var username = sessionStorage.getItem('username');

      // Aggiorna il contenuto dell'elemento HTML
      document.addEventListener('DOMContentLoaded', function() {
        var usernameElement = document.getElementById('username');
        usernameElement.textContent = username;
      });
    </script>
  </head>

  <body>
      <!-- Navbar -->
    <div id="nav-placeholder">
    </div>
    <script>
      $(function(){
        $("#nav-placeholder").load("nav.html");
      });
    </script>

    <div id="info">
    <h1>Benvenuto <span id="username" style="text-align: left"></span></h1>
    <h2>Qui puoi visualizzare gli eventi a cui ti sei iscritto:</h2>
    
    <?php
    //connessione al database
    $dbconn = pg_connect("host=localhost port=5432 dbname=StartConnect user=postgres password=biar")
        or die('Could not connect: ' . pg_last_error());
    //se la connessione è andata a buon fine
    if ($dbconn) {
      $query = "SELECT *
                FROM iscrizioni LEFT JOIN evento ON iscrizioni.nome = evento.nome 
                WHERE iscrizioni.email = $1";
      
      $result = pg_query_params($dbconn, $query, array($_SESSION['email']));

      if (!$result) {
          echo "Errore nella query.";
          exit;
      }

      if (pg_num_rows($result) == 0){
        echo "Non sei iscritto a nessun evento";
      }
      else{

        echo "<br>";

        echo "<div class='event-container'>";
        while ($row = pg_fetch_assoc($result)) {
          $nomeEvento = $row['nome'];
          if ($row['civico'] == 0)
            $luogoEvento = $row['via'] . ', '. $row['città'] . ', ' . $row['provincia'];
          else
            $luogoEvento = $row['via'] .' '. $row['civico'] . ', '. $row['città'] . ', ' . $row['provincia'];
          $dataEvento = $row['data'];
          $host = $row['host'];
          $email = $row['email'];
          $descrizione = $row['descrizione'];
          $urlImmagine = $row['urlimmagine'];

          echo '<div class="event-card">';
          echo '<h2>' . $nomeEvento . '</h2>';
          echo '<img src="' . $urlImmagine . '" alt="Immagine evento">';
          echo '<p>Luogo:<br>' . $luogoEvento . '</p>';
          echo '<p>Data:<br>' . $dataEvento . '</p>';
          echo '<p>Host:<br><em>' . $host . '</em></p>';
          echo '<p>Email:<br>' . $email . '</p>';
          echo '<p>Descrizione:<br><em>' . $descrizione . '</em></p>';
          echo '<button class="btn btn-danger" onclick="Cancella(\'' . addslashes($nomeEvento). '\')">Cancella</button>';
          echo '</div>';
        }
        echo "</div>";
      }

    }
    ?>

    </div>
  </body>
</html>
