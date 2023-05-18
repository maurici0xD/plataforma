<?php

ob_start();

?>

<?php

session_start();

if (isset($_POST['reguser'])) {
  $_SESSION['id2']  = $_POST['id'];
  $serial1 = $_POST['Serial'];
  $serial = strtoupper($serial1);
  $_SESSION['serial']  = $serial;
  $Marca1 = $_POST['Marca'];
  $Marca2 = strtolower($Marca1);
  $Marca = ucwords($Marca2);
  $_SESSION['marca']  = $Marca;
  $Modelo1 = $_POST['Modelo'];
  $Modelo = strtoupper($Modelo1);
  $_SESSION['modelo']  = $Modelo;
  $_SESSION['procesador'] = $_POST['Procesadorname'];
  $_SESSION['Ram'] = $_POST['Ram'];
  $_SESSION['Disco'] = $_POST['Disco'];
  $cargador1 = $_POST['cargaserial'];
  $cargador2 = strtoupper($cargador1);
  $_SESSION['cargaserial'] = $cargador2;
  $pantalla1 = $_POST['pantallaserial'];
  $pantalla2 = strtoupper($pantalla1);
  $_SESSION['pantallaserial'] = $pantalla2;
  $compname1 = $_POST['computername'];
  $compname2 = strtoupper($compname1);
  $_SESSION['computername'] = $compname2;
  $Estado1 = $_POST['Estado'];
  $Estado2 = strtolower($Estado1);
  $Estado = ucwords($Estado2);
  $_SESSION['estado']  = $Estado;
  $Descripcion1 = $_POST['Descripcion'];
  $Descripcion2 = strtolower($Descripcion1);
  $Descripcion = ucfirst($Descripcion2);
  $_SESSION['descripcion']  = $Descripcion;
  $Avon1 = $_POST['Avon'];
  $Avon = strtoupper($Avon1);
  $_SESSION['avon']  = $Avon;
  $Ubicacion1 = $_POST['Ubicacion'];
  $Ubicacion2 = strtolower($Ubicacion1);
  $Ubicacion = ucfirst($Ubicacion2);
  $_SESSION['ubicacion']  = $Ubicacion;
  $Usuario1 = $_POST['Usuario'];
  $Usuario2 = strtolower($Usuario1);
  $Usuario = ucwords($Usuario2);
  $_SESSION['usuario']  = $Usuario;
  $_SESSION['compra'] = $_POST['compra'];
  $_SESSION['garantia'] = $_POST['garantia'];

  header("location: ../db/regcontact.php");
}



if (isset($_POST['Enviar'])) {
  date_default_timezone_set('America/Bogota');
  include('../db/conexion.php');
  $id = $_POST['id'];
  $procesador = $_POST['Procesadorname'];
  $ram = $_POST['Ram'];
  $disco = $_POST['Disco'];
  $actualizado = $_SESSION['username'];
  $fecha = date("d-m-Y g:i:s A");

  

  $recordck = "SELECT * FROM $tabla11 WHERE id_glpi='$id'";
  $result = mysqli_query($con, $recordck);
  $chks = mysqli_fetch_array($result);
  $filaas = mysqli_num_rows($result);

  if ($filaas > 0) {
    echo "update".$filaas;
        $query = $con->query("UPDATE $tabla11 SET procesador='$procesador',ram='$ram',disco='$disco' WHERE id_glpi='$id'");
        $_SESSION['message'] = "Se actualizaron los valores: " . $ram ." RAM y ".$disco. " Disco, con exito! los veras en el acta de entrega.";
        header("location: ../db/editarGLPI.php?Editar=$id");
      }else{
        echo "insert".$filaas;
        $query = $con->query("INSERT INTO $tabla11 (procesador,disco,ram,id_glpi) VALUES ('$procesador','$disco','$ram','$id')");
        $_SESSION['message'] = "Se actualizaron los valores: " . $ram ." RAM y ".$disco. " Disco, con exito! los veras en el acta de entrega.";
        header("location: ../db/editarGLPI.php?Editar=$id");
      }
    
 
  
}

?>

<?php

ob_end_flush();

?>

