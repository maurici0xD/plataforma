<?php
ob_start();
?>
<?php
session_start();
if (isset($_SESSION['username'])) {
    date_default_timezone_set('America/Bogota');
    $fecha = date("g:i A");
    include('../db/conexion.php');
    $query = "SELECT * FROM $tabla2 ";
    $resultado = mysqli_query($con, $query);

    if (isset($_GET['Borrar'])) {
        if ($_SESSION['permisos'] == 'admin') {
            $infodel = $_GET['Serial'];
            $iddel = $_GET['Borrar'];
            $Borrareg = true;
        } else {
            $_SESSION['message'] = "No tienes permiso para eliminar registros";
            header("location: ../db/Equipos.php");
        }
    }
    if (isset($_GET['Subircotizacion'])) {

        $info = $_GET['Serial'];
        $idact = $_GET['Subircotizacion'];
        $Subiract = true;
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.5.6/css/colReorder.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.4.0/css/select.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.0.2/css/searchPanes.bootstrap5.min.css">
    <link href="../Fontawesome/css/all.css" rel="stylesheet">
    <title>IT DDB - Equipos</title>
</head>

<body>
<?php if (isset($_SESSION['message'])) : ?>

        <?php echo "si"; if (isset($_GET['Borrar'])) {
        } else {
          unset($_SESSION['message']);
        }
      endif ?>
        </div>

    <div class="col-md-10 offset-md-1">
        <table id="datosb" class="table table-md display responsive nowrap" style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Ver:</th>
                    <th class="text-center">Acción</th>
                    <th class="text-center">Serial</th>
                    <th class="text-center">Placa</th>
                    <th class="text-center">Marca</th>
                    <th class="text-center">Modelo</th>
                    <th class="text-center">Año</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Asignado a</th>
                    <th class="text-center">Ubicación</th>
                    <th class="text-center">Grupo</th>
                    <th class="text-center">Procesador</th>
                    <th class="text-center">Disco</th>
                    <th class="text-center">Ram</th>
                    <th class="text-center">Nombre de equipo</th>
                    <th class="text-center">Sistema Operativo</th>
                    <th class="text-center">Comentarios GLPI</th>
                    <th>Última actualización</th>
                    <th class="text-center">Estado proveedor de servicio</th>
                    <th class="text-center">Ubicacion equipo</th>
                    <th class="text-center">Cotizacion</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while ($fila = $resultado->fetch_assoc()) {
                    $idglpi = $fila['id_glpi'];
                    $modelopc = $fila['modelo'];
                    $querymodelo = "SELECT * FROM $tabla6 WHERE modelo_glpi = '$modelopc'";
                    $resultadomodelo = mysqli_query($con, $querymodelo);
                    if ($modeloconsulta = $resultadomodelo->fetch_assoc()) {
                        $modelotraducido = $modeloconsulta['modelo'];
                    }
                    $queryvertical = "SELECT * FROM $tabla8 WHERE id_glpi = '$idglpi'";
                    $resultadovertical = mysqli_query($con, $queryvertical);
                    if ($verticalconsulta = $resultadovertical->fetch_assoc()) {
                        $verticalestado = $verticalconsulta['estado'];
                        $verticalubicacion = $verticalconsulta['ubicacion'];
                        $verticalcotizacion = $verticalconsulta['cotizacion'];
                    }
                    $fila['grupo'] = str_replace(' > ', '/', $fila['grupo']);
                    //$fila['grupo'] = str_replace(' ','_',$fila['grupo']);


                    echo "<tr>
              <td></td>";

                    if (($fila['acta'] == "No hay acta") || ($fila['acta'] == "")) {
                        echo "
              <td>


<div class='btn-group dropleft'>
<button type='button' class='btn btn-light btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
<i class='fas fa-toolbox'></i>
</button>
<div class='dropdown-menu'>
<a class='dropdown-item' href='../db/editar.php?Editar=" . $fila['id'] . "'>Editar</a>
<a class='dropdown-item' href='../consultas/prestamo.php?prestar=" . $fila['id'] . "'>Prestar</a>
<a class='dropdown-item' href='../db/Equipos.php?Borrar=" . $fila['id'] . "&Serial=" . $fila['serial'] . "'>Borrar</a>
<div class='dropdown-divider'></div>
<a class='dropdown-item' href='../db/Equipos.php?Subircotizacion=" . $idglpi . "&Serial=" . $fila['serial'] . "'>Subir acta</a>
</div>

</div>

              </td>";


                        //<a class='dropdown-item' href='../Generar-Acta/postactaentrega.php?Generar=".$fila['id']."'>Generar acta</a> Usado para generar actas en version 2.0
                    } else {
                        echo "
              <td>


<div class='btn-group dropleft'>
<button type='button' class='btn btn-light btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
<i class='fas fa-toolbox'></i>
</button>
<div class='dropdown-menu'>
<a class='dropdown-item' href='../db/editar.php?Editar=" . $fila['id'] . "'>Editar</a>
<a class='dropdown-item' href='../consultas/prestamo.php?prestar=" . $fila['id'] . "'>Prestar</a>
<a class='dropdown-item' href='../db/Equipos.php?Borrar=" . $fila['id'] . "&Serial=" . $fila['serial'] . "'>Borrar</a>
<div class='dropdown-divider'></div>
<a class='dropdown-item' href='../consultas/actas.php?mostrar=" . $fila['id'] . "'>Ver Acta</a>
<a class='dropdown-item' href='../db/Equipos.php?Subircotizacion=" . $idglpi . "&Serial=" . $fila['serial'] . "'>Subir acta</a>
<a class='dropdown-item' href='../db/consultaymodifica.php?Borraracta=" . $fila['id'] . "&Serial=" . $fila['serial'] . "'>Borrar acta</a>
</div>

</div>

              </td>";
                    }
                    echo "
<td class='text-center'>" . $fila['serial'] . "</td>
<td class='text-center'>" . $fila['placa'] . "</td>
<td class='text-center'>" . $fila['fabricante'] . "</td>
<td class='text-center'>" . $modelotraducido . "</td>
<td class='text-center'>" . $fila['year'] . "</td>
<td class='text-center'>" . $fila['estado'] . "</td>
<td class='text-center'>" . $fila['usuario'] . "</td>
<td class='text-center'>" . $fila['ubicacion'] . "</td>
<td class='text-center'>" . $fila['grupo'] . "</td>
<td class='text-center'>" . $fila['procesador'] . "</td>
<td class='text-center'>" . $fila['disco'] . "</td>
<td class='text-center'>" . $fila['ram'] . "</td>
<td class='text-center'>" . $fila['nombre'] . "</td>
<td class='text-center'>" . $fila['sistema_version'] . "</td>
<td>" . $fila['comentarios_glpi'] . "</td>
<td class='text-center'>" . $fila['modificacion'] . "</td>
<td class='text-center'>" . $verticalestado . "</td>
<td class='text-center'>" . $verticalubicacion . "</td>
<td class='text-center'>" . $verticalcotizacion . "</td>
</tr>";
                }


                ?>


            </tbody>
        </table>
    </div>

    <div class='modal fade' id='importar' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='importarid'>Importar datos</h5>
                </div>
                <div class='modal-body'>
                    Seleccione la informacion a importar:

                    <div class='modal-footer'>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal" data-bs-target="#importarusuarios">Usuarios</a>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal" data-bs-target="#importarequipos">Equipos</a>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal" data-bs-target="#importarmodelos">Modelos</a>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal" data-bs-target="#importarsistemas">Sistemas</a>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarusuarios' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='importarusuariosid'>Importar usuarios</h5>
                </div>
                <div class='modal-body'>
                    Seleccione archivo de usuarios a importar:
                    <form action="import.php" method="post" enctype="multipart/form-data" id="import_form">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file">
                        </div>
                        <div class='modal-footer'>
                            <input type="submit" class="btn btn-warning" name="import_usuarios" value="Importar usuarios">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarequipos' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='importarequiposid'>Importar equipos</h5>
                </div>
                <div class='modal-body'>
                    Seleccione archivo de equipos a importar:
                    <form action="import.php" method="POST" enctype="multipart/form-data" id="import_form">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file">
                        </div>
                        <div class='modal-footer'>
                            <input type="submit" class="btn btn-warning" name="import_equipos2" value="Importar equipos">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarmodelos' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='importarmodelosid'>Importar modelos</h5>
                </div>
                <div class='modal-body'>
                    Seleccione archivo de modelos a importar:
                    <form action="import.php" method="post" enctype="multipart/form-data" id="import_form">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file">
                        </div>
                        <div class='modal-footer'>
                            <input type="submit" class="btn btn-warning" name="import_modelos" value="Importar modelos">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarsistemas' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='importarsistemasid'>Importar sistemas</h5>
                </div>
                <div class='modal-body'>
                    Seleccione archivo de sistemas a importar:
                    <form action="import.php" method="post" enctype="multipart/form-data" id="import_form">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file">
                        </div>
                        <div class='modal-footer'>
                            <input type="submit" class="btn btn-warning" name="import_sistema" value="Importar sistema">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class='modal fade' id='borrardatamodal' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='borrardata'>Eliminar registro</h5>
                </div>
                <div class='modal-body'>
                    Realmente desea eliminar el registro <?php echo "$infodel"; ?> ?
                </div>
                <div class='modal-footer'>
                    <a class='btn btn-dark' href="../db/Editar.php">Cancelar</a>
                    <a class='btn btn-outline-danger' href='../db/editar.php?Borrar=<?php echo "$iddel"; ?>'>Eliminar registro</a>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='Subircotizacionmodal' tabindex='-1' role='dialog' aria-hidden='true' data-bs-backdrop="static">
    <div class='modal-dialog modal-dialog-centered' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='subircotizacionid'>Subir cotizacion</h5>
        </div>
        <div class='modal-body'>
          Seleccione la cotizacion en formato pdf para el serial <?php echo "$info"; ?> :
          <form action="../db/actas.php" method="POST" enctype="multipart/form-data">
            <div>
              <input type="hidden" name="id" value="<?php echo $idact; ?>">
            </div>
            <div class="form-group">
              <div class="custom-file">
              <label class="form-label" for="actacotiza">Cotizacion digital</label>
                <input type="file" class="form-control" id="actacotiza" name="actacotizacion" accept=".pdf" lang="es">
              </div>
            </div>
            <div class='modal-footer'>
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="Subir" class="btn btn-outline-warning">Subir acta</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="../js/sesioninactiva.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.3/js/dataTables.fixedHeader.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.5.6/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.0.2/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.0.2/js/searchPanes.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.4.0/js/dataTables.select.min.js"></script>



    <script>
        $(document).ready(function() {
            var table = $('#datosb').DataTable({
                searchPanes: {
                    initCollapsed: true,
                    cascadePanes: true,
                    panes: [{
                        header: 'En Bodega',
                        options: [{
                                label: 'Equipos en Bodega',
                                value: function(rowData, rowIdx) {

                                    return rowData['10'] == 'GROUP_1/BODEGA IT_G1' || rowData['10'] == 'GROUP_1/BODEGA IT_G1/ASIGNADO' ||
                                        rowData['10'] == 'GROUP_1/BODEGA IT_G1/LIBRE/DISPONIBLE' || rowData['10'] == 'GROUP_2/BODEGA IT_G2' ||
                                        rowData['10'] == 'GROUP_2/BODEGA IT_G2/ASIGNADO' ||
                                        rowData['10'] == 'GROUP_2/BODEGA IT_G2/LIBRE/DISPONIBLE';
                                }
                            },
                            {
                                label: 'Bodega Medellin',
                                value: function(rowData, rowIdx) {

                                    return (rowData['10'] == 'GROUP_1/BODEGA IT_G1' || rowData['10'] == 'GROUP_1/BODEGA IT_G1/ASIGNADO' ||
                                        rowData['10'] == 'GROUP_1/BODEGA IT_G1/LIBRE/DISPONIBLE' || rowData['10'] == 'GROUP_2/BODEGA IT_G2' ||
                                        rowData['10'] == 'GROUP_2/BODEGA IT_G2/ASIGNADO' ||
                                        rowData['10'] == 'GROUP_2/BODEGA IT_G2/LIBRE/DISPONIBLE') && (rowData['9'] == 'Medellin') && (rowData['7'] == 'Activo');
                                }
                            },
                            {
                                label: 'Bodega Bogota',
                                value: function(rowData, rowIdx) {

                                    return (rowData['10'] == 'GROUP_1/BODEGA IT_G1' || rowData['10'] == 'GROUP_1/BODEGA IT_G1/ASIGNADO' ||
                                        rowData['10'] == 'GROUP_1/BODEGA IT_G1/LIBRE/DISPONIBLE' || rowData['10'] == 'GROUP_2/BODEGA IT_G2' ||
                                        rowData['10'] == 'GROUP_2/BODEGA IT_G2/ASIGNADO' ||
                                        rowData['10'] == 'GROUP_2/BODEGA IT_G2/LIBRE/DISPONIBLE') && (rowData['9'] == 'Bogota') && (rowData['7'] == 'Activo');
                                }
                            }

                        ]
                    }],
                },
                select: true,
                order: [2, 'asc'],
                responsive: {
                    details: {
                        type: 'column',
                        display: $.fn.dataTable.Responsive.display.modal({
                            header: function(row) {
                                var data = row.data();
                                //return 'Details for '+data[1]+' '+data[2];
                                return 'Detalles de equipo ' + data[2];
                            }
                        }),
                        //renderer: $.fn.dataTable.Responsive.renderer.listHidden( {
                        //tableClass: 'table'
                        //} )  estas lineas habilitan mostrar todos los datos de la tabla, las siguientes solo las columnas ocultas
                        renderer: function(api, rowIdx, columns) {
                            var data = $.map(columns, function(col, i) {
                                return col.hidden ?
                                    '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td>' + col.title + ':' + '</td> ' +
                                    '<td>' + col.data + '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ?
                                $('<table/>').append(data) :
                                false;
                        }

                    }
                },

                columnDefs: [{
                        className: 'control',
                        orderable: false,
                        targets: 0,

                    },
                    {
                        searchPanes: {
                            show: false
                        },
                        targets: [0, 1, 2, 3, 11, 12, 13, 14, 15, 16]
                    }
                ],

                fixedHeader: {
                    header: true,
                    footer: true
                },

                "lengthMenu": [
                    [10, 15, 20, 50, -1],
                    [10, 15, 20, 50, "Todo"]
                ],
                language: {
                    processing: "Procesando...",
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info: "Registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty: "Registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    infoPostFix: "",
                    loadingRecords: "Cargando...",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    paginate: {
                        first: "Primero",
                        previous: "Último",
                        next: "Siguiente",
                        last: "Dernier"
                    },
                    aria: {
                        sortAscending: ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    },

                    buttons: {

                        copyTitle: "Copiado al portapapeles",
                        copySuccess: {
                            _: "%d filas copiadas",
                            1: "1 fila copiada"
                        },

                        copy: "Copiar",
                        colvis: "Columnas",
                        print: "imprimir",
                        colvisRestore: "Restaurar Columnas"
                    },

                    select: {
                        rows: {
                            _: "Has seleccionado %d filas",
                            1: "Solo 1 fila seleccionada"
                        }
                    },

                    searchPanes: {
                        title: {
                            _: 'Filtros seleccionados - %d',
                            0: 'No hay filtros seleccionados',
                            1: '1 Filtro seleccionado'
                        }
                    }

                },

                buttons: [

                    {
                        extend: 'colvis',
                        collectionLayout: 'fixed two-column',
                        postfixButtons: ['colvisRestore'],
                        className: 'btn btn-warning'

                    },
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i>',
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            // jQuery selector to add a border
                            $('row c[r*="2"]', sheet).attr('s', '25');
                        },
                        exportOptions: {
                            columns: ':visible'
                        },
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i>',
                        className: 'btn btn-danger',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-filter"></i>',
                        className: 'btn btn-dark',
                        action: function() {
                            let table = $('#datosb').DataTable();
                            new $.fn.dataTable.SearchPanes(table, {});
                            table.searchPanes.container().prependTo(table.table().container());
                            table.searchPanes.resizePanes();
                        }
                    },
                    {
                        text: '<i class="fa-solid fa-file-import"></i>',
                        className: 'btn btn-warning',
                        action: function() {
                            $("#importar").modal("show");
                        }
                    },

                    {
                        text: '<i class="fas fa-redo"></i>',
                        className: 'btn btn-warning',
                        action: function(e) {
                            e.preventDefault();
                            table.colReorder.reset();
                        }
                    }

                ],

                dom: 'lfBrtip',
                stateSave: true

            });
        });
    </script>
    <?php if ($Borrareg === true) :  ?>
        <script>
            $(document).ready(function() {

                $("#borrardatamodal").modal("show");
            });
        </script>
    <?php endif; ?>

    <?php if ($Subiract === true) :  ?>
  <script>
    $(document).ready(function() {

      $("#Subircotizacionmodal").modal("show");
    });
  </script>
<?php endif; ?>
</body>

</html>

<?php
ob_end_flush();
?>