<?php
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">';

    error_reporting(E_ERROR | E_PARSE);

    $dbconn = pg_connect("host=localhost port=5432 dbname=StartConnect user=postgres password=biar")
        or die('Could not connect: ' . pg_last_error());

    if ($dbconn) {
        $nome = $_POST['inputUsername'];
        $email = $_POST['inputEmail'];

        $query = "select * from utente where email = $1";
        $result = pg_query_params($dbconn, $query, array($email));
        if ($tuple=pg_fetch_array($result, null, PGSQL_ASSOC)) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Error!',
                  text: 'Spiacente, email già usata, se vuoi loggarti clicca su Login.'
                }).then(() => {
                  window.location.href = '../index.html';
                });
              });
          </script>";
        }
        else {
            $param = array(
                "username"   => $_POST['inputUsername'],
                "email"      => $_POST['inputEmail'],
                "password"   => password_hash($_POST['inputPassword'], PASSWORD_DEFAULT)
            );
            
            $res = pg_insert($dbconn, "utente", $param);

            if ($res) {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'success',
                      title: 'Success!',
                      text: 'Registrazione avvenuta con successo!'
                    }).then(() => {
                      window.location.href = '../index.html';
                    });
                  });
              </script>";
            } else {
                echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                      icon: 'error',
                      title: 'Error!',
                      text: 'Registrazione non avvenuta correttamente!'
                    }).then(() => {
                      window.location.href = '../index.html';
                    });
                  });
              </script>";
            }
        }
    }
?>