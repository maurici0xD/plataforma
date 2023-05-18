
<?php
session_start();
if (isset($_POST['Login'])) {
  if ( (isset($_POST['Usuario'])) || (isset($_POST['Contraseña'])) ) {
    $user = $_POST['Usuario'];
    $pass = $_POST['Contraseña'];
    include ('../db/conexion.php');
    
    $check = "SELECT * FROM $tabla1 WHERE correo='$user'";
    $resultado = mysqli_query($con, $check);
    $chkpass = $resultado->fetch_assoc();


    if ($chkpass && password_verify($pass, $chkpass['password'])) {
        include ('../db/conexion.php');
        $user = $_POST['Usuario'];
        $pass = $_POST['Contraseña'];
        $query = "SELECT * FROM $tabla1 WHERE correo='$user'";
        $look = mysqli_query($con, $query);
        $userlogin = mysqli_fetch_array($look);
        $_SESSION['username'] = $userlogin['nombre'];
        $_SESSION['permisos'] = $userlogin['permisos'];
        $_SESSION['id'] = $userlogin['id'];
        $_SESSION['userlocation'] = $userlogin['ubicacion'];
        header("location: ../db/EquiposGLPI.php");
    }else{
      $_SESSION['badpass'] = "Usuario y/o Contraseña incorrectos";
      echo "<script>location.href='../usr/login.php'</script>";
      }

    mysqli_free_result($resultado);
    mysqli_close($con);


  }else{
      echo '<script>alert("No se admiten campos vacios")</script>';
      echo "<script>location.href='../usr/login.php'</script>";
    }

}else{
  echo '<script>alert("No hay variable login")</script>';
  header("location: ../usr/login.php");
}

?>

