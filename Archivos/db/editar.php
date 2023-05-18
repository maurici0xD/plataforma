<?php
ob_start();
?>

<?php
session_start();

if (isset($_SESSION['username'])) {
    date_default_timezone_set('America/Bogota');
    $fecha = date("d-m-Y g:i:s A");
    include('conexion.php');


    if (isset($_POST['actualiza-user'])) {
        $id = $_POST['id'];
        $cargo1 = $_POST['cargo'];
        $cargo2 = strtolower($cargo1);
        $cargo = ucwords($cargo2);
        $area1 = $_POST['area'];
        $area2 = strtolower($area1);
        $area = ucwords($area2);
        $cedula = $_POST['cedula'];
        $actualizado = $_SESSION['username'];
        $nombre = $_POST['nombre'];
        $link = $_POST['link'];
        $query = "UPDATE $tabla3 SET cargo='$cargo',area='$area',cedula='$cedula',actualizado='$actualizado',fecha='$fecha' WHERE id='$id'";
        mysqli_query($con, $query) or die("database error:" . mysqli_error($con));

        $_SESSION['message'] = "El usuario " . $nombre . ", Fue actualizado con exito!.";

        header('location: editar.php?Editar=' . $link . '');
    }

    if (isset($_GET['Borrar'])) {

        include('../db/conexion.php');
        $id = $_GET['Borrar'];
        $record = $con->query("SELECT * FROM $tabla2 WHERE id='$id'");
            $n = mysqli_fetch_array($record);
            $id = $n['id'];
            $serial = $n['serial'];
            echo $n;
            $delele = $con->query("DELETE FROM $tabla2 WHERE id='$id'");
            $_SESSION['message'] = "El numero de serie " . $serial . ", fue borrado con exito!";
            header('location: ../db/Equipos.php');
        
    }

    if (isset($_GET['Editar'])) {
        include('conexion.php');
        $id = $_GET['Editar'];
        $update = true;
        $record = $con->query("SELECT * FROM $tabla2 WHERE id='$id'");
        $n = mysqli_fetch_array($record);
        $actaid = $n['id_glpi'];

        $queryvertical = "SELECT * FROM $tabla8 WHERE id_glpi = '$actaid'";
        $resultadovertical = mysqli_query($con, $queryvertical);
        if ($verticalconsulta = $resultadovertical->fetch_assoc()) {
            $verticalestado = $verticalconsulta['estado'];
            $verticalubicacion = $verticalconsulta['ubicacion'];
            $verticalcotizacion = $verticalconsulta['cotizacion'];
        }



        if (mysqli_num_rows($record) == 1) {
            $tipoacta = 'entrega';
            $infoactaquery = "SELECT * FROM $tabla5 WHERE actaid='$actaid' AND tipoacta='$tipoacta'";
            $infoacta = mysqli_query($con, $infoactaquery);

            if (mysqli_num_rows($infoacta) > 0) {
                $info = mysqli_fetch_array($infoacta);

                $tipo = $info['tipo'];
                $maleta = $info['maleta'];
                $guaya = $info['guaya'];
                $tecladoa = $info['teclado'];
                $mousea = $info['mouse'];
                $satechi = $info['satechi'];
                $tecladosn = $info['tecladosn'];
                $mousesn = $info['mousesn'];
                $monitormarca = $info['monitormarca'];
                $monitormodelo = $info['monitormodelo'];
                $otros = $info['otros'];
                $observaciones = $info['observaciones'];
                $cargador = $info['cargador'];
                $cable_lightning = $info['cable_lightning'];
                $base = $info['base'];
            }




            $query2 = "SELECT * FROM $tabla3 WHERE nombrecompleto='$n[usuario]'";
            $resultado2 = mysqli_query($con, $query2);
            if ($fila2 = $resultado2->fetch_assoc()) {
                $usuario = $fila2['nombrecompleto'];
            }

            if (($n['usuario'] == "") || ($n['usuario'] == "Inactivo") || ($n['usuario'] == "Bodega Bogota Bodega Bogota")
                || ($n['usuario'] == "Bodega Medellin Bodega Medellin") || ($n['usuario'] == "Para asignar Para asignar")
                || ($n['usuario'] == "Presentaciones Presentaciones") || ($n['usuario'] == "Puesto Fijo Puesto Fijo")
                || ($n['usuario'] == "tech")
            ) {
                $usuario1 = "no";
                $usuariock = "no";
            } else {
                $usuario1 = $n['usuario'];
                $area = $fila2['area'];
                $cargo = $fila2['cargo'];
                $cedula = $fila2['cedula'];
                $idusuario = $fila2['id'];
                $usuario = $fila2['nombrecompleto'];

                if (($area == "") || ($cargo == "") || ($cedula == "")) {
                    $usuariock = "no validado";
                } else {
                    $usuariock = "validado";
                }
            }



            $id = $n['id'];
            $serial = $n['serial'];
            $Marca = $n['fabricante'];
            $Modelo = $n['modelo'];
            $Procesador = $n['procesador'];
            $Ram = $n['ram'];
            $Disco = $n['disco'];
            $Pantalla = $n['pantalla'];
            $Nombreequipo = $n['nombre'];
            $Estado = $n['estado'];
            $Descripcion = $n['comentarios_glpi'];
            $placa = $n['placa'];
            $Ubicacion = $n['ubicacion'];
            $Usuario = $fila2['nombrecompleto'];
            $actualizado = $_SESSION['username'];
            $fecha = date("d-m-Y g:i:s A");

            if (($Nombreequipo == "")) {
                $nombreequipo = "no";
            } else {
                $nombreequipo = "si";
            }

            if (($Pantalla == "")) {
                $monitor = "no";
            } else {
                $monitor = "si";
            }
        }
    }


} else {
    header("location: ../usr/login.php");
}

?>

<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../Login/favicon.png">
    <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/jquery-ui-git.css">

    <title>IT DDB - Editar equipo</title>
</head>

<body>
    <form method="post" action="../consultas/proedit.php">
        <div class="text-center mb-4">
            <img class="mb-1" src="../../Archivos/Login/logo-DDB.png" alt="" width="60" height="110">
            <h1 class="h3 mb-3 font-weight-normal">Actualizar Informacion</h1>
        </div>

        <div class="row g-3">

            <div class="form-group col-md-9 offset-md-2 ">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class='btn btn-outline-warning' href="../db/Equipos.php">Volver</a>
                    <a class='btn btn-outline-dark' href="../../index.php">Home</a>
                </div>

                <?php if (isset($_SESSION['message'])) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo "" . $_SESSION['message'] . ""; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        </button>
                    </div>
                <?php unset($_SESSION['message']);
                endif ?>
            </div>



            <div class="form-floating col-md-3 offset-md-2">
                <input type="hidden" name="id" value="<?php echo $id; ?>">

                <input id="seriali" class="form-control" placeholder="Ingrese el serial" name="Serial" value="<?php if (isset($_SESSION['serial'])) {
                                                                                                                    echo $_SESSION['serial'];
                                                                                                                    unset($_SESSION['serial']);
                                                                                                                } else {
                                                                                                                    echo $serial;
                                                                                                                } ?>" required <?php if ($_SESSION['permisos'] == 'admin') {
                                                                                                                                    echo 'autofocus';
                                                                                                                                } else {
                                                                                                                                    echo 'autofocus';
                                                                                                                                } ?>>
                <label for="seriali">Numero de Serie</label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" name="Marca" id="marcai" class="form-control" placeholder="Marca" value="<?php if (isset($_SESSION['marca'])) {
                                                                                                                echo $_SESSION['marca'];
                                                                                                                unset($_SESSION['marca']);
                                                                                                            } else {
                                                                                                                echo $Marca;
                                                                                                            } ?>" required>
                <label for="marcai">Marca</label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" name="Modelo" id="modeli" class="form-control" placeholder="Modelo" value="<?php if (isset($_SESSION['modelo'])) {
                                                                                                                    echo $_SESSION['modelo'];
                                                                                                                    unset($_SESSION['modelo']);
                                                                                                                } else {
                                                                                                                    echo $Modelo;
                                                                                                                } ?>" required>
                <label for="modeli">Modelo</label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" name="placa" id="codii" class="form-control" placeholder="Placa" value="<?php if (isset($_SESSION['placa'])) {
                                                                                                                echo $_SESSION['placa'];
                                                                                                                unset($_SESSION['placa']);
                                                                                                            } else {
                                                                                                                echo $placa;
                                                                                                            } ?>" required>

                <label for="codii">Placa</label>
            </div>

            <div class="form-floating col-md-1 offset-md-1"></div>
            <div class="form-floating col-md-2">
                <select class="form-control" id="procesador" name="Procesadorname" aria-describedby="procesadorid" required>
                    <option><?php if (isset($_SESSION['procesador'])) {
                                echo $_SESSION['procesador'];
                                unset($_SESSION['procesador']);
                            } else {
                                echo $Procesador;
                            } ?>
                        <?php $sql = "SELECT DISTINCT procesador FROM $tabla2 ORDER BY procesador ASC";
                        $res = mysqli_query($con, $sql);
                        while ($row = $res->fetch_array()) {
                            echo "<option>";
                            echo $row['procesador'];
                            echo "</option>";
                        } ?>
                </select>
                <label for="procesador">Procesador</label>
            </div>


            <div class="form-floating col-md-1">
                <select class="form-control" id="rami" name="Ram" aria-describedby="ramid" required>
                    <option><?php if (isset($_SESSION['Ram'])) {
                                echo $_SESSION['Ram'];
                                unset($_SESSION['Ram']);
                            } else {
                                echo $Ram;
                            } ?></option>
                    <option>1 GB</option>
                    <option>1.5 GB</option>
                    <option>2 GB</option>
                    <option>2.5 GB</option>
                    <option>3 GB</option>
                    <option>3.5 GB</option>
                    <option>4 GB</option>
                    <option>4.5 GB</option>
                    <option>5 GB</option>
                    <option>5.5 GB</option>
                    <option>6 GB</option>
                    <option>6.5 GB</option>
                    <option>7 GB</option>
                    <option>7.5 GB</option>
                    <option>8 GB</option>
                    <option>10 GB</option>
                    <option>12 GB</option>
                    <option>16 GB</option>
                    <option>N/A</option>
                </select>
                <label for="rami">Ram</label>
            </div>

            <div class="form-floating col-md-1">
                <select class="form-control" id="discoi" name="Disco" aria-describedby="discoid" required>
                    <option><?php if (isset($_SESSION['Disco'])) {
                                echo $_SESSION['Disco'];
                                unset($_SESSION['Disco']);
                            } else {
                                echo $Disco;
                            } ?></option>
                    <option>40 GB</option>
                    <option>60 GB</option>
                    <option>80 GB</option>
                    <option>120 GB</option>
                    <option>160 GB</option>
                    <option>250 GB</option>
                    <option>320 GB</option>
                    <option>400 GB</option>
                    <option>500 GB</option>
                    <option>720 GB</option>
                    <option>1 TB</option>
                    <option>1.5 TB</option>
                    <option>2 TB</option>
                    <option>N/A</option>
                </select>
                <label for="discoi">Disco</label>
            </div>

            <div class="form-floating col-md-2">
                <select class="form-control" id="estadoi" name="Estado" aria-describedby="estadoid" required>
                    <option><?php if (isset($_SESSION['estado'])) {
                                echo $_SESSION['estado'];
                                unset($_SESSION['estado']);
                            } else {
                                echo $Estado;
                            } ?></option>
                    <option>Activo</option>
                    <option>Activos Lenovo</option>
                    <option>Inactivo</option>
                </select>
                <label for="estadoi">Estado</label>
            </div>




            <div class="form-floating col-md-2">
                <input type="text" name="pantallaserial" id="pantalla" class="form-control" placeholder="Serial Pantalla" value="<?php if (isset($_SESSION['pantallaserial'])) {
                                                                                                                                        echo $_SESSION['pantallaserial'];
                                                                                                                                        unset($_SESSION['pantallaserial']);
                                                                                                                                    } else {
                                                                                                                                        echo $Pantalla;
                                                                                                                                    } ?>" aria-describedby="pantallaid">
                <label for="pantalla">Serial Pantalla</label>
            </div>

            <div class="form-floating col-md-2 offset-md-3">

                <input type="text" name="computername" id="pcname" class="form-control" placeholder="Nombre de equipo" value="<?php if (isset($_SESSION['computername'])) {
                                                                                                                                    echo $_SESSION['computername'];
                                                                                                                                    unset($_SESSION['computername']);
                                                                                                                                } else {
                                                                                                                                    echo $Nombreequipo;
                                                                                                                                } ?>" aria-describedby="computerid">
                <label for="pcname">Nombre de equipo</label>
            </div>

            <div class="form-floating col-md-1 ">
                <select class="form-control" id="ubii" name="Ubicacion" aria-describedby="ubicacionid" required>
                    <option><?php if (isset($_SESSION['ubicacion'])) {
                                echo $_SESSION['ubicacion'];
                                unset($_SESSION['ubicacion']);
                            } else {
                                echo $Ubicacion;
                            } ?></option>
                    <?php $sql = "SELECT * FROM $tabla4";
                    $res = mysqli_query($con, $sql);
                    while ($row = $res->fetch_array()) {
                        echo "<option>";
                        echo $row['ubicacion'];
                        echo "</option>";
                    } ?>
                </select>
                <label for="ubii">Ubicacion</label>
            </div>




            <div class="form-floating col-md-2">
                <input type="text" name="Usuario" id="lastuser" class="form-control" placeholder="Asignado a:" value="<?php if (isset($_SESSION['nedit'])) {
                                                                                                                            echo $_SESSION['nedit'];
                                                                                                                            unset($_SESSION['nedit']);
                                                                                                                        } else {
                                                                                                                            echo $Usuario;
                                                                                                                        } ?>" required>
                <label for="lastuser">Asignado a:</label>
            </div>

            <div class="form-floating col-md-7 offset-md-2">
                <textarea class="form-control" style="height: 200px" name="Descripcion" id="descrii" placeholder="Descripcion" required><?php if (isset($_SESSION['descripcion'])) {
                                                                                                                                            echo $_SESSION['descripcion'];
                                                                                                                                            unset($_SESSION['descripcion']);
                                                                                                                                        } else {
                                                                                                                                            echo $Descripcion;
                                                                                                                                        } ?></textarea>
                <label for="descrii">Comentarios GLPI</label>
            </div>
            
            <div class="row g-3 content-center">    
                <h3 class="text-center">Reparacion o Garantia</h3>
            <div class="form-floating col-md-2 ">
                <select class="form-control" id="verticalestadoid" name="verticalestado" required>
                    <option><?php if (isset($_SESSION['verticalestado'])) {
                                echo $_SESSION['verticalestado'];
                                unset($_SESSION['verticalestado']);
                            } else {
                                echo $verticalestado;
                            } ?></option>
                    <?php $sql = "SELECT * FROM $tabla9";
                    $res = mysqli_query($con, $sql);
                    while ($row = $res->fetch_array()) {
                        echo "<option>";
                        echo $row['estado'];
                        echo "</option>";
                    } ?>
                </select>
                <label for="verticalestadoid">Estado Vertical</label>
            </div>

            <div class="form-floating col-md-2 ">
                <select class="form-control" id="verticalubicacionid" name="verticalubicacion" required>
                    <option><?php if (isset($_SESSION['verticalubicacion'])) {
                                echo $_SESSION['verticalubicacion'];
                                unset($_SESSION['verticalubicacion']);
                            } else {
                                echo $verticalestado;
                            } ?></option>
                    <?php $sql = "SELECT * FROM $tabla10";
                    $res = mysqli_query($con, $sql);
                    while ($row = $res->fetch_array()) {
                        echo "<option>";
                        echo $row['ubicacion'];
                        echo "</option>";
                    } ?>
                </select>
                <label for="verticalubicacionid">Ubicacion o proveedor</label>
            </div>

            </div>


            <div class="form col-md-4 offset-md-2">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <?php if ($usuariock === "no validado") {
                        $valida = "updateuser";
                    } else {
                        if ($nombreequipo === "no") {
                            $valida = "nonamepc";
                        } else {
                            if ($usuario1 === "no") {
                                $valida = "nouser";
                            } else {
                                $valida = "allinfo";
                            }
                        }
                    } ?>
                    <?php if (isset($_SESSION['nouser'])) : ?>
                        <button type="submit" name="reguser" class="btn btn-success">Registrar Usuario</button>
                        <a class='btn btn-outline-dark' href="../../index.php">Cancelar</a>
                    <?php unset($_SESSION['nouser']);
                    else : ?>
                        <?php if (isset($_SESSION['postreg'])) : ?>
                            <a class="btn btn-dark" href="" data-bs-toggle="modal" data-bs-target="#<?php echo $valida; ?>">Generar Acta</a>
                            <a class='btn btn-outline-dark' href="../../index.php">Finalizar</a>
                        <?php unset($_SESSION['postreg']);
                        else : ?>
                            <button type="submit" name="Enviar" class="btn btn-warning">Actualizar Informacion</button>
                            <a class='btn btn-dark' href="../../index.php">Cancelar</a>
                        <?php endif ?>
                    <?php endif ?>
                    <a class="btn btn-outline-dark" href="" data-bs-toggle="modal" data-bs-target="#<?php echo $valida; ?>">Generar Acta</a>
                </div>
            </div>


        </div>
    </form>

    <div class='modal fade' id='allinfo' tabindex='-1' role='dialog' aria-hidden='true'>
        <div class='modal-dialog modal-lg' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='allinfotittle'>Completar informacion</h5>
                </div>
                <div class='modal-body'>
                    <p>Revise, complete y actualice la informacion para generar el acta. Al generar el acta esta informacion quedara almacenada.</p>
                    <form method="post" action="../Generar-Acta/actaentrega.php" enctype="multipart/form-data">

                        <div class="row g-2">

                            <div>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="tipo" name="tipopc" aria-describedby="tipoid" required>
                                        <?php if (isset($tipo)) {
                                            echo '<option>';
                                            echo $tipo;
                                            echo '</option>';
                                            if ($tipo == "Desktop") {
                                                echo '<option>Laptop</option>';
                                            } else {
                                                echo '<option>Desktop</option>';
                                            }
                                        } else {
                                            echo '<option>Desktop</option>';
                                            echo '<option>Laptop</option>';
                                        } ?>
                                    </select>
                                    <label for="tipo">Equipo Entregado</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="bagig" name="bag" aria-describedby="baglid" required>
                                        <?php if (isset($maleta)) {
                                            echo '<option>';
                                            echo $maleta;
                                            echo '</option>';
                                            if ($maleta == "Si") {
                                                echo '<option>No</option>';
                                            } else {
                                                echo '<option>Si</option>';
                                            }
                                        } else {
                                            echo '<option>No</option>';
                                            echo '<option>Si</option>';
                                        } ?>

                                    </select>
                                    <label for="bagig">Maleta</label>
                                </div>
                            </div>


                            <div class="form-floating col-md-2">
                                <select class="form-control form-control-sm" id="guayaid" name="guaya" aria-describedby="guayalid" required>
                                    <?php if (isset($guaya)) {
                                        echo '<option>';
                                        echo $guaya;
                                        echo '</option>';
                                        if ($guaya == "Si") {
                                            echo '<option>No</option>';
                                        } else {
                                            echo '<option>Si</option>';
                                        }
                                    } else {
                                        echo '<option>No</option>';
                                        echo '<option>Si</option>';
                                    } ?>
                                </select>
                                <label for="guayaid">Guaya</label>
                            </div>

                            <div class="form-floating col-md-2">
                                <select class="form-control" id="satechiid" name="satechi" aria-describedby="satechilid" required>
                                    <?php if (isset($satechi)) {
                                        echo '<option>';
                                        echo $satechi;
                                        echo '</option>';
                                        if ($satechi == "Si") {
                                            echo '<option>No</option>';
                                        } else {
                                            echo '<option>Si</option>';
                                        }
                                    } else {
                                        echo '<option>No</option>';
                                        echo '<option>Si</option>';
                                    } ?>
                                </select>
                                <label for="satechiid">Satechi</label>
                            </div>

                            <div class="form-floating col-md-2">
                                <select class="form-control" id="tecladoid" name="teclado" aria-describedby="tecladolid" required>
                                    <?php if (isset($tecladoa)) {
                                        echo '<option>';
                                        echo $tecladoa;
                                        echo '</option>';
                                        if ($tecladoa == "Si") {
                                            echo '<option>No</option>';
                                        } else {
                                            echo '<option>Si</option>';
                                        }
                                    } else {
                                        echo '<option>No</option>';
                                        echo '<option>Si</option>';
                                    } ?>
                                </select>
                                <label for="tecladoid">Teclado</label>
                            </div>



                            <div class="form-floating col-md-2">
                                <select class="form-control" id="mouseid" name="mouse" aria-describedby="mouselid" required>
                                    <?php if (isset($mousea)) {
                                        echo '<option>';
                                        echo $mousea;
                                        echo '</option>';
                                        if ($mousea == "Si") {
                                            echo '<option>No</option>';
                                        } else {
                                            echo '<option>Si</option>';
                                        }
                                    } else {
                                        echo '<option>No</option>';
                                        echo '<option>Si</option>';
                                    } ?>
                                </select>
                                <label for="mouseid">Mouse</label>
                            </div>
                            <div class="form-floating col-md-3">
                                <select class="form-control" id="baseid" name="base" required>
                                    <?php if (isset($base)) {
                                        echo '<option>';
                                        echo $base;
                                        echo '</option>';
                                        if ($base == "Si") {
                                            echo '<option>No</option>';
                                        } else {
                                            echo '<option>Si</option>';
                                        }
                                    } else {
                                        echo '<option>No</option>';
                                        echo '<option>Si</option>';
                                    } ?>
                                </select>
                                <label for="baseid">Base refrigerante</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="cargadorid" name="cargador" required>
                                        <?php if (isset($cargador)) {
                                            echo '<option>';
                                            echo $cargador;
                                            echo '</option>';
                                            echo '<option>No</option>';
                                            echo '<option>67 Watts</option>';
                                            echo '<option>61 Watts</option>';
                                            echo '<option>45 Watts</option>';
                                            echo '<option>original</option>';
                                        } else {
                                            echo '<option>No</option>';
                                            echo '<option>67 Watts</option>';
                                            echo '<option>61 Watts</option>';
                                            echo '<option>45 Watts</option>';
                                            echo '<option>original</option>';
                                        } ?>

                                    </select>
                                    <label for="cargadorid">Cargador</label>
                                </div>
                            </div>

                            <div class="form-floating col-md-3">
                                <select class="form-control" id="cableid" name="cable" required>
                                    <?php if (isset($cable)) {
                                        echo '<option>';
                                        echo $cable;
                                        echo '</option>';
                                        if ($cable == "Si") {
                                            echo '<option>No</option>';
                                        } else {
                                            echo '<option>Si</option>';
                                        }
                                    } else {
                                        echo '<option>No</option>';
                                        echo '<option>Si</option>';
                                    } ?>
                                </select>
                                <label for="cableid">Cable lightning</label>
                            </div>

                            <div class="form-floating col-md-3">
                                <input type="text" id="stecladoid" class="form-control" placeholder="Serial del teclado" name="steclado" value="<?php if (isset($tecladosn)) {
                                                                                                                                                    echo $tecladosn;
                                                                                                                                                } ?>">
                                <label for="stecladoid">Serial del teclado</label>
                            </div>

                            <div class="form-floating col-md-3">
                                <input type="text" id="smouseid" class="form-control" placeholder="Serial del mouse" name="smouse" value="<?php if (isset($mousesn)) {
                                                                                                                                                echo $mousesn;
                                                                                                                                            } ?>">
                                <label for="smouseid">Serial del mouse</label>
                            </div>

                            <div class="form-floating col-md-3">
                                <input type="text" id="monitorid" class="form-control" placeholder="Marca monitor" name="monitor" <?php if ($monitor === "no") :  ?>disabled<?php endif; ?> value="<?php if ($monitor === "no") {
                                                                                                                                                                                                        echo '';
                                                                                                                                                                                                    } else {
                                                                                                                                                                                                        if (isset($monitormarca)) {
                                                                                                                                                                                                            echo $monitormarca;
                                                                                                                                                                                                        }
                                                                                                                                                                                                    } ?>" required>
                                <label for="monitorid">Marca monitor</label>
                                <?php if ($monitor === "no") :  ?>
                                    <small class='form-text text-muted'>Monitor no registrado</small>
                                <?php endif; ?>
                                <?php if ($monitor === "si") :  ?>
                                    <small class='form-text text-muted'>S/N: <?php echo "$Pantalla"; ?></small>
                                <?php endif; ?>
                            </div>


                            <div class="form-floating col-md-3">
                                <input name="modelo" id="modeloid" class="form-control" placeholder="Modelo del monitor" <?php if ($monitor === "no") :  ?>disabled<?php endif; ?> value="<?php if ($monitor === "no") {
                                                                                                                                                                                                echo '';
                                                                                                                                                                                            } else {
                                                                                                                                                                                                if (isset($monitormodelo)) {
                                                                                                                                                                                                    echo $monitormodelo;
                                                                                                                                                                                                }
                                                                                                                                                                                            } ?>" required>
                                <label for="modeloid">Modelo del monitor</label>
                            </div>

                            <?php if ($monitor === "no") :  ?>
                                <div>
                                    <input type="hidden" name="monitor" value="">
                                    <input type="hidden" name="modelo" value="">
                                </div>
                            <?php endif; ?>


                            <div class="form-floating col-md-6">
                                <input type="text" id="otrosid" class="form-control" placeholder="Otros:" name="otros" value="<?php if (isset($otros)) {
                                                                                                                                    echo $otros;
                                                                                                                                } ?>">
                                <label for="otrosid">Otros:</label>
                            </div>

                            <div class="form-floating col-md-6">
                                <textarea class="form-control" style="height: 100px" name="observaciones" id="observacionesid" placeholder="Observaciones" value="<?php if (isset($observaciones)) {
                                                                                                                                                                        echo $observaciones;
                                                                                                                                                                    } ?>"></textarea>
                                <label for="observacionesid">Observaciones:</label>
                            </div>






                        </div>

                        <div class='modal-footer'>
                            <button type="submit" name="generaractaeditar" class="btn btn-warning">Generar acta entrega</button>
                            <a class='btn btn-outline-dark' href="../Generar-Acta/actaretiro.php?id=<?php echo $actaid; ?>">Generar acta retiro</a>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class='modal fade' id='updateuser' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='updateuserid'>Actualizar usuario</h5>
                </div>
                <div class='modal-body'>
                    Para generar el acta, debe registrar la siguiente información del usuario <?php echo "$usuario"; ?> :
                    <form method="POST" enctype="multipart/form-data">
                        <div>
                            <input type="hidden" name="id" value="<?php echo $idusuario; ?>">
                        </div>

                        <div>
                            <input type="hidden" name="nombre" value="<?php echo $usuario; ?>">
                        </div>

                        <div>
                            <input type="hidden" name="link" value="<?php echo $id; ?>">
                        </div>

                        <div class="form-label-group">
                            <input type="text" id="cargoid" class="form-control" placeholder="Cargo:" name="cargo" value="<?php echo $cargo; ?>" required>
                            <label for="cargoid">Cargo:</label>
                        </div>

                        <div class="form-label-group">
                            <input type="text" id="areaid" class="form-control" placeholder="Area:" name="area" value="<?php echo $area; ?>" required>
                            <label for="areaid">Area:</label>
                        </div>

                        <div class="form-label-group">
                            <input type="text" id="cedulaid" class="form-control" placeholder="Cedula:" name="cedula" value="<?php echo $cedula; ?>" required>
                            <label for="cedulaid">Cedula:</label>
                        </div>


                        <div class='modal-footer'>
                            <button type="submit" name="actualiza-user" class="btn btn-warning">Actualizar información</button>
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='nouser' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='nouserid'>Usuario no registrado</h5>
                </div>
                <div class='modal-body'>
                    El serial <?php echo "$serial"; ?>, no tiene ningún usuario registrado. Es necesario registrarlo para generar el acta.
                    Tener en cuenta que el nombre de equipo también es requerido.


                    <div class='modal-footer'>
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Editar información de equipo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='nonamepc' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='nonamepcid'>Nombre de equipo requerido</h5>
                </div>
                <div class='modal-body'>
                    El serial <?php echo "$serial"; ?>, no tiene nombre de equipo registrado. Es necesario registrarlo para generar el acta.


                    <div class='modal-footer'>
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Editar información de equipo</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="../js/jquery-ui-git.js"></script>
    <?php

    if ($usuario1 === "no") {
        echo '<script>
$(document).ready(function()
{

  $("#nouser").modal("show");
});
</script>';
    }

    if ($nombreequipo === "no") {
        echo '<script>
$(document).ready(function()
{

  $("#nonamepc").modal("show");
});
</script>';
    }

    ?>

    <script>
        $(document).ready(function() {

            $('#lastuser').autocomplete({

                source: function(request, response) {

                    $.ajax({

                        url: "atname.php",

                        dataType: "json",

                        data: {
                            q: request.term
                        },

                        success: function(data) {

                            response(data);

                        }

                    });

                },

                minLength: 1,

                select: function(event, ui) {


                }

            });

        });
    </script>
</body>

</html>


<?php

ob_end_flush();

?>