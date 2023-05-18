<?php
ob_start();
?>
        
    <?php


    session_start();
    if (isset($_SESSION['username'])) {
        date_default_timezone_set('America/Bogota');
        $fecha = date("d-m-Y g:i:s A");
        include('../db/conexion.php');

        if ((isset($_GET['mostrar'])) || (isset($_GET['Borrar'])) || (isset($_POST['Subir']))) {
            if (isset($_GET['mostrar'])) {
                $id = $_GET['mostrar'];
                $query = "SELECT * FROM $tabla1 WHERE id='$id' ";
                $resultado = mysqli_query($con, $query);

                if ($fila = $resultado->fetch_assoc()) {

                    if (($fila['acta'] == "") || ($fila['acta'] == "No hay acta")) {
                        $_SESSION['message'] = "El numero de serie " . $fila['nserial'] . ", no tiene actas registradas.";

                        if ($_SESSION['permisos'] == "admin") {
                            header("location: ../controlpanel.php");
                        } else {
                            header("location: ../index.php");
                        }
                    } else {
                        header('content-type: application/pdf');
                        readfile('../actas/' . $fila['acta']);
                    }
                }
            }

            if (isset($_GET['Borrar'])) {
                $id = $_GET['Borrar'];
                $query = "SELECT * FROM $tabla1 WHERE id='$id' ";
                $resultado = mysqli_query($con, $query);

                if ($fila = $resultado->fetch_assoc()) {
                    $actatodel = $fila['acta'];
                    $serial1 = $fila['nserial'];
                    $Marca1 = $fila['Marcab'];
                    $Modelo1 = $fila['Modelob'];
                    $Estado1 = $fila['Estadob'];
                    $Descripcion1 = $fila['Descripcionb'];
                    $Avon1 = $fila['Codigo'];
                    $Ubicacion1 = $fila['Ubicacionb'];
                    $Usuario1 = $fila['Ultb'];
                    $actualizado1 = $_SESSION['username'];
                    $procesador = $fila['procesador'];
                    $ram = $fila['ram'];
                    $disco = $fila['disco'];
                    $cargador = $fila['cargador'];
                    $pantalla = $fila['pantalla'];
                    $nombreequipo = $fila['nombreequipo'];
                    $compra = $fila['compra'];
                    $garantia = $fila['garantia'];

                    $con->query("INSERT INTO $tabla4 (nserial,Marcab,Modelob,Descripcionb,Estadob,Codigo,Ubicacionb,Ultb,Actualizadob,ultact,upres,fpres,fdel,epres,operacion,procesador,ram,disco,cargador,pantalla,nombreequipo,compra,garantia) VALUES ('$serial1','$Marca1','$Modelo1','$Descripcion1','$Estado1','$Avon1','$Ubicacion1','$Usuario1','$actualizado1','$fecha','Sin datos','Sin datos','Sin datos','Sin datos','Acta Borrada','$procesador','$ram','$disco','$cargador','$pantalla','$nombreequipo','$compra','$garantia')");
                    $query = $con->query("UPDATE $tabla1 SET Actualizadob='$actualizado1',ultact='$fecha',acta='No hay acta' WHERE id='$id'");

                    unlink('../actas/' . $actatodel);
                    $_SESSION['message'] = "El acta del serial " . $serial1 . ", fue borrada exitosamente!.";

                    header("location: ../db/consultaymodifica.php");
                }
            }

            if (isset($_POST['Subir'])) {
                $id = $_POST['id'];
                $query = "SELECT * FROM $tabla2 WHERE id_glpi='$id' ";
                $resultado = mysqli_query($con, $query);
                $actallega = $_FILES['acta']['name'];
                $actatipo = $_FILES['acta']['type'];

                if ($fila = $resultado->fetch_assoc()) {
                    $serial1 = $fila['serial'];
                    $fechapdf = date("d-m-y_h-i-s-A");
                }

                if (($actatipo == "application/pdf") || ($actatipo == "")) {
                    $dir_subida = '../Actas/Cotizaciones/';
                    $fichero_subido = $dir_subida . basename($_FILES['acta']['name']);
                    move_uploaded_file($_FILES['acta']['tmp_name'], $fichero_subido);
                    $newname = "Cotizacion-" . $serial1 . "_" . $fechapdf . ".pdf";
                    rename($fichero_subido, $dir_subida . $newname);
                    $acta = $newname;

                    if ($actallega == "") {
                        $acta = "No hay acta";
                    }

                    $sql_query = "SELECT * FROM $tabla8 WHERE id_glpi='$id'";
                    $resultset = mysqli_query($con, $sql_query) or die("database error:" . mysqli_error($con));
                    if (mysqli_num_rows($resultset)) {
                        $query = $con->query("UPDATE $tabla8 SET cotizacion='$actallega' WHERE id_glpi='$id'");
                        $_SESSION['message'] = "El acta del serial " . $serial1 . ", fue subida exitosamente!.";
                        header("location: ../db/Equipos.php");
                    }else{
                        $con->query("INSERT INTO $tabla8 (id_glpi,estado,ubicacion,cotizacion) VALUES ('$id','','','$acta')");
                        $_SESSION['message'] = "El acta del serial " . $serial1 . ", fue subida exitosamente!.";
                        header("location: ../db/Equipos.php");
                    }
                    
                } else {
                    $_SESSION['message'] = "El archivo " . $_FILES['acta']['name'] . " no es pdf.";
                    header("location: ../db/consultaymodifica.php");
                }
            }
        } else {
            header("location: ../../index.php");
        }
    } else {
        header("location: ../usr/login.php");
    }
    ?>
                                        
                                      
  <?php

    ob_end_flush();

    ?>
