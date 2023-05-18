<?php
ob_start();
session_start();
?>

<?php
include('../db/conexion.php');
date_default_timezone_set('America/Bogota');
$fecha = date("d-m-Y");
if (isset($_POST['registrarse'])) {
  $nombre1 = $_POST['nombre'];
  $nombre2 = strtolower($nombre1);
  $nombre = ucwords($nombre2);
  $contraseña1 = $_POST['Contraseña'];
  $contraseña2 = $_POST['Contraseña2'];
  $pregunta = $_POST['pregunta'];
  $respuesta = $_POST['respuesta'];
  $correo1 = $_POST['Correo'];
  $correo = strtolower($correo1);
  $permisos = "user";
  $actualizado = date("d-m-Y");
  $modificacion = "registro";
  $ubicacion = $_POST['ubicacion'];
  $cargo1 = $_POST['cargo'];
  $cargo2 = strtolower($cargo1);
  $cargo = ucwords($cargo2);
  $cedula = $_POST['cedula'];

  if ($contraseña1 == $contraseña2) {
    $check = "SELECT * FROM $tabla1 WHERE correo='$usuario' or nombre='$nombre'";
    $resultado = mysqli_query($con, $check);
    $filas = mysqli_num_rows($resultado);
    if ($filas > 0) {
      $_SESSION['message'] = "Este usuario ya se encuentra registrado, no se pueden guardar los datos.";
      echo "<script type='text/javascript'>";
      echo "window.history.back(-1)";
      echo "</script>";
    } else {
      $passcr = password_hash($contraseña2, PASSWORD_DEFAULT);
      $rescr = password_hash($respuesta, PASSWORD_DEFAULT);
      $con->query("INSERT INTO $tabla1 (nombre,correo,password,permisos,pregunta,respuesta,actualizado,modificacion,ubicacion,cargo,cedula) VALUES ('$nombre','$correo','$passcr','$permisos','$pregunta','$rescr','$actualizado','$modificacion','$ubicacion','$cargo','$cedula')");
      mysqli_close($con);
      $_SESSION['message'] = "Usted se ha registrado con exito.";
      echo "<script>location.href='login.php'</script>";
    }
  } else {
    $_SESSION['message'] = "La contraseña ingresada no coincide con la verificacion";
    echo "<script type='text/javascript'>";
    echo "window.history.back(-1)";
    echo "</script>";
  }
}

if (isset($_POST['volver'])) {
  header("location: ../usr/login.php");
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="../../Archivos/Login/favicon.png">
  <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <title>IT DDB - Registro</title>
</head>

<body>
  <div class="modal fade" id="registrarse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-md-1">
            <img class="mb-1" src="../../Archivos/Login/logo-DDB.png" alt="" width="60" height="110">
          </div>
          <div class="mx-auto">
            <h3>Para registrarse, complete la siguiente informacion: <small></small></h3>
          </div>
        </div>
        <div class="modal-body">

          <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
              <?php echo "" . $_SESSION['message'] . ""; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
              </button>
            </div>
          <?php endif ?>
          <form method="post">
            <div class="row g-3">
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="text" name="nombre" id="nme" class="form-control input-lg" placeholder="Nombre completo" autofocus required="" tabindex="1">
                  <label for="nme">Nombre Completo</label>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="email" name="Correo" id="usr" class="form-control input-lg" placeholder="Correo" required tabindex="2">
                  <label for="usr">Correo</label>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="text" name="pregunta" id="preg" class="form-control input-lg" placeholder="Pregunta de seguridad" required tabindex="3">
                  <label for="preg">Pregunta de seguridad</label>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="password" name="respuesta" id="res" class="form-control input-lg" placeholder="Respuesta a su pregunta" required tabindex="4">
                  <label for="res">Respuesta a su pregunta</label>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="text" name="cargo" id="cargo" class="form-control input-lg" placeholder="Cargo" required tabindex="5">
                  <label for="cargo">Cargo actual</label>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="number" name="cedula" id="cedula" class="form-control input-lg" placeholder="Cedula" required pattern="[0-9]+" tabindex="6">
                  <label for="cedula">Escriba su cedula</label>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="password" name="Contraseña" id="contra" class="form-control input-lg" placeholder="Contraseña" required minlength="8" tabindex="7">
                  <label for="contra">Contraseña</label>
                </div>
              </div>

              <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-floating">
                  <input type="password" name="Contraseña2" id="contra2" class="form-control input-lg" placeholder="Confirmar Contraseña" required minlength="8" tabindex="8">
                  <label for="contra2">Confirmar Contraseña</label>
                </div>
              </div>

              <div class="col-xs-6 col-sm-4 col-md-4">
                <div class="form-floating ">
                  <select class="form-select" id="ubicacion" name="ubicacion" required tabindex="9">
                    <option></option>
                    <option>Medellin</option>
                    <option>Bogota</option>
                  </select>
                  <label for="ubicacion">Ubicacion</label>
                </div>
              </div>

              <div class="modal-footer">
                <input type="submit" name="registrarse" value="Registrarse" class="btn btn-warning btn-block btn-lg" tabindex="10">
                <a href="../usr/login.php" class="btn btn-outline-dark btn-block btn-lg" tabindex="11">Iniciar sesion</a>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $("#registrarse").modal("show");
    });
  </script>
</body>

</html>

<?php
ob_end_flush();
?>