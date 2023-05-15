<?php

    session_start();

    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
            or die("Errore di connessione:  . pg_last_error()");

    //trova nomi eventi a cui è iscritto l'utente
    $result_nome = pg_query($dbconn, "select nome from iscrizionieventi where
    email = '".$_SESSION['email']."'");

    $eventi= array();

    //per ogni nome trova la data dell'evento e saLva in un array
    while ($row = pg_fetch_assoc($result_nome)) {
        $result_data_descrizione = pg_query_params($dbconn, "select nome,data,descrizione from evento where nome = $1", array($row['nome']));
        $row_data_descrizione = pg_fetch_assoc($result_data_descrizione);
        $eventi[]=$row_data_descrizione;
    }
    
    //ritorna l'array in formato json
    header('Content-Type: application/json');
    
    echo json_encode($eventi);
?>