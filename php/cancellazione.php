<?php

    session_start();

    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
            or die("Errore di connessione:  . pg_last_error()");

    $evento = $_POST['evento'];

    $query = "delete from iscrizioni where email = $1 and nome = $2";
    $result = pg_query_params($dbconn, $query, array($_SESSION['email'], $evento));
    return $result;
?>