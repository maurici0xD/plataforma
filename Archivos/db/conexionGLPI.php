<?php

$conglpi= new mysqli('10.243.193.46','php_support','Ddb.2022.*','glpi') or die('Error de conexion al servidor' .mysqli_error($conglpi));
$conglpi->set_charset("utf8");
$tablaequipos = "glpi_computers";
$tablaubicaciones = "glpi_locations";
$tablamodelos = "glpi_computermodels";
$tablamarca = "glpi_manufacturers";
$tablayear = "glpi_plugin_fields_computerpurchases";
$tablaestados = "glpi_states";

?>