<?php
ob_start();
?>
<?php
session_start();
session_destroy();
session_start();
$_SESSION['message'] = "Se ha cerrado sesion por inactividad.";
header("Location: ../usr/login.php");
die();
?>

<?php
ob_end_flush();
?>