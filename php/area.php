<?php
session_start();
//se l'utente è loggato mostra la pagina personale,in caso contrario mostra una pagina in cui lo inviti a loggarsi
if(isset($_SESSION['loggedin'])) {
  header("Location:../area.html");
} else {
    header("Location: ../log.html");
}
?>