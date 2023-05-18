<?php

ob_start();

?>
<?php
session_start();
if (isset($_SESSION['username'])) {
  date_default_timezone_set('America/Bogota');
  $fecha = date("Y-m-d");
  $reclamarpc = false;
  $userlogubicacion = $_SESSION['userlocation'];
  // echo "Bienvenido, ".$_SESSION['username']." ".$fecha;
  if ($_SESSION['permisos'] == "admin") {
    header("location: controlpanel.php");
  }
} else {
  header("location: Archivos/usr/login.php");
}
if (isset($_GET['salir'])) {
  session_destroy();
  header("location: Archivos/usr/login.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="../../Archivos/Login/favicon.png">
  <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="Archivos/Fontawesome/css/all.css" rel="stylesheet">
  <title>Menú usuario</title>
</head>

<body>
  <div class="service">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 offset-lg-4 text-center">
          <h1>Inventario de equipos</h1>
          <p>Seleccione una de las siguientes opciones:</p>

        </div>
      </div>

      <div>
        <?php if (isset($_SESSION['message'])) : ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
            <?php echo "" . $_SESSION['message'] . ""; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php unset($_SESSION['message']);
        endif ?>
      </div>

      <div class="row align-items-center">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
          <span class="fa-stack fa-3x">
            <i class="fas fa-circle fa-stack-2x"></i>
            <a href="db/registrar-equipo.php"><i class="fas fa-laptop fa-stack-1x fa-inverse"></i></a>
          </span>
          <h2>Registrar equipo</h2>
          <p>Aquí puedes registrar un equipo que actualmente no exista en el inventario. </p>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
          <span class="fa-stack fa-3x">
            <i class="fas fa-circle fa-stack-2x"></i>
            <a href="Archivos/db/Equipos.php"><i class="fab fa-searchengin fa-stack-1x fa-inverse"></i></a>
          </span>
          <h2>Buscar y modificar</h2>
          <p>Haz una consulta, actualiza información de un equipo o bien elimina el registro si quieres. </p>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
          <span class="fa-stack fa-3x">
            <i class="fas fa-certificate fa-stack-2x fa-spin"></i>
            <a href="consultas/contactos.php"><i class="far fa-address-book fa-stack-1x fa-inverse"></i></a>
          </span>
          <h2>Contactos y/o usuarios</h2>
          <p>Registra, modifica o actualiza la informacion de las personas o usuarios. </p>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
          <span class="fa-stack fa-3x">
            <i class="fas fa-circle fa-stack-2x "></i>
            <a href="db/enprestamo.php"><i class="fas fa-box-open fa-stack-1x fa-inverse"></i></a>
          </span>
          <h2>Equipos de prestamo</h2>
          <p>Acá puedes verificar el estado de los equipos prestados.</p>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 offset-lg-3 offset-md-3 text-center">
          <span class="fa-stack fa-3x">
            <i class="fas fa-circle fa-stack-2x"></i>
            <a href="usr/cuseri.php"><i class="far fa-address-card fa-stack-1x fa-inverse"></i></a>
          </span>
          <h2>Mi cuenta</h2>
          <p>Cambia tu contraseña, informacion personal y otros elementos de seguridad.</p>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">
          <span class="fa-stack fa-3x">
            <i class="fas fa-circle fa-stack-2x "></i>
            <a href="db/Enviartoexcel.php"><i class="far fa-file-excel fa-stack-1x fa-inverse"></i></a>
          </span>
          <h2>Exportar</h2>
          <p>Exporta informacion facilmente eligiendo una categoria.</p>
        </div>


        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 text-center">
          <span class="fa-stack fa-3x">
            <a href="index.php?salir=yes"><i class="fas fa-bed" style="color:#F21411"></i></a>
          </span>
          <h2>Cerrar Sesion</h2>
        </div>
      </div>


    </div>
  </div>

</body>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script src="Archivos/js/sesioninactiva.js"></script>

<script>
  window.onload = function() {
    inactivityTime();
  }
</script>

<?php if ($reclamarpc === true) :  ?>
  <script>
    $(document).ready(function() {

      $("#prestamomodal").modal("show");
    });
  </script>
<?php endif; ?>

</html>



<?php

ob_end_flush();

?>