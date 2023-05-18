<?php
session_start();
?>

<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>IT DDB</title>

  <link rel="canonical" href="../../Archivos/Login/signin.css">



  <!-- Bootstrap core CSS -->
  <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="manifest" href="../../Archivos/Login/manifest.json">
  <link rel="mask-icon" href="../../Archivos/Login/logo-ddb.svg" color="#7952b3">
  <link rel="icon" href="../../Archivos/Login/favicon.png">
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
  <link href="../../Archivos/Login/signin.css" rel="stylesheet">
</head>

<body class="text-center">
  <main class="form-signin">
    <img class="mb-4" src="../../Archivos/Login/logo-DDB.png" alt="" width="100" height="150">
    <h1 class="h3 mb-3 fw-normal">Iniciar sesion</h1>
    <?php if (isset($_SESSION['message'])) : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
        <?php echo "" . $_SESSION['message'] . ""; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>
    <?php unset($_SESSION['message']);
    endif ?>

    <?php if (isset($_SESSION['badpass'])) {
      echo '
    <form class="form-signin was-validated" novalidate method="post" action="../consultas/sesion.php">';
    } else {
      echo '<form class="form-signin needs-validation" novalidate method="post" action="../consultas/sesion.php">';
    }

    ?>
    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" name="Usuario" placeholder="name@example.com" required>
      <label for="floatingInput">Correo</label>
      <div class="invalid-feedback">
        <?php if (isset($_SESSION['badpass'])) {
          echo '';
        } else {
          echo 'Por favor, escriba un correo valido.';
        }
        ?>
      </div>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" name="Contraseña" placeholder="Contraseña" required>
      <label for="floatingPassword">Contraseña</label>
      <div class="invalid-feedback">
        <?php if (isset($_SESSION['badpass'])) {
          echo 'Usuario o contraseña incorrectos.';
        } else {
          echo 'Por favor, escriba su contraseña.';
        } ?>
      </div>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-warning" type="submit" name="Login">Iniciar sesion</button>
    <div><a href="" data-toggle="modal" data-bs-toggle="modal" data-bs-target="#olvidoclave">¿Olvidó su contraseña?</a></div>
    <div><a href="registrarse.php">Registrarse</a></div>
    <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
    </form>
  </main>

  <div class="modal fade" id="olvidoclave" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
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
          <form method="post" action="../usr/recupera.php">
            <?php if (isset($_SESSION['messager'])) : ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
                <?php echo "" . $_SESSION['messager'] . ""; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                </button>
              </div>
            <?php endif ?>
            <div class="form-floating">
              <input type="email" class="form-control" id="usuarior" name="Correo" placeholder="Ingrese su correo" required>
              <label for="usuarior">Ingrese su correo</label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning" name="Recupera">Enviar</button>
          <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>

        </div>
        </form>

      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <?php if (isset($_SESSION['messager'])) : ?>
    <script>
      $(document).ready(function() {
        $("#olvidoclave").modal("show");
      });
    </script>
  <?php unset($_SESSION['messager']);
  endif ?>

  <?php if (isset($_SESSION['badpass'])) : ?>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('was-validated');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  <?php unset($_SESSION['badpass']);
  else : ?>
    <script>
      // Example starter JavaScript for disabling form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  <?php endif ?>
</body>

</html>

<?php
ob_end_flush();
?>