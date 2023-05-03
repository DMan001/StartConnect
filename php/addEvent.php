<?php
    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
        or die("Errore di connessione:  . pg_last_error()");
        
    $indirizzo = $_POST["indirizzo"];
    $arr = explode(", ", $indirizzo);
    
    
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($arr[0]) . " " . urlencode($arr[1]) ."," . urlencode($arr[2]) . "&key=AIzaSyCaBYPo-63bn8jwXT7aq13N8NSOflaAKxc";
    $url = str_replace(" ", "+", $url);
    $json = file_get_contents($url);
    $info = json_decode($json);
   
    $lat = $info->results[0]->geometry->location->lat;
    $lng = $info->results[0]->geometry->location->lng;
    $_POST['latitudine'] = $lat;        // perchè risalvarli in POST?
    $_POST['longitudine'] = $lng;
    
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
        "latitudine"  => $_POST["latitudine"],
        "longitudine" => $_POST["longitudine"]
    );

    $res = pg_insert($dbconn, 'evento', $param);

    if ($res) {
        echo "POST data is successfully logged\n";
    } else {
        echo "User must have sent wrong inputs\n";
    }
?> 