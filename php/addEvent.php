<?php
    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
        or die("Errore di connessione:  . pg_last_error()");
        
    $indirizzo = $_POST["indirizzo"];
    $arr = explode(", ", $indirizzo);
    
    $param = array(
        "nome"      => $_POST["nome"],
        "host"      => $_POST["host"],
        "email"     => $_POST["email"],
        "via"       => $arr[0],
        "civico"    => intval($arr[1]),
        "città"     => $arr[2],
        "provincia" => $arr[3],
        "data"        => $_POST["data"],
        "descrizione" => $_POST["descrizione"]
    );



    $res = pg_insert($dbconn, 'evento', $param);
    if ($res) {
        echo "POST data is successfully logged\n";
    } else {
        echo "User must have sent wrong inputs\n";
    }
?> 