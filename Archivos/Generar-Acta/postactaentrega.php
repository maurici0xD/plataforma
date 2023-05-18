<?php

ob_start();

?>

<?php

session_start();

if (isset($_SESSION['username'])) {

   date_default_timezone_set('America/Bogota');

  $fecha = date("d-m-Y g:i:s A");   

  include ('../db/conexion.php');




if (isset($_GET['Generar'])) {

  $id= $_GET['Generar'];
$query = "SELECT * FROM $tabla1 WHERE id = '$id' ";
$resultado = mysqli_query($con, $query);

  if ($fila = $resultado->fetch_assoc()) {

     $serial= $fila['nserial'];
     $nombreequipo = $fila['nombreequipo'];
      if(($nombreequipo=="")){
        $nombreequipo = "no";
      }

       if(($fila['pantalla']=="")){
        $monitor = "no";
      }else{
        $monitor = "si";
        $smonitor = $fila['pantalla'];
      }

      if(($fila['Ultb']=="")|| ($fila['Ultb']=="1") || ($fila['Ultb']=="n/a")){
        $usuario1 = "no";
      }else{
        $usuario1 = $fila['Ultb'];

$query2 = "SELECT * FROM $tabla5 WHERE id = '$usuario1' ";
$resultado2 = mysqli_query($con, $query2);

  if ($fila2 = $resultado2->fetch_assoc()) {

      $area= $fila2['area'];
      $cargo= $fila2['cargo'];
      $cedula= $fila2['cedula'];
      $idusuario= $fila2['id'];
      $usuario= $fila2['nombre'];

      if (($area=="") || ($cargo=="") || ($cedula=="")) {
        $usuariock="no validado";

      }else{
          $usuariock="validado";
      }

   
  }
      }

      $_SESSION['message']= "Para agregar una pantalla en el acta ó el serial del cargador, es necesario registrarlos en la información del equipo.";

  }

  
}//generar

if (isset($_POST['actualiza-user'])) {
  $id= $_POST['id'];
  $cargo1= $_POST['cargo'];
  $cargo2= strtolower($cargo1);
  $cargo = ucwords($cargo2);
  $area1= $_POST['area'];
  $area2= strtolower($area1);
  $area = ucwords($area2);
  $cedula= $_POST['cedula'];
  $actualizado= $_SESSION['username'];
  $nombre= $_POST['nombre'];
  $link= $_POST['link'];

      $query=$con->query("UPDATE $tabla5 SET cargo='$cargo',area='$area',cedula='$cedula',actualizado='$actualizado',ultact='$fecha' WHERE id='$id'");

  $_SESSION['message'] = "El usuario ".$nombre.", Fue actualizado con exito!."; 

  header('location: postactaentrega.php?Generar='.$link.'');
}


}else{

  header("location: ../usr/login.php");

}

?>

<html lang="es">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../images/login.png">

    <title>Generar Acta</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="../bootstrap-4.1.0/css/bootstrap.css">
    <link href="../bootstrap-4.1.0/css/bootstrap1.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-4.1.0/css/floating-labels.css" rel="stylesheet">
  </head>

<body>
  <form method="post" action="actaentrega.php" enctype="multipart/form-data">
      <div class="text-center mb-4">
        <img class="mb-4" src="../images/login.svg" alt="" width="72" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Por favor, ingrese los siguientes datos:</h1>        
      </div>

    <div class="form-row">

      <div class="form-group col-md-9 offset-md-2 ">
        <div class="btn-group" role="group" aria-label="Basic example">
          <a class='btn btn-outline-danger' href="../db/consultaymodifica.php">Buscar y Modificar</a>
          <a class='btn btn-outline-primary' href="../index.php">Home</a>
          <a class='btn btn-outline-success' href='../db/editar.php?Editar=<?php echo "$id";?>'>Editar información de equipo</a>
        </div>


        <?php if (isset($_SESSION['message'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alerta">
           <?php echo "".$_SESSION['message'].""; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
         </div>
        <?php unset($_SESSION['message']); endif ?>       
      </div>

          <div>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
          </div>

      <div class="form-group col-md-1 offset-md-2"></div>
           <small id='tipoid' class='form-text text-muted'>Equipo entregado</small>
          <div class="form-group col-md-2">
        <select class="form-control" id="tipo" name="tipopc" aria-describedby="tipoid" required>
         <option></option>
         <option>Laptop</option>
         <option>Desktop</option>
        </select>        
      </div>



      <div class="form-label-group col-md-2">
        <input type="text" id="monitorid" class="form-control" placeholder="Marca monitor" name="monitor" <?php if($monitor === "no") :  ?>disabled<?php endif; ?> required>
        <label for="monitorid">Marca monitor</label> 
         <?php if($monitor === "no") :  ?>
         <small class='form-text text-muted'>Monitor no registrado</small> 
         <?php endif; ?>
         <?php if($monitor === "si") :  ?>
          <small class='form-text text-muted'>S/N: <?php echo "$smonitor";?></small>
          <?php endif; ?>      
      </div>
          
    <?php if($monitor === "no") :  ?>
          <div>
            <input type="hidden" name="monitor" value="">
            <input type="hidden" name="modelo" value="">
          </div>
    <?php endif; ?>
           

      <div class="form-label-group col-md-2">
        <input  name="modelo" id="modeloid" class="form-control" placeholder="Modelo del monitor" <?php if($monitor === "no") :  ?>disabled<?php endif; ?> required>
        <label for="modeloid">Modelo del monitor</label>
      </div>

       <div class="form-group col-md-1 offset-md-1"></div>
       <div class="form-group col-md-1 offset-md-1"></div>
           <small id='tecladolid' class='form-text text-muted'>Teclado</small>
          <div class="form-group col-md-1">
        <select class="form-control" id="tecladoid" name="teclado" aria-describedby="tecladolid" required>
         <option>No</option>
         <option>Si</option>
        </select>        
      </div>

      <div class="form-label-group col-md-3">
        <input type="text" id="stecladoid" class="form-control" placeholder="Serial del teclado" name="steclado">
        <label for="stecladoid">Serial del teclado</label>  
        <small class='form-text text-muted'>Llenar si es necesario</small>      
      </div>



           <small id='mouselid' class='form-text text-muted'>Mouse</small>
          <div class="form-group col-md-1">
        <select class="form-control" id="mouseid" name="mouse" aria-describedby="mouselid" required>
         <option>No</option>
         <option>Si</option>
        </select>        
      </div>

      <div class="form-label-group col-md-3">
        <input type="text" id="smouseid" class="form-control" placeholder="Serial del mouse" name="smouse" >
        <label for="smouseid">Serial del mouse</label>  
        <small class='form-text text-muted'>Llenar si es necesario</small>      
      </div>


      <div class="form-group col-md-1 offset-md-1"></div>
           <small id='baglid' class='form-text text-muted'>Maletín</small>
          <div class="form-group col-md-1">
        <select class="form-control" id="bagig" name="bag" aria-describedby="baglid" required>
         <option>No</option>
         <option>Si</option>
        </select>        
      </div>

           <small id='guayalid' class='form-text text-muted'>Guaya</small>
          <div class="form-group col-md-1">
        <select class="form-control" id="guayaid" name="guaya" aria-describedby="guayalid" required>
         <option>No</option>
         <option>Si</option>
        </select>        
      </div>

           <small id='cdlid' class='form-text text-muted'>Unidad de CD/DVD</small>
          <div class="form-group col-md-1">
        <select class="form-control" id="cdid1" name="cdoption" aria-describedby="cdlid" required>
         <option>No</option>
         <option>Si</option>
        </select>        
      </div>

      <div class="form-label-group col-md-3">
        <input type="text" id="cdid" class="form-control" placeholder="Unidad de CD/DVD" name="scd" >
        <label for="cdid">Unidad de CD/DVD</label>  
        <small class='form-text text-muted'>Llenar si es necesario</small>      
      </div>


      <div class="form-label-group col-md-5 offset-md-1">
        <input type="text" id="otrosid" class="form-control" placeholder="Otros:" name="otros" >
        <label for="otrosid">Otros:</label>  
        <small class='form-text text-muted'>Llenar si es necesario</small>      
      </div>

         <div class="form-label-group col-md-5">
        <input type="text" id="observacionesid" class="form-control" placeholder="Observaciones:" name="observaciones" >
        <label for="observacionesid">Observaciones:</label>  
        <small class='form-text text-muted'>Llenar si es necesario</small>      
      </div>




 
       <div class="btn-group offset-md-5" role="group" aria-label="Basic example">
        <button type="submit" name="generaracta" class="btn btn-primary">Generar acta</button>
        <a class='btn btn-outline-secondary' href="../index.php">Cancelar</a>
      </div>

      
    </div>
  </form>

<div class='modal fade' id='updateuser' tabindex='-1' role='dialog' aria-hidden='true' data-backdrop="static">
  <div class='modal-dialog modal-dialog-centered' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='updateuserid'>Actualizar usuario</h5>
      </div>
      <div class='modal-body'>
        Para generar el acta, debe registrar la siguiente información del usuario <?php echo "$usuario";?> :
        <form  method="POST" enctype="multipart/form-data">
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
           <a class='btn btn-secondary' href="../db/consultaymodifica.php">Cancelar</a>
           <button type="submit" name="actualiza-user" class="btn btn-primary">Actualizar información</button>
         </div>
        </form>
      </div>
    </div>
  </div>
</div>


<div class='modal fade' id='nouser' tabindex='-1' role='dialog' aria-hidden='true' data-backdrop="static">
  <div class='modal-dialog modal-dialog-centered' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='nouserid'>Usuario no registrado</h5>
      </div>
      <div class='modal-body'>
        El serial <?php echo "$serial";?>, no tiene ningún usuario registrado. Es necesario registrarlo para generar el acta.
        Tener en cuenta que el nombre de equipo también es requerido.


         <div class='modal-footer'>
           <a class='btn btn-secondary' href="../db/consultaymodifica.php">Cancelar</a>
<a class='btn btn-outline-success' href='../db/editar.php?Editar=<?php echo "$id";?>'>Editar información de equipo</a>
         </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class='modal fade' id='nonamepc' tabindex='-1' role='dialog' aria-hidden='true' data-backdrop="static">
  <div class='modal-dialog modal-dialog-centered' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='nonamepcid'>Nombre de equipo requerido</h5>
      </div>
      <div class='modal-body'>
        El serial <?php echo "$serial";?>, no tiene nombre de equipo registrado. Es necesario registrarlo para generar el acta.


         <div class='modal-footer'>
           <a class='btn btn-secondary' href="../db/consultaymodifica.php">Cancelar</a>
<a class='btn btn-outline-success' href='../db/editar.php?Editar=<?php echo "$id";?>'>Editar información de equipo</a>
         </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../bootstrap-4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="../bootstrap-4.1.0/js/bootstrap.min.js"></script>
<script src="../js/jquery-ui-git.js"></script>
<link rel="stylesheet"  href="../css/jquery-ui-git.css">

<?php 

  if($usuario === "no"){
    echo '<script>
$(document).ready(function()
{
  
  $("#nouser").modal("show");
});
</script>';

}else{
    
if($nombreequipo === "no"){
  echo '<script>
$(document).ready(function()
{
  
  $("#nonamepc").modal("show");
});
</script>';
}else{
if($usuariock === "no validado") {
  echo '
<script>
$(document).ready(function()
{
  
  $("#updateuser").modal("show");
});
</script>'; 
  }
}
}

?>




    <script>

     $(document).ready(function() {

      $('#lastuser').autocomplete({

        source: function(request, response){

          $.ajax({

            url:"atname.php",

            dataType:"json",

            data:{q:request.term},

            success: function(data){

              response(data);

            }

          });

        },

      minLength:1,

      select: function(event, ui){

        
      }

      });

     });

    </script>
    
    <script>

     $(document).ready(function() {

      $('#ubii').autocomplete({

        source: function(request, response){

          $.ajax({

            url:"fill-location.php",

            dataType:"json",

            data:{q:request.term},

            success: function(data){

              response(data);

            }

          });

        },

      minLength:1,

      select: function(event, ui){

        
      }

      });

     });

    </script>


</body>

</html>

<?php

ob_end_flush();

?>