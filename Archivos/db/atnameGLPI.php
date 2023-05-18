<?php
ob_start();
?>
<?php 
include ('conexionGLPI.php');

$names = $_GET['q'];

$sql = "SELECT glpi.glpi_users.firstname as nombreusuario,
glpi.glpi_users.realname as apellido,
glpi.glpi_useremails.email as correo
FROM glpi.glpi_users
left join glpi.glpi_useremails on glpi_users.id=glpi_useremails.users_id
WHERE glpi.glpi_users.realname LIKE '%$names%' OR glpi.glpi_users.firstname LIKE '%$names%' OR glpi.glpi_useremails.email like '%$names%' ";
$res = mysqli_query($conglpi, $sql);

$organiza = array();

while ($row=$res->fetch_assoc()) {
    $nombrecompleto = $row['nombreusuario'] ." ". $row['apellido'];
    $organiza[] = $nombrecompleto;

  # code...
}

echo json_encode($organiza);

 ?>
<?php
ob_end_flush();
?>