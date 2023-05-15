
<?php
    //controllo se l'utente è loggato
    session_start();

    $infos = array();

    $infos['loggedin'] = isset($_SESSION['loggedin']);

    header('Content-Type: application/json');
    echo json_encode($infos);
?>