<?php
$dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
or die("Errore di connessione:  . pg_last_error()");

$longitude = $_POST['longitudine'];
$latitude = $_POST['latitudine'];

$query = "SELECT descrizione FROM evento WHERE latitudine = $latitudine AND longitudine = $longitudine";
$result = pg_query($dbconn, $query);

$row = pg_fetch_assoc($result);
$descrizione = $row['descrizione'];

echo json_encode(['descrizione' => $descrizione]);

pg_close($dbconn);
?>