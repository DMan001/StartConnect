<?php
session_start();
//se l'utente è loggato mostra la pagina personale,in caso contrario mostra una pagina in cui lo inviti a loggarsi
if(isset($_SESSION['loggedin'])==false) {
    header("Location: ../log.html");
}
?>
<!DOCTYPE html>
<html >
  <head>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/forms.css">
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="javascript\area.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
  </head>

  <body>
      <!-- Navbar -->
    <!--Navigation bar-->
    <div id="nav-placeholder">
    </div>
    <script>
      $(function(){
        $("#nav-placeholder").load("nav.html");
      });
    </script>
    <!--end of Navigation bar-->

    <div class="container-5">

      <h1 style="text-align: center; margin-top:20vh;">Ciao</h1>
      <div class="title">
        <button id="logout" style="height: 6vh;"class="btn btn-primary">logout</button>
      </div>
    </div>
  </body>
</html>
