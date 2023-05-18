<?php
ob_start();
?>

<?php
session_start();
if (isset($_SESSION['pass'])) {
  if (isset($_POST['cambiar'])) {
    include('../db/conexion.php');
    $id = $_SESSION['pass'];
    $newpass1 = $_POST['newpass1'];
    $newpass2 = $_POST['newpass2'];
    if ($newpass1 == $newpass2) {
      $passchange = password_hash($newpass1, PASSWORD_DEFAULT);
      $query = $con->query("UPDATE $tabla1 SET password='$passchange' WHERE id='$id'");
      $_SESSION['message'] = "Su contraseña fue actualizada!";
      unset($_SESSION['pass']);
      echo "<script>location.href='../usr/login.php'</script>";
    } else {
      $_SESSION['message'] = "Las contraseñas no coinciden";
    }
  }
} else {
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
  <title>Cambiar contraseña</title>


</head>

<body>

  <div class="modal fade" id="cambiaclave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="col-md-1">
            <img class="mb-1" src="../../Archivos/Login/logo-DDB.png" alt="" width="60" height="110">
          </div>
          <div class="mx-auto">
            <h5 class="modal-title" id="exampleModalLabel">Recuperar contraseña</h5>
          </div>

        </div>

        <div class="modal-body">
          <form method="post">
            <?php if (isset($_SESSION['message'])) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
                <?php echo "" . $_SESSION['message'] . ""; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>
            <?php endif ?>
            <div class="form-floating">
              <input type="password" class="form-control" id="pass1" name="newpass1" placeholder="Nueva contraseña" required autofocus>
              <label for="pass1">Nueva contraseña</label>
            </div>

            <div class="form-floating">
              <input type="password" class="form-control" id="pass2" name="newpass2" placeholder="Verificar contraseña" required autofocus>
              <label for="pass2">Verificar contraseña</label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning" name="cambiar">Cambiar contraseña</button>
          <a class='btn btn-outline-dark' href="login.php">Cancelar</a>
        </div>
        </form>

      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $("#cambiaclave").modal("show");
    });
  </script>


</body>

</html>

<?php

ob_end_flush();

?>