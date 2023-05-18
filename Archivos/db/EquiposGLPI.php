<?php
ob_start();
?>
<?php

session_start();
if (isset($_SESSION['username'])) {
    date_default_timezone_set('America/Bogota');
    $fecha = date("g:i A");
    include('../db/conexion.php');
    include('../db/conexionGLPI.php');
   
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
    glpi.glpi_groups.completename as grupo,
    glpi.glpi_deviceprocessors.designation as procesador,
    glpi.glpi_items_deviceharddrives.capacity as disco,
    SUM(glpi.glpi_items_devicememories.size) as ram,
    glpi.glpi_operatingsystems.name as sistema,
    glpi.glpi_operatingsystemversions.name as sistemaversion
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
    group by glpi.glpi_computers.id";
    $resultadoglpi = mysqli_query($conglpi, $queryglpi);

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
} else {
    header("location: ../usr/login.php");
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1” />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../Login/favicon.png">
    <link href="https://getbootstrap.com/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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
                    <th class="text-center">Estado</th>
                    <th class="text-center">Asignado a</th>
                    <th class="text-center">Ubicación</th>
                    <th class="text-center">Año</th>
                    <th class="text-center">Marca</th>
                    <th class="text-center">Modelo</th>
                    <th class="text-center">Grupo</th>
                    <th class="text-center">Procesador</th>
                    <th class="text-center">Disco</th>
                    <th class="text-center">Ram</th>
                    <th class="text-center">Nombre de equipo</th>
                    <th class="text-center">Sistema Operativo</th>
                    <th class="text-center">Comentarios GLPI</th>
                    <th>Última actualización</th>
                </tr>
            </thead>
            <tbody>
                <?php

                while ($filaglpi = $resultadoglpi->fetch_assoc()) {
                    $serialglpi = $filaglpi['serial'];
                    $idglpi = $filaglpi['id'];
                    $ubicacionglpi = $filaglpi['ubicacion'];
                    $modeloglpi = $filaglpi['modelo'];
                    $marcaglpi = $filaglpi['marca'];
                    $year = $filaglpi['year'];
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
                   
                    $modelopc = $modeloglpi;
                    $querymodelo = "SELECT * FROM $tabla6 WHERE modelo_glpi = '$modelopc'";
                    $resultadomodelo = mysqli_query($con, $querymodelo);
                    if ($modeloconsulta = $resultadomodelo->fetch_assoc()) {
                        $modelotraducido = $modeloconsulta['modelo'];
                    }

                    echo "<tr>
              <td></td>";

                  
                        echo "
              <td>


<div class='btn-group dropleft'>
<button type='button' class='btn btn-light btn-sm dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
<i class='fas fa-toolbox'></i>
</button>
<div class='dropdown-menu'>
<a class='dropdown-item' href='../db/editarGLPI.php?Editar=" . $filaglpi['id'] . "'>Editar</a>
<a class='dropdown-item' href='https://servicedesk.grupoddb.co/front/computer.form.php?id=" . $filaglpi['id'] . "' target='_blank'>GLPI</a>
<div class='dropdown-divider'></div>
<a class='dropdown-item' href='../db/consultaymodifica.php?Subiracta=" . $filaglpi['id'] . "&Serial=" . $filaglpi['serialglpi'] . "'>Subir acta</a>
</div>

</div>

              </td>";


                        //<a class='dropdown-item' href='../Generar-Acta/postactaentrega.php?Generar=".$fila['id']."'>Generar acta</a> Usado para generar actas en version 2.0
                    
                    echo "
<td class='text-center'>" . $serialglpi . "</td>
<td class='text-center'>" . $placaglpi . "</td>
<td class='text-center'>" . $estadoglpi . "</td>
<td class='text-center'>" . $usuarioglpi . "</td>
<td class='text-center'>" . $ubicacionglpi . "</td>
<td class='text-center'>" . $year . "</td>
<td class='text-center'>" . $marcaglpi . "</td>
<td class='text-center'>" . $modelotraducido . "</td>
<td class='text-center'>" . $grupoglpi . "</td>
<td class='text-center'>" . $procesadorglpi . "</td>
<td class='text-center'>" . $discoglpi . "</td>
<td class='text-center'>" . $ramglpi . "</td>
<td class='text-center'>" . $nombreglpi . "</td>
<td class='text-center'>" . $filaglpi['sistema'] ." Versión ". $filaglpi['sistemaversion'] . "</td>
<td class='text-center'>" . $comentariosglpi . "</td>
<td class='text-center'>" . $filaglpi['modificacion'] . "</td>
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
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal"
                            data-bs-target="#importarusuarios">Usuarios</a>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal"
                            data-bs-target="#importarequipos">Equipos</a>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal"
                            data-bs-target="#importarmodelos">Modelos</a>
                        <a class="btn btn-outline-warning" href="" data-bs-toggle="modal"
                            data-bs-target="#importarsistemas">Sistemas</a>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarusuarios' tabindex='-1' role='dialog' aria-hidden='true'
        data-bs-backdrop="static">
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
                            <input type="submit" class="btn btn-warning" name="import_usuarios"
                                value="Importar usuarios">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarequipos' tabindex='-1' role='dialog' aria-hidden='true'
        data-bs-backdrop="static">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='importarequiposid'>Importar equipos</h5>
                </div>
                <div class='modal-body'>
                    Seleccione archivo de equipos a importar:
                    <form action="import.php" method="post" enctype="multipart/form-data" id="import_form">
                        <div class="mb-3">
                            <input class="form-control" type="file" name="file">
                        </div>
                        <div class='modal-footer'>
                            <input type="submit" class="btn btn-warning" name="import_equipos" value="Importar equipos">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class='modal fade' id='importarmodelos' tabindex='-1' role='dialog' aria-hidden='true'
        data-bs-backdrop="static">
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

    <div class='modal fade' id='importarsistemas' tabindex='-1' role='dialog' aria-hidden='true'
        data-bs-backdrop="static">
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
    <div class='modal fade' id='borrardatamodal' tabindex='-1' role='dialog' aria-hidden='true'
        data-bs-backdrop="static">
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
                    <a class='btn btn-outline-danger' href='../db/editar.php?Borrar=<?php echo "$iddel"; ?>'>Eliminar
                        registro</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
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

                                return rowData['10'] == 'GROUP_1 > BODEGA IT_G1';
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
                                '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' +
                                col.columnIndex + '">' +
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
                    targets: [0, 1, 2, 3, 11, 12, 13, 14, 15, 16, 17]
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
</body>

</html>

<?php
ob_end_flush();
?>