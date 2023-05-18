<?php
ob_start();
?>

<?php
session_start();
if (isset($_SESSION['username'])) {
    date_default_timezone_set('America/Bogota');
    $fecha = date("d-m-Y g:i:s A");
    include('conexion.php');
    //include('../db/conexionGLPI.php');
    $actualizado = $_SESSION['username'];


    if (isset($_POST['import_GLPI'])) {
        $queryglpi = "SELECT * FROM $tablaequipos ";
        $resultadoglpi = mysqli_query($conglpi, $queryglpi);
        while ($filaglpi = $resultadoglpi->fetch_assoc()) {
            $serialglpi = $filaglpi['serial'];
            $idglpi = $filaglpi['id'];
            $ubicacionglpi = $filaglpi['locations_id'];
            $locationtrad = mysqli_query($conglpi, "SELECT * FROM $tablaubicaciones WHERE id='$ubicacionglpi'");
            $resultadoubicacion = $locationtrad->fetch_assoc();
            $ubicaciontraducida = $resultadoubicacion['completename'];
            $modeloglpi = $filaglpi['computermodels_id'];
            $modelotrad = mysqli_query($conglpi, "SELECT * FROM $tablamodelos WHERE id='$modeloglpi'");
            $resultadomodelo = $modelotrad->fetch_assoc();
            $modelotraducido = $resultadomodelo['name'];
            $marcaglpi = $filaglpi['manufacturers_id'];
            $marcatrad = mysqli_query($conglpi, "SELECT * FROM $tablamarca WHERE id='$marcaglpi'");
            $resultadomarca = $marcatrad->fetch_assoc();
            $marcatraducida = $resultadomarca['name'];
            $yeartrad = mysqli_query($conglpi, "SELECT * FROM $tablayear WHERE items_id='$idglpi'");
            $resultadoyear = $yeartrad->fetch_assoc();
            $yeartraducido = $resultadoyear['aofield'];
            $usuarioglpi = $filaglpi['users_id'];
            $grupoglpi = $filaglpi['grous_id'];
            $estadoglpi = $filaglpi['states_id'];
            $estadotrad = mysqli_query($conglpi, "SELECT * FROM $tablaestados WHERE id='$estadoglpi'");
            $resultadoestado = $estadotrad->fetch_assoc();
            $estadotraducido = $resultadoestado['aofield'];
            $comentariosglpi = $filaglpi['comment'];
            $actualizacionglpi = $filaglpi['date_mod'];
            $placa = $filaglpi['otherserial'];
            $nombre = $filaglpi['name'];
        }

    }


    if (isset($_POST['import_equipos2'])) {
        $insertados = 0;
        $Actualizados = 0;
        // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                ini_set('auto_detect_line_endings', TRUE);
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                //fgetcsv($csv_file);
                // get data records from csv file
                while (($computer_records = fgetcsv($csv_file, 0, ';')) !== FALSE) {
                    // Check if employee already exists with same email
                    $rows[] = $computer_records;
                }

                unset($rows[0]);
                $total = count($rows);

                foreach ($rows as $computer_record){
                    $serial = $computer_record[2];
                    $placa = $computer_record[3];
                    $nombre = $computer_record[0];
                    $estado = $computer_record[4];
                    $usuario = $computer_record[5];
                    $fabricante = $computer_record[6];
                    $tipo = $computer_record[7];
                    $modelo = $computer_record[8];
                    $ubicacion = $computer_record[9];
                    $modificacion = $computer_record[10];
                    $grupo = $computer_record[11];
                    $year = $computer_record[12];
                    $sistema_nombre = $computer_record[13];
                    $sistema_version = $computer_record[14];
                    $procesador = $computer_record[15];
                    $ram = $computer_record[16];
                    $ram_tipo = $computer_record[17];
                    $disco_tipo = $computer_record[18];
                    $disco = $computer_record[19];
                    $comentarios_glpi = $computer_record[20];
                    $id_glpi = $computer_record[21];
                    $sql_query = "SELECT * FROM $tabla2 WHERE serial='$serial'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                    // if employee already exist then update details otherwise insert new record
                    if (mysqli_num_rows($resultset)) {
                        $Actualizados = $Actualizados + 1;
                        $sql_update = "UPDATE $tabla2 set placa='$placa', nombre='$nombre', estado='$estado' , usuario='$usuario', fabricante='$fabricante', tipo='$tipo', modelo='$modelo'
, ubicacion='$ubicacion', modificacion='$modificacion', grupo='$grupo', year='$year', sistema_nombre='$sistema_nombre', sistema_version='$sistema_version', procesador='$procesador'
, ram='$ram', ram_tipo='$ram_tipo', disco_tipo='$disco_tipo', disco='$disco', comentarios_glpi='$comentarios_glpi', acta='$id_glpi' WHERE serial = '$serial'";
                        mysqli_query($con, $sql_update) or die("database error:" . mysqli_error($con));
                    } else {
                        $sql = "INSERT INTO $tabla2 (serial,placa,nombre,estado,usuario,fabricante,tipo,modelo,ubicacion,modificacion,grupo,year,sistema_nombre,sistema_version,procesador,ram,ram_tipo,disco_tipo,disco,comentarios_glpi,id_glpi,pantalla,acta,quienactualiza,fecha)VALUES('$serial','$placa','$nombre','$estado','$usuario','$fabricante','$tipo','$modelo','$ubicacion','$modificacion','$grupo','$year','$sistema_nombre','$sistema_version','$procesador','$ram','$ram_tipo','$disco_tipo','$disco','$comentarios_glpi','$id_glpi','','','','')";
                        $resultado = $con->query($sql);
                        $insertados = $insertados + 1;
                    }


                }


                echo "Actualizados son " . $Actualizados;
                echo "insertados son " . $insertados;
                echo "Total" . $insertados + $Actualizados;
                ini_set('auto_detect_line_endings', FALSE);
                fclose($csv_file);
                $import_status = '?import_status=success';
            } else {
                $import_status = '?import_status=error';
            }
        } else {
            $import_status = '?import_status=invalid_file';
            echo "archivo invalido";
        }
    }








    if (isset($_POST['import_equipos'])) {
        $actualizados = 0;
        $insertados = 0;
        // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                ini_set('auto_detect_line_endings', TRUE);
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                //fgetcsv($csv_file);
                // get data records from csv file
                while (($computer_record = fgetcsv($csv_file, 0, ';')) !== FALSE) {
                    // Check if employee already exists with same email
                    $serial = $computer_record[2];
                    $placa = $computer_record[3];
                    $nombre = $computer_record[0];
                    $estado = $computer_record[4];
                    $usuario = $computer_record[5];
                    $fabricante = $computer_record[6];
                    $tipo = $computer_record[7];
                    $modelo = $computer_record[8];
                    $ubicacion = $computer_record[9];
                    $modificacion = $computer_record[10];
                    $grupo = $computer_record[11];
                    $year = $computer_record[12];
                    $sistema_nombre = $computer_record[13];
                    $sistema_version = $computer_record[14];
                    $procesador = $computer_record[15];
                    $ram = $computer_record[16];
                    $ram_tipo = $computer_record[17];
                    $disco_tipo = $computer_record[18];
                    $disco = $computer_record[19];
                    $comentarios_glpi = $computer_record[20];
                    $id_glpi = $computer_record[21];
                    $sql_query = "SELECT * FROM $tabla2 WHERE serial='$serial'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                    // if employee already exist then update details otherwise insert new record
                    if (mysqli_num_rows($resultset)) {
                        $Actualizados = $Actualizados + 1;
                        $sql_update = "UPDATE $tabla2 set placa='$placa', nombre='$nombre', estado='$estado' , usuario='$usuario', fabricante='$fabricante', tipo='$tipo', modelo='$modelo'
, ubicacion='$ubicacion', modificacion='$modificacion', grupo='$grupo', year='$year', sistema_nombre='$sistema_nombre', sistema_version='$sistema_version', procesador='$procesador'
, ram='$ram', ram_tipo='$ram_tipo', disco_tipo='$disco_tipo', disco='$disco', comentarios_glpi='$comentarios_glpi', acta='$id_glpi' WHERE serial = '$serial'";
                        mysqli_query($con, $sql_update) or die("database error:" . mysqli_error($con));
                    } else {
                        $sql = "INSERT INTO $tabla2 (serial,placa,nombre,estado,usuario,fabricante,tipo,modelo,ubicacion,modificacion,grupo,year,sistema_nombre,sistema_version,procesador,ram,ram_tipo,disco_tipo,disco,comentarios_glpi,id_glpi,pantalla,acta,quienactualiza,fecha)VALUES('$serial','$placa','$nombre','$estado','$usuario','$fabricante','$tipo','$modelo','$ubicacion','$modificacion','$grupo','$year','$sistema_nombre','$sistema_version','$procesador','$ram','$ram_tipo','$disco_tipo','$disco','$comentarios_glpi','$id_glpi','','','','')";
                        $resultado = $con->query($sql);
                        $insertados = $insertados + 1;
                    }
                }
                echo "Actualizados son " . $Actualizados;
                echo "insertados son " . $insertados;
                echo "Total" . $insertados + $Actualizados;
                ini_set('auto_detect_line_endings', FALSE);
                fclose($csv_file);
                $import_status = '?import_status=success';
            } else {
                $import_status = '?import_status=error';
            }
        } else {
            $import_status = '?import_status=invalid_file';
            echo "archivo invalido";
        }
    }

    if (isset($_POST['import_usuarios'])) {
        $actualizados = 0;
        $insertados = 0;
        // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                ini_set('auto_detect_line_endings', TRUE);
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                //fgetcsv($csv_file);
                // get data records from csv file
                while (($usuarios_records = fgetcsv($csv_file, 0, ';')) !== FALSE) {
                    // Check if employee already exists with same email
                    $rows[] = $usuarios_records;
                }

                unset($rows[0]);
                $total = count($rows);

                foreach ($rows as $usuarios_record){
                    $cedula = $usuarios_record[1];
                    $correo = $usuarios_record[2];
                    $nombre = $usuarios_record[3];
                    $apellido = $usuarios_record[4];
                    $nombrecompleto = $apellido . " " . $nombre;
                    $ubicacion = $usuarios_record[5];
                    $empresa = $usuarios_record[6];
                    $area = $usuarios_record[7];
                    $cargo = $usuarios_record[8];
                    $activado = $usuarios_record[9];
                    $contrato = $usuarios_record[10];
                    $id_glpi = $usuarios_record[11];
                    $sql_query = "SELECT * FROM $tabla3 WHERE cedula='$cedula'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                    // if employee already exist then update details otherwise insert new record
                    if (mysqli_num_rows($resultset)) {
                        $sql_update = "UPDATE $tabla3 set cedula='$cedula', correo='$correo', nombre='$nombre' , apellido='$apellido' , nombrecompleto='$nombrecompleto' , ubicacion='$ubicacion', empresa='$empresa', area='$area', cargo='$cargo'
        , activado='$activado', contrato='$contrato', id_glpi='$id_glpi', actualizado='$actualizado',fecha='$fecha' WHERE cedula = '$cedula'";
                        mysqli_query($con, $sql_update) or die("database error:" . mysqli_error($con));
                        $Actualizados = $Actualizados + 1;
                    } else {
                        $sql = "INSERT INTO $tabla3 (cedula, correo, nombre, apellido, nombrecompleto, ubicacion, empresa, area, cargo, activado, 
        contrato, id_glpi, actualizado, fecha)VALUES('$cedula','$correo','$nombre','$apellido','$nombrecompleto','$ubicacion','$empresa','$area','$cargo','$activado','$contrato',
        '$id_glpi','$actualizado', '$fecha')";
                        $resultado = $con->query($sql);
                        $insertados = $insertados + 1;
                    }
                }
                echo "Actualizados son " . $Actualizados;
                echo "insertados son " . $insertados;
                echo "Total" . $insertados + $Actualizados;
                ini_set('auto_detect_line_endings', FALSE);
                fclose($csv_file);
                $import_status = '?import_status=success';
            } else {
                $import_status = '?import_status=error';
            }
        } else {
            $import_status = '?import_status=invalid_file';
        }
    }

    if (isset($_POST['import_modelos'])) {
        $actualizados = 0;
        $insertados = 0;
        // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                ini_set('auto_detect_line_endings', TRUE);
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                //fgetcsv($csv_file);
                // get data records from csv file
                while (($equipos_record = fgetcsv($csv_file, 0, ';')) !== FALSE) {
                    // Check if employee already exists with same email
                    $modelo_glpi = $equipos_record[0];
                    $modelo = $equipos_record[1];
                    $tipo = $equipos_record[2];
                    $sql_query = "SELECT * FROM $tabla6 WHERE modelo_glpi='$modelo_glpi'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                    // if employee already exist then update details otherwise insert new record
                    if (mysqli_num_rows($resultset)) {
                        $Actualizados = $Actualizados + 1;
                        $sql_update = "UPDATE $tabla6 set modelo_glpi='$modelo_glpi', modelo='$modelo', tipo='$tipo' WHERE modelo_glpi = '$modelo_glpi'";
                        mysqli_query($con, $sql_update) or die("database error:" . mysqli_error($con));
                    } else {
                        $insertados = $insertados + 1;
                        $sql = "INSERT INTO $tabla6 (modelo_glpi, modelo, tipo)VALUES('$modelo_glpi','$modelo','$tipo')";
                        $resultado = $con->query($sql);
                    }
                }
                echo "Actualizados son " . $Actualizados;
                echo "insertados son " . $insertados;
                echo "Total" . $insertados + $Actualizados;
                ini_set('auto_detect_line_endings', FALSE);
                fclose($csv_file);
                $import_status = '?import_status=success';
            } else {
                $import_status = '?import_status=error';
            }
        } else {
            $import_status = '?import_status=invalid_file';
        }
    }

    if (isset($_POST['import_sistema'])) {
        $actualizados = 0;
        $insertados = 0;
        // validate to check uploaded file is a valid csv file
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                ini_set('auto_detect_line_endings', TRUE);
                $csv_file = fopen($_FILES['file']['tmp_name'], 'r');
                //fgetcsv($csv_file);
                // get data records from csv file
                while (($sistema_record = fgetcsv($csv_file, 0, ';')) !== FALSE) {
                    // Check if employee already exists with same email
                    $sistema_glpi = $sistema_record[0];
                    $nombre = $sistema_record[1];
                    $sql_query = "SELECT * FROM $tabla7 WHERE sistema_glpi='$sistema_glpi'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                    // if employee already exist then update details otherwise insert new record
                    if (mysqli_num_rows($resultset)) {
                        $Actualizados = $Actualizados + 1;
                        $sql_update = "UPDATE $tabla7 set sistema_glpi='$sistema_glpi', nombre='$nombre' WHERE sistema_glpi = '$sistema_glpi'";
                        mysqli_query($con, $sql_update) or die("database error:" . mysqli_error($con));
                    } else {
                        $insertados = $insertados + 1;
                        $sql = "INSERT INTO $tabla7 (sistema_glpi, nombre)VALUES('$sistema_glpi','$nombre')";
                        $resultado = $con->query($sql);
                    }
                }
                echo "Actualizados son " . $Actualizados;
                echo "insertados son " . $insertados;
                echo "Total" . $insertados + $Actualizados;
                ini_set('auto_detect_line_endings', FALSE);
                fclose($csv_file);
                $import_status = '?import_status=success';
            } else {
                $import_status = '?import_status=error';
            }
        } else {
            $import_status = '?import_status=invalid_file';
        }
    }
} else {
    header("location: ../usr/login.php");
}
?>
<?php

ob_end_flush();

?>