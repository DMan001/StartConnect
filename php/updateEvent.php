<?php
    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
            or die("Errore di connessione:  . pg_last_error()");

    $result = pg_query($dbconn, 
    "select nome, descrizione, latitudine, longitudine, data, urlimmagine from evento");
    
    $coordinate = array();
    while ($row = pg_fetch_assoc($result)) {
        $coordinate[] = $row;
    }
    
    header('Content-Type: application/json');
    
    echo json_encode($coordinate);
?>