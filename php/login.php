<?php

// script per fancy alert
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">';

session_start();


if(isset($_SESSION['loggedin']) and $_SESSION['loggedin'] == true) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title:'Error!',
                    text: 'Sei già loggato!'
                }).then(() => {
                window.location.href = '../index.html';
                });
            });
        </script>";
}
else{

  // chiamata al Database per verificare validità password inserita
  $dbconn = pg_connect("host=localhost port=5432 dbname=StartConnect 
            user=postgres password=biar") 
            or die('Could not connect: ' . pg_last_error());

  if  ($dbconn) {
    $email = $_POST['inputEmailLogin'];
    $q1 = "select * from utente where email = $1";
    $result = pg_query_params($dbconn, $q1, array($email));
    if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
        echo "<h1>Non sembra che ti sia registrato/a</h1>
            <a href=../registrazione/index.html> Clicca qui per farlo </a>";
    }
    else {
        $password = $_POST['inputPasswordLogin'];

        $q2 = "SELECT username, password FROM utente WHERE email=$1";
        $result = pg_query_params($dbconn, $q2, array($email));
        if (!$result) {
            // errore nella query
            die("Errore nella query: " . pg_last_error());
        }
        
        // ottiene il risultato della query
        $row = pg_fetch_assoc($result);
        $password_hash = $row['password'];
        
        // verifica la password
        if (password_verify($password, $password_hash)) {
            
            session_regenerate_id(true);
            //impostiamo la variabile di sessione email e loggedin
            $_SESSION['email'] = $email;
            $_SESSION['loggedin'] = true;

            // success
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: 'Accesso avvenuto con successo!'
                    }).then(() => {
                      window.location.href = '../index.html';
                    });
                });
            </script>";
            }
        else {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Accesso non avvenuto correttamente, password o email sono sbagliati!'
                        }).then(() => {
                            window.location.href = '../index.html#login';
                        });
                    });
                </script>";
        }
    }
  }
}
?>