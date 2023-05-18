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
            $delele = $con->query("DELETE FROM $tabla11 WHERE id_glpi='$id'");
            $_SESSION['message'] = "La informacion de disco, ram y procesador fue borrada con exito!";
            header('location: ../db/editarGLPI.php?Editar='.$id);
        
    }

    if (isset($_GET['Editar'])) {
        include('conexion.php');
        include('../db/conexionGLPI.php');
        $ideditar = $_GET['Editar'];
        $update = true;
        $actaid = $ideditar;

        $queryvertical = "SELECT * FROM $tabla8 WHERE id_glpi = '$actaid'";
        $resultadovertical = mysqli_query($con, $queryvertical);
        if ($verticalconsulta = $resultadovertical->fetch_assoc()) {
            $verticalestado = $verticalconsulta['estado'];
            $verticalubicacion = $verticalconsulta['ubicacion'];
            $verticalcotizacion = $verticalconsulta['cotizacion'];
        }

        $queryglpi = "SELECT 
        glpi.glpi_computers.id as id,
        glpi.glpi_computers.serial as serial,
        glpi.glpi_computers.name as nombre,
        glpi.glpi_computers.otherserial as placa,
        glpi.glpi_computers.comment as descripcion,
        glpi.glpi_computers.date_mod as modificacion,
        glpi.glpi_locations.completename as ubicacion,
        glpi.glpi_manufacturers.name as marca,
        glpi.glpi_computermodels.name as modelo,
        glpi.glpi_plugin_fields_computerpurchases.aofield as year,
        glpi.glpi_plugin_fields_computerpurchases.mantenimientofield as mantenimiento,
        glpi.glpi_states.name as estado,
        glpi.glpi_users.firstname as nombreusuario,
        glpi.glpi_users.realname as apellido,
        glpi.glpi_users.id as idusuario,
        glpi.glpi_groups.completename as grupo,
        glpi.glpi_deviceprocessors.designation as procesador,
        glpi.glpi_items_deviceharddrives.capacity as disco,
        SUM(glpi.glpi_items_devicememories.size) as ram,
        glpi.glpi_operatingsystems.name as sistema,
        glpi.glpi_operatingsystemversions.name as sistemaversion,
        glpi.glpi_plugin_fields_computerperifericosasignados.baseergonomicafield as baseglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.tecladofield as tecladoglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.comentariostecladofield as tecladoserialglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.mousefield as mouseglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.comentariosmousefield as mouseserialglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.adaptadorfield as adaptadorglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.comentariosotrofield as otrosglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.bolsofield as bolsoglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.guayafield as guayaglpi,
        glpi_plugin_fields_cargadorfielddropdowns.completename as cargadorglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.cablelightningfield as cablelightningglpi,
        glpi.glpi_plugin_fields_computerperifericosasignados.serialcargadorfield as serialcargadorglpi
        FROM glpi.glpi_computers
        left join glpi.glpi_locations on glpi_computers.locations_id=glpi_locations.id 
        left join glpi.glpi_manufacturers on glpi_computers.manufacturers_id=glpi_manufacturers.id
        left join glpi.glpi_computermodels on glpi_computers.computermodels_id=glpi_computermodels.id 
        left join glpi.glpi_plugin_fields_computerpurchases on glpi_computers.id=glpi.glpi_plugin_fields_computerpurchases.items_id
        left join glpi.glpi_states on glpi_computers.states_id=glpi_states.id
        left join glpi.glpi_users on glpi_computers.users_id=glpi_users.id
        left join glpi.glpi_groups on glpi_computers.groups_id=glpi_groups.id
        left join glpi.glpi_items_deviceprocessors on glpi_computers.id=glpi.glpi_items_deviceprocessors.items_id
        left join glpi.glpi_deviceprocessors on glpi_deviceprocessors.id=glpi.glpi_items_deviceprocessors.deviceprocessors_id
        left join glpi.glpi_items_deviceharddrives on glpi_computers.id=glpi.glpi_items_deviceharddrives.items_id
        left join glpi.glpi_items_devicememories on glpi_computers.id=glpi.glpi_items_devicememories.items_id
        left join glpi.glpi_items_operatingsystems on glpi_computers.id=glpi.glpi_items_operatingsystems.items_id
        left join glpi.glpi_operatingsystems on glpi.glpi_operatingsystems.id=glpi.glpi_items_operatingsystems.operatingsystems_id
        left join glpi.glpi_operatingsystemversions on glpi.glpi_operatingsystemversions.id=glpi.glpi_items_operatingsystems.operatingsystemversions_id
        left join glpi.glpi_plugin_fields_computerperifericosasignados on glpi.glpi_plugin_fields_computerperifericosasignados.items_id=glpi_computers.id
        left join glpi_plugin_fields_cargadorfielddropdowns on glpi_plugin_fields_cargadorfielddropdowns.id=glpi.glpi_plugin_fields_computerperifericosasignados.plugin_fields_cargadorfielddropdowns_id
        WHERE glpi.glpi_computers.id='$ideditar'";
        $resultadoglpi = mysqli_query($conglpi, $queryglpi);
        
        while ($filaglpi = $resultadoglpi->fetch_assoc()) {
            $serialglpi = $filaglpi['serial'];
            $ubicacionglpi = $filaglpi['ubicacion'];
            $modeloglpi = $filaglpi['modelo'];
            $marcaglpi = $filaglpi['marca'];
            $year = $filaglpi['year'];
            $idusuarioglpi = $filaglpi['idusuario'];
            $usuarioglpi = $filaglpi['nombreusuario'] ." ". $filaglpi['apellido'];
            $grupoglpi = $filaglpi['grupo'];
            $filaglpi['grupo'] = str_replace(' > ', '/', $filaglpi['grupo']);
            //$fila['grupo'] = str_replace(' ','_',$fila['grupo']);
            $estadoglpi = $filaglpi['estado'];
            $comentariosglpi = $filaglpi['descripcion'];
            $actualizacionglpi = $filaglpi['modificacion'];
            $placaglpi = $filaglpi['placa'];
            $nombreglpi = $filaglpi['nombre'];
            $procesadorglpi = $filaglpi['procesador'];
            $discoglpi1 = round($filaglpi['disco']/1000);
            $discoglpi = $discoglpi1." GB";
            $ramglpi1 = round($filaglpi['ram']/1000);
            $ramglpi = $ramglpi1." GB";
            $baseglpi = $filaglpi['baseglpi'];
            $tecladoglpi = $filaglpi['tecladoglpi'];
            $tecladoserialglpi = $filaglpi['tecladoserialglpi'];
            $mouseglpi = $filaglpi['mouseglpi'];
            $mouseserialglpi = $filaglpi['mouseserialglpi'];
            $adaptador = $filaglpi['adaptadorglpi'];
            $otrosglpi = $filaglpi['otrosglpi'];
            $bolsoglpi = $filaglpi['bolsoglpi'];
            $guayaglpi = $filaglpi['guayaglpi'];
            $cargadorglpi = $filaglpi['cargadorglpi'];
            $cablelightningglpi = $filaglpi['cablelightningglpi'];
            $serialcargadorglpi = $filaglpi['serialcargador'];

        
           
            $modelopc = $modeloglpi;
            $querymodelo = "SELECT * FROM $tabla6 WHERE modelo_glpi = '$modelopc'";
            $resultadomodelo = mysqli_query($con, $querymodelo);
            if ($modeloconsulta = $resultadomodelo->fetch_assoc()) {
                $modelotraducido = $modeloconsulta['modelo'];
                $tipopcglpi = $modeloconsulta['tipo'];
            }

        
    }

        if (mysqli_num_rows($resultadoglpi) == 1) {
            $tipoacta = 'entrega';
   
            $query2 = "SELECT glpi.glpi_users.firstname,
            glpi.glpi_users.realname,
            glpi.glpi_users.registration_number as cedula,
            glpi.glpi_usercategories.name as area,
            glpi.glpi_usertitles.name as cargo,
            glpi.glpi_monitors.name as modelomonitor,
            glpi.glpi_monitors.serial as serialmonitor,
            glpi.glpi_manufacturers.name as marcamonitor
            FROM glpi.glpi_users
            left join glpi.glpi_usercategories on glpi_users.usercategories_id=glpi_usercategories.id
            left join glpi.glpi_usertitles on glpi_users.usertitles_id=glpi_usertitles.id
            left join glpi.glpi_monitors on glpi_users.id=glpi_monitors.users_id 
            left join glpi.glpi_manufacturers on glpi.glpi_manufacturers.id=glpi_monitors.manufacturers_id WHERE glpi.glpi_users.id='$idusuarioglpi'";
            $resultado2 = mysqli_query($conglpi, $query2);
            if ($fila2 = $resultado2->fetch_assoc()) {
                $completename = $fila2['firstname']." ".$fila2['realname'];
                $monitorglpiserial = $fila2['serialmonitor'];
          }

            if (($completename == " ") || ($completename == "Inactivo") || ($completename == "Bodega Bogota Bodega Bogota")
                || ($completename == "Bodega Medellin Bodega Medellin") || ($completename == "Para asignar Para asignar")
                || ($completename == "Presentaciones Presentaciones") || ($completename == "Puesto Fijo Puesto Fijo")
                || ($completename == "tech")
            ) {
                $usuario1 = "no";
                $usuariock = "no";
            } else {
                $usuario1 = $completename;
                $area = $fila2['area'];
                $cargo = $fila2['cargo'];
                $cedula = $fila2['cedula'];
                $idusuario = $idusuarioglpi;
                $usuario = $completename;
                

                if (($area == "") || ($cargo == "") || ($cedula == "")) {
                    $usuariock = "no validado";
                } else {
                    $usuariock = "validado";
                }
            }

            $querymonitor = "SELECT 
            glpi.glpi_monitors.name as modelomonitor,
            glpi.glpi_monitors.serial as serialmonitor,
            glpi.glpi_manufacturers.name as marcamonitor
            FROM glpi.glpi_monitors
            left join glpi.glpi_manufacturers on glpi.glpi_manufacturers.id=glpi_monitors.manufacturers_id WHERE glpi_monitors.users_id ='$idusuarioglpi'";


            $actualizado = $_SESSION['username'];
            $fecha = date("d-m-Y g:i:s A");

            if (($nombreglpi == "")) {
                $nombreequipo = "no";
            } else {
                $nombreequipo = "si";
            }

            if (($Pantalla == "")) {
                $monitor = "no";
            } else {
                $monitor = "si";
            }

            $check7 = "SELECT * FROM $tabla5 WHERE actaid='$ideditar' AND tipoacta='entrega' ";
            $resultado7 = mysqli_query($con, $check7);
            if (mysqli_num_rows($resultado7) > 0) {
              $n = mysqli_fetch_array($resultado7);
              $observaciones = $n['observaciones'];
            }

            $check8 = "SELECT * FROM $tabla11 WHERE id_glpi='$ideditar'";
            $resultado8 = mysqli_query($con, $check8);
            if (mysqli_num_rows($resultado8) > 0) {
              $n2 = mysqli_fetch_array($resultado8);
              $discoactas = $n2['disco'];
              $ramactas = $n2['ram'];
              $procesadoracta = $n2['procesador'];
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
    <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/jquery-ui-git.css">
    <link href="../Fontawesome/css/all.css" rel="stylesheet">

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
                    <a class='btn btn-outline-warning' href="../db/EquiposGLPI.php">Volver</a>
                    <a class='btn btn-outline-dark' href="../../index.php">Home</a>
                    <a class='btn btn-dark'
                        href="https://servicedesk.grupoddb.co/front/computer.form.php?id=<?php echo $ideditar; ?>"
                        target='_blank'>Ver equipo en GLPI</a>
                    <?php if (mysqli_num_rows($resultado8) > 0) {
                        echo "<a class='btn btn-outline-danger' href='../db/editarGLPI.php?Borrar=".$ideditar."'>Reset disco y ram</a>";
                    }?>
                        
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
                <input type="hidden" name="id" value="<?php echo $ideditar; ?>">

                <input id="seriali" class="form-control" placeholder="Ingrese el serial" name="Serial"
                    value="<?php echo $serialglpi; ?>" readonly>
                <label for="seriali">Numero de Serie</label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" name="Marca" id="marcai" class="form-control" placeholder="Marca"
                    value="<?php echo $marcaglpi; ?>" readonly>
                <label for="marcai">Marca</label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" name="Modelo" id="modeli" class="form-control" placeholder="Modelo"
                    value="<?php echo $modelotraducido; ?>" readonly>
                <label for="modeli">Modelo</label>
            </div>

            <div class="form-floating col-md-2">
                <input type="text" name="placa" id="codii" class="form-control" placeholder="Placa"
                    value="<?php echo $placaglpi; ?>" readonly>

                <label for="codii">Placa</label>
            </div>

            <div class="form-floating col-md-1 offset-md-1"></div>
            <div class="form-floating col-md-3">
                <select class="form-control" id="procesador" name="Procesadorname" aria-describedby="procesadorid"
                    required>
                    <option><?php echo $procesadorglpi; ?>
                        <?php $sql = "SELECT DISTINCT designation FROM glpi.glpi_deviceprocessors ORDER BY designation ASC";
                        $res = mysqli_query($conglpi, $sql);
                        while ($row = $res->fetch_array()) {
                            echo "<option>";
                            echo $row['designation'];
                            echo "</option>";
                        } ?>
                </select>
                <label for="procesador">Procesador</label>
                <small class='form-text text-muted'><?php if ($procesadoracta<>""){echo "En acta ".$procesadoracta;} ?></small>
            </div>


            <div class="form-floating col-md-1">
                <select class="form-control" id="rami" name="Ram" aria-describedby="ramid" required>
                    <option><?php echo $ramglpi; ?></option>
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
                    <option>24 GB</option>
                    <option>32 GB</option>
                    <option>N/A</option>
                </select>
                <label for="rami">Ram</label>
                <small class='form-text text-muted'><?php if ($ramactas<>""){echo "En acta ".$ramactas;} ?></small>
            </div>

            <div class="form-floating col-md-1">
                <select class="form-control" id="discoi" name="Disco" aria-describedby="discoid" required>
                    <option><?php echo $discoglpi; ?></option>
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
                <small class='form-text text-muted'><?php if ($discoactas<>""){echo "En acta ".$discoactas;} ?></small>
            </div>

            <div class="form-floating col-md-2">
                <select class="form-control" id="estadoi" name="Estado" aria-describedby="estadoid" readonly disabled>
                    <option><?php echo $estadoglpi; ?>
                        <?php $sql = "SELECT DISTINCT name FROM glpi.glpi_states ORDER BY name ASC";
                        $res = mysqli_query($conglpi, $sql);
                        while ($row = $res->fetch_array()) {
                            echo "<option>";
                            echo $row['name'];
                            echo "</option>";
                        } ?>
                </select>
                <label for="estadoi">Estado</label>
            </div>

            <div class="form-floating col-md-2 offset-md-3">

                <input type="text" name="computername" id="pcname" class="form-control" placeholder="Nombre de equipo"
                    value="<?php echo $nombreglpi; ?>" aria-describedby="computerid" readonly>
                <label for="pcname">Nombre de equipo</label>
            </div>

            <div class="form-floating col-md-1 ">
                <select class="form-control" id="ubii" name="Ubicacion" aria-describedby="ubicacionid" readonly
                    disabled>
                    <option><?php echo $ubicacionglpi; ?></option>
                    <?php $sql = "SELECT completename FROM glpi.glpi_locations";
                    $res = mysqli_query($conglpi, $sql);
                    while ($row = $res->fetch_array()) {
                        echo "<option>";
                        echo $row['completename'];
                        echo "</option>";
                    } ?>
                </select>
                <label for="ubii">Ubicacion</label>
            </div>




            <div class="form-floating col-md-3">
                <input type="text" name="Usuario" id="lastuser" class="form-control" placeholder="Asignado a:"
                    value="<?php echo $usuarioglpi ?>" disabled>
                <label for="lastuser">Asignado a:</label>
            </div>

            <div class="form-floating col-md-7 offset-md-2">
                <textarea class="form-control" style="height: 200px" name="Descripcion" id="descrii"
                    placeholder="Descripcion" readonly><?php echo $comentariosglpi; ?></textarea>
                <label for="descrii">Comentarios GLPI</label>
            </div>

            <div class="row g-3 content-center">
                <h3 class="text-center">Reparacion o Garantia</h3>
                <div class="form-floating col-md-2 offset-md-4">
                    <select class="form-control" id="verticalestadoid" name="verticalestado">
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
                    <label for="verticalestadoid">Estado</label>
                </div>

                <div class="form-floating col-md-2">
                    <select class="form-control" id="verticalubicacionid" name="verticalubicacion">
                        <option><?php if (isset($_SESSION['verticalubicacion'])) {
                                echo $_SESSION['verticalubicacion'];
                                unset($_SESSION['verticalubicacion']);
                            } else {
                                echo $verticalestado;
                            } ?>
                        </option>
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
                    <a class="btn btn-dark" href="" data-bs-toggle="modal"
                        data-bs-target="#<?php echo $valida; ?>">Generar Acta</a>
                    <a class='btn btn-outline-dark' href="../../index.php">Finalizar</a>
                    <?php unset($_SESSION['postreg']);
                        else : ?>
                    <button type="submit" name="Enviar" class="btn btn-warning">Actualizar Informacion</button>
                    <a class='btn btn-dark' href="../../index.php">Cancelar</a>
                    <?php endif ?>
                    <?php endif ?>
                    <a class="btn btn-outline-dark" href="" data-bs-toggle="modal"
                        data-bs-target="#<?php echo $valida; ?>" onclick="recarga()">Generar Acta</a>
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
                    <p>Revise, complete y actualice la informacion para generar el acta. Si necesita modificar campos
                        puede hacerlo en GLPI en la pestaña perifericos asignados.</p>
                    <a class='btn btn-dark'
                        href="https://servicedesk.grupoddb.co/front/computer.form.php?id=<?php echo $ideditar; ?>"
                        target='_blank'>Ver equipo en GLPI</a>
                    <a class="btn btn-warning" id="recargarperifericos" onclick="recarga()"><span
                            class="fas fa-redo"></span> Actualizar campos</a>
                    <form method="post" action="../Generar-Acta/actaentrega.php" enctype="multipart/form-data"
                        id="perifericosform">

                        <div class="row g-2">

                            <div>
                                <input type="hidden" name="id" value="<?php echo $ideditar; ?>">
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="tipo" name="tipopc"
                                        aria-describedby="tipoid" disabled required>
                                        <option><?php echo $tipopcglpi; ?></option>
                                    </select>
                                    <label for="tipo">Equipo Entregado</label>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="bagig" name="bag"
                                        aria-describedby="baglid" disabled required>
                                        <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                    </select>
                                    <label for="bagig">Maleta</label>
                                </div>
                            </div>


                            <div class="form-floating col-md-2">
                                <select class="form-control form-control-sm" id="guayaid" name="guaya"
                                    aria-describedby="guayalid" disabled required>
                                    <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                </select>
                                <label for="guayaid">Guaya</label>
                            </div>

                            <div class="form-floating col-md-2">
                                <select class="form-control" id="satechiid" name="satechi" aria-describedby="satechilid"
                                    disabled required>
                                    <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                </select>
                                <label for="satechiid">Satechi</label>
                            </div>

                            <div class="form-floating col-md-2">
                                <select class="form-control" id="tecladoid" name="teclado" aria-describedby="tecladolid"
                                    disabled required>
                                    <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                </select>
                                <label for="tecladoid">Teclado</label>
                            </div>



                            <div class="form-floating col-md-2">
                                <select class="form-control" id="mouseid" name="mouse" aria-describedby="mouselid"
                                    disabled required>
                                    <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                </select>
                                <label for="mouseid">Mouse</label>
                            </div>
                            <div class="form-floating col-md-3">
                                <select class="form-control" id="baseid" name="base" disabled required>
                                    <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                </select>
                                <label for="baseid">Base refrigerante</label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="cargadorid" name="cargador"
                                        disabled required>
                                        <?php echo '<option>No</option>'; echo '<option>45 Watts</option>';  echo '<option>67 Watts</option>';
                                         echo '<option>Original</option>';?>
                                    </select>
                                    <label for="cargadorid">Cargador</label>
                                </div>
                            </div>

                            <div class="form-floating col-md-3">
                                <select class="form-control" id="cableid" name="cable" disabled required>
                                    <?php echo '<option>No</option>'; echo '<option>Si</option>';?>
                                </select>
                                <label for="cableid">Cable lightning</label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="text" id="stecladoid" class="form-control" placeholder="Serial del teclado"
                                    name="steclado" value="<?php echo $tecladoserialglpi;?>" disabled>
                                <label for="stecladoid">Serial del teclado</label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="text" id="smouseid" class="form-control" placeholder="Serial del mouse"
                                    name="smouse" value="<?php echo $mouseserialglpi;?>" disabled>
                                <label for="smouseid">Serial del mouse</label>
                            </div>


                            <div class="form-floating col-md-3">
                                <select class="form-control" id="pantalla" name="pantallaserial"
                                    aria-describedby="pantallaid">
                                    <option>
                                        <?php 
                        $resm = mysqli_query($conglpi, $querymonitor);
                        while ($rowm = $resm->fetch_array()) {
                            echo "<option>";
                            echo $rowm['serialmonitor'];
                            echo "</option>";
                        } ?>
                                </select>
                                <label for="pantalla">Serial Pantalla</label>
                            </div>

                            <div class="form-floating col-md-4">
                                <input type="text" id="monitorid" class="form-control" placeholder="Marca monitor"
                                    name="monitor" value="" disabled>
                                <label for="monitorid">Marca monitor</label>
                                <small class='form-text text-muted' id="monitorlabel">Monitor no registrado</small>
                            </div>


                            <div class="form-floating col-md-4">
                                <input name="modelo" id="modeloid" class="form-control" placeholder="Modelo del monitor"
                                    value="" disabled required>
                                <label for="modeloid">Modelo del monitor</label>
                            </div>

                            <div class="form-floating col-md-6">
                                <input type="text" id="otrosid" class="form-control" placeholder="Otros:" name="otros"
                                    value="<?php echo $otrosglpi;?>" disabled>
                                <label for="otrosid">Otros:</label>
                                <small class='form-text text-muted'>Otros Perifericos, aparece en el acta de
                                    entrega.</small>
                            </div>

                            <div class="form-floating col-md-6">
                                <textarea class="form-control" style="height: 100px" name="observaciones"
                                    id="observacionesid" placeholder="Observaciones" value=""><?php echo $observaciones;?></textarea>
                                <label for="observacionesid">Observaciones:</label>
                                <small class='form-text text-muted'>Aparece en el acta de retiro.</small>
                            </div>






                        </div>

                        <div class='modal-footer'>
                            <button type="submit" name="generaractaeditar" class="btn btn-warning">Generar acta
                                entrega</button>
                            <a class='btn btn-outline-dark'
                                href="../Generar-Acta/actaretiro.php?id=<?php echo $actaid; ?>">Generar acta retiro</a>
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
                    Para generar el acta, debe registrar la siguiente información del usuario <?php echo "$usuario"; ?>
                    :
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
                            <input type="text" id="cargoid" class="form-control" placeholder="Cargo:" name="cargo"
                                value="<?php echo $cargo; ?>" required>
                            <label for="cargoid">Cargo:</label>
                        </div>

                        <div class="form-label-group">
                            <input type="text" id="areaid" class="form-control" placeholder="Area:" name="area"
                                value="<?php echo $area; ?>" required>
                            <label for="areaid">Area:</label>
                        </div>

                        <div class="form-label-group">
                            <input type="text" id="cedulaid" class="form-control" placeholder="Cedula:" name="cedula"
                                value="<?php echo $cedula; ?>" required>
                            <label for="cedulaid">Cedula:</label>
                        </div>


                        <div class='modal-footer'>
                            <button type="submit" name="actualiza-user" class="btn btn-warning">Actualizar
                                información</button>
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
                    El serial <?php echo "$serial"; ?>, no tiene ningún usuario registrado. Es necesario registrarlo
                    para generar el acta.
                    Tener en cuenta que el nombre de equipo también es requerido.


                    <div class='modal-footer'>
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Editar información
                            de equipo</button>
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
                    El serial <?php echo "$serial"; ?>, no tiene nombre de equipo registrado. Es necesario registrarlo
                    para generar el acta.


                    <div class='modal-footer'>
                        <button type="button" class="btn btn-outline-warning" data-bs-dismiss="modal">Editar información
                            de equipo</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
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
                    url: "atnameGLPI.php",
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
            select: function(event, ui) {}
        });
    });
    </script>



    <script>
    $(document).ready(function() {

        $("#pantalla").change(function() {
            var monitorserial = $(this).val();
            var monitorlabel = document.getElementById("monitorlabel");

            $.ajax({
                url: 'monitorconsulta.php',
                type: 'GET',
                data: {
                    serialmonitor: monitorserial
                },
                dataType: 'json',
                success: function(response) {

                    var len = response.length;

                    $("#monitorid").val("");
                    $("#monitorid").val("");
                    monitorlabel.textContent = "Monitor no registrado";
                    for (var i = 0; i < len; i++) {
                        var marcamonitor = response[i]['marcamonitor'];
                        var modelo = response[i]['modelomonitor'];

                        $("#monitorid").val("" + marcamonitor + "");
                        $("#modeloid").val("" + modelo + "");
                        monitorlabel.textContent = "S/N: " + monitorserial;

                    }
                }
            });
        });

    });
    </script>
    <script>
    function recarga() {
        var idglpi = <?php echo $ideditar;?>;
        //var monitorlabel = document.getElementById("monitorlabel");

        $.ajax({
            url: 'monitorconsulta.php',
            type: 'GET',
            data: {
                idglpiconsulta: idglpi
            },
            dataType: 'json',
            success: function(response) {

                var len = response.length;

                //$("#monitorid").val("");
                //$("#monitorid").val("");
                //monitorlabel.textContent = "Monitor no registrado";
                for (var i = 0; i < len; i++) {
                    var maleta = response[i]['bolsoglpi'];
                    var guaya = response[i]['guayaglpi'];
                    var satechi = response[i]['adaptadorglpi'];
                    var teclado = response[i]['tecladoglpi'];
                    var mouse = response[i]['mouseglpi'];
                    var base = response[i]['baseglpi'];
                    var cargador = response[i]['cargadorglpi'];
                    var cable = response[i]['cablelightningglpi'];
                    var steclado = response[i]['tecladoserialglpi'];
                    var smouse = response[i]['mouseserialglpi'];
                    var otros = response[i]['otrosglpi'];

                    //var modelo = response[i]['modelomonitor'];

                    $("#bagig").val("" + maleta + "");
                    $("#guayaid").val("" + guaya + "");
                    $("#satechiid").val("" + satechi + "");
                    $("#tecladoid").val("" + teclado + "");
                    $("#mouseid").val("" + mouse + "");
                    $("#baseid").val("" + base + "");
                    $("#cargadorid").val("" + cargador + "");
                    $("#cableid").val("" + cable + "");
                    $("#stecladoid").val("" + steclado + "");
                    $("#smouseid").val("" + smouse + "");
                    $("#otrosid").val("" + otros + "");
                    //$("#observacionesid").val("<?php echo $observaciones;?>");
                    
                    //$("#modeloid").val("" + modelo + "");
                    //monitorlabel.textContent = "S/N: " + monitorserial;

                }
            }
        });
    }
    </script>
</body>

</html>


<?php

ob_end_flush();

?>