<?php
session_start();
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IT DDB</title>

  <link rel="canonical" href="Archivos/Login/signin.css">



  <!-- Bootstrap core CSS -->
  <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="manifest" href="Archivos/Login/manifest.json">
  <link rel="mask-icon" href="Archivos/Login/logo-ddb.svg" color="#7952b3">
  <link rel="icon" href="Archivos/Login/favicon.png">
  <meta name="theme-color" content="#7952b3">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="Archivos/Login/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <?php if (isset($_SESSION['badpass'])) {
    echo '
    <form class="form-signin was-validated" novalidate method="post" action="../consultas/sesion.php">';
  } else {
    echo '
    <form class="form-signin needs-validation" novalidate method="post" action="../consultas/sesion.php">';
  }
  ?>

  <main class="form-signin">
    <form>
      <img class="mb-4" src="Archivos/Login/logo-DDB.png" alt="" width="100" height="150">
      <h1 class="h3 mb-3 fw-normal">Por favor, iniciar sesion</h1>

      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required autofocus>
        <label for="floatingInput">Correo</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Contraseña" required>
        <label for="floatingPassword">Contraseña</label>
      </div>

      <div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-warning" type="submit">Iniciar sesion</button>
      <div><a href="" data-toggle="modal" data-target="#olvidoclave">¿Olvidó su contraseña?</a></div>
      <div><a href="registrarse.php">Registrarse</a></div>
      <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
    </form>
  </main>

  <div class="modal fade" id="olvidoclave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Recuperar contraseña</h5>
        </div>
        <div class="modal-body">
          <form method="post" action="../usr/recupera.php">
            <?php if (isset($_SESSION['messager'])) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
                <?php echo "" . $_SESSION['messager'] . ""; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <?php endif ?>
            <div class="form-label-group">
              <input type="text" class="form-control" id="usuarior" name="Usuario" placeholder="Escriba su usuario" required autofocus>
              <label for="usuarior">Escriba su usuario</label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" name="Login">Enviar</button>
        </div>
        </form>

      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

  <?php if (isset($_SESSION['messager'])) : ?>
    <script>
      $(document).ready(function() {
        $("#olvidoclave").modal("show");
      });
    </script>
  <?php unset($_SESSION['messager']);
  endif ?>

</body>

</html>