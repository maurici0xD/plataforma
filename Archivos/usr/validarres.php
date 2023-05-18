<?php
ob_start();
?>

<?php
session_start();
if (isset($_POST['check'])) {
  $verrespuesta = $_POST['respuesta1'];
  $id2 = $_POST['id'];
  include('../db/conexion.php');
  $check2 = "SELECT * FROM $tabla1 WHERE id='$id2'";
  $resultado = mysqli_query($con, $check2);
  $filas = mysqli_num_rows($resultado);
  if ($filas > 0) {
    include('../db/conexion.php');
    $query = "SELECT * FROM $tabla1 WHERE id='$id2'";
    $look = $con->query($query);
    $chkres = $resultado->fetch_assoc();
    if ($chkres && password_verify($verrespuesta, $chkres['respuesta'])) {
      $id2 = $_POST['id'];
      $_SESSION['pass'] = $id2;
      header("location: ucp.php");
    } else {
      $_SESSION['message'] = "La respuesta no es correcta";
      echo "<script>location.href='login.php'</script>";
    }
  }
} else {
  header("location: index.php");
}

?>

<?php
ob_end_flush();
?>