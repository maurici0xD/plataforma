<?php
ob_start();
?>
<?php 
include ('conexion.php');

$names = $_GET['q'];

$sql = "SELECT nombrecompleto FROM $tabla3 WHERE nombre LIKE '%$names%' OR correo like '%$names%' ORDER BY nombre ASC";
$res = mysqli_query($con, $sql);

$organiza = array();

while ($row=$res->fetch_assoc()) {

  $organiza[] = $row['nombrecompleto'];
  # code...
}

echo json_encode($organiza);

 ?>
 <?php
ob_end_flush();
?>