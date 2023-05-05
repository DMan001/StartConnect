<?php
    $dbconn = pg_connect("host=localhost port=5432 dbname=StartConnect user=postgres password=biar")
        or die('Could not connect: ' . pg_last_error());

    if ($dbconn) {
        $nome = $_POST['inputUsername'];
        $email = $_POST['inputEmail'];

        $query = "select * from utente where email = $1";
        $result = pg_query_params($dbconn, $query, array($email));
        if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {
            echo "Spiacente, email già usata, se vuoi loggarti clicca su Login.";
        }
        else {
            $param = array(
                "username"   => $_POST['inputUsername'],
                "email"      => $_POST['inputEmail'],
                "password"   => password_hash($_POST['inputPassword'], PASSWORD_DEFAULT)
            );
            
            $res = pg_insert($dbconn, "utente", $param);

            if ($res) {
                echo "POST data is successfully logged\n";
            } else {
                echo "User must have sent wrong inputs\n";
            }
        }
    }
?>