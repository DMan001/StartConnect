<?php
session_start();

if(isset($_SESSION['utente'])) {
    header("Location: ../iscrizione.html");
} else {
    header("Location: ../iscrizionelog.html");
}
?>