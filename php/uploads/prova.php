<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $dbconn = pg_connect("host=localhost password=biar user=postgres port=5432 dbname=StartConnect") 
    or die("Errore di connessione:  . pg_last_error()");
    
    $nomeEvento = "a"; // Inserisci il nome dell'evento desiderato

    $query = "SELECT image FROM evento WHERE nome = $1";
    $res = pg_query_params($dbconn, $query, array($nomeEvento));

    if ($res) {
    $row = pg_fetch_assoc($res);
    $img = $row['image'];
    echo '<div>';
    echo '<img src="data:image/jpeg;base64,' . base64_encode($img) . '">';
    echo '</div>';
    } else {
    echo "Errore nella query di selezione dell'immagine.";
    }

    pg_close($dbconn);
</body>
</html>