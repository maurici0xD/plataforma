<?php
ob_start();
?>
<?php 
session_start();
include ('conexionGLPI.php');

if (isset($_SESSION['username'])) {
    
    if (isset($_GET['serialmonitor'])) {
$numeroserie=$_GET['serialmonitor'];
$querymonitor = "SELECT 
glpi.glpi_monitors.name as modelomonitor,
glpi.glpi_manufacturers.name as marcamonitor
FROM glpi.glpi_monitors
left join glpi.glpi_manufacturers on glpi.glpi_manufacturers.id=glpi_monitors.manufacturers_id WHERE glpi_monitors.serial='$numeroserie'";
$resm = mysqli_query($conglpi, $querymonitor);
$organiza = array();
while ($rowm = $resm->fetch_array()) {
    //$monitormodelo=$rowm['modelomonitor'];
    $organiza[] = $rowm;
}

echo json_encode($organiza);
}


if (isset($_GET['idglpiconsulta'])) {

    $ideditar = $_GET['idglpiconsulta'];

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
    glpi.glpi_users.registration_number as cedula,
    glpi.glpi_usercategories.name as area,
    glpi.glpi_usertitles.name as cargo,
    glpi.glpi_useremails.email as correo,
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
    left join glpi.glpi_useremails on glpi_users.id=glpi_useremails.users_id
    left join glpi.glpi_usercategories on glpi_users.usercategories_id=glpi_usercategories.id
    left join glpi.glpi_usertitles on glpi_users.usertitles_id=glpi_usertitles.id
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
    $filasglpi = mysqli_num_rows($resultadoglpi);
    if (($filasglpi > 0)) {

    $organiza = array();
    while ($rowm = $resultadoglpi->fetch_array()) {
        if ($rowm['bolsoglpi'] == "1") {
            $rowm['bolsoglpi']="Si";
        }else{
            if ($rowm['bolsoglpi'] <> "1") {
                $rowm['bolsoglpi']="No";
            }
        }
        if ($rowm['guayaglpi'] == "1") {
            $rowm['guayaglpi']="Si";
        }else{
            if ($rowm['guayaglpi'] <> "1") {
                $rowm['guayaglpi']="No";
            }
        }

        if ($rowm['adaptadorglpi'] == "1") {
            $rowm['adaptadorglpi']="Si";
        }else{
            if ($rowm['adaptadorglpi'] <> "1") {
                $rowm['adaptadorglpi']="No";
            }
        }

        if ($rowm['tecladoglpi'] == "1") {
            $rowm['tecladoglpi']="Si";
        }else{
            if ($rowm['tecladoglpi'] <> "1") {
                $rowm['tecladoglpi']="No";
            }
        }

        if ($rowm['mouseglpi'] == "1") {
            $rowm['mouseglpi']="Si";
        }else{
            if ($rowm['mouseglpi'] <> "1") {
                $rowm['mouseglpi']="No";
            }
        }

        if ($rowm['baseglpi'] == "1") {
            $rowm['baseglpi']="Si";
        }else{
            if ($rowm['baseglpi'] <> "1") {
                $rowm['baseglpi']="No";
            }
        }

        if (gettype($rowm['cargadorglpi']) == "NULL") {
            $rowm['cargadorglpi']="No";
        }else{
            if ($rowm['cargadorglpi'] == "No") {
                $rowm['cargadorglpi']="No";
            }
        }

        if ($rowm['cablelightningglpi'] == "1") {
            $rowm['cablelightningglpi']="Si";
        }else{
            if ($rowm['cablelightningglpi'] <> "1") {
                $rowm['cablelightningglpi']="No";
            }
        }

        if (gettype($rowm['tecladoserialglpi']) == "NULL") {
            $rowm['tecladoserialglpi']="";
        }
        if (gettype($rowm['mouseserialglpi']) == "NULL") {
            $rowm['mouseserialglpi']="";
        }
        if (gettype($rowm['otrosglpi']) == "NULL") {
            $rowm['otrosglpi']="";
        }
    //$monitormodelo=$rowm['modelomonitor'];
    $organiza[] = $rowm;
}

echo json_encode($organiza);


}
}



} else {
    header("location: ../usr/login.php");
}
 ?>
<?php
ob_end_flush();
?>