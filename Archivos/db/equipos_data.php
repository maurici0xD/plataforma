<?php
include('../db/conexion.php');
$check = "SELECT * FROM $tabla1";
$resultado = mysqli_query($con, $check);
$resultado->bind_param('ii', $from, $to);
$resultado->execute();
$resultado->bind_result($id, $nombre, $password, $correo, $cedula, $cargo, 
$permisos, $ubicacion, $pregunta, $respuesta, $actualizado, $modificacion);

while ($resultado->fetch()){
	$orders[] = array(
		'id' => $id,
		'nombre' => $nombre,
		'password' => $password,
		'correo' => $correo,
		'cedula' => $cedula,
		'cargo' => $cargo,
        'permisos' => $permisos,
        'ubicacion' => $ubicacion,
        'pregunta' => $pregunta,
        'respuesta' => $respuesta,
        'actualizado' => $actualizado,
        'modificacion' => $modificacion
	);
	}
echo json_encode($orders);
$result->close();
?>