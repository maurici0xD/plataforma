<?php

ob_start();

?>

<?php

session_start();

if (isset($_SESSION['username'])) {

  date_default_timezone_set('America/Bogota');

  $fecha = date("d-m-Y g:i:s A");

  setlocale(LC_TIME, 'es_CO.UTF-8');
  $fechabase = $fecha;
  $fechaimprime = strftime("%A %e de %B de %Y", strtotime($fechabase));
  $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $fechaimprime = date("d") . " de " . $meses[date('n') - 1] . " de " . date("Y");
  include('../db/conexion.php');
  include('../db/conexionGLPI.php');




  if (isset($_POST['generaracta'])) {

  }

  if (isset($_POST['generaractaeditar'])) {
    $id = $_POST['id'];
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
    glpi.glpi_users.phone2 as empresa,
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
    WHERE glpi.glpi_computers.id='$id'";
    $resultadoglpi = mysqli_query($conglpi, $queryglpi);
    if ($rowm = $resultadoglpi->fetch_assoc()) {
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
  }

  $modelopc = $rowm['modelo'];
  $querymodelo = "SELECT * FROM $tabla6 WHERE modelo_glpi = '$modelopc'";
  $resultadomodelo = mysqli_query($con, $querymodelo);
  if ($modeloconsulta = $resultadomodelo->fetch_assoc()) {
      $modelotraducido = $modeloconsulta['modelo'];
      $tipopcglpi = $modeloconsulta['tipo'];
  }
  //TIPO COMPUTADOR, LAPTOP, DESKTOP, IMAC ETZ
    $tipopc = $tipopcglpi;

    //CONSULTA DE LOS DATOS DE LA PANTALLA
    $serialpantalla = $_POST['pantallaserial'];
    if ($serialpantalla==""){
    
    }else{
    $querymonitor = "SELECT 
    glpi.glpi_monitors.name as modelomonitor,
    glpi.glpi_manufacturers.name as marcamonitor
    FROM glpi.glpi_monitors
    left join glpi.glpi_manufacturers on glpi.glpi_manufacturers.id=glpi_monitors.manufacturers_id WHERE glpi_monitors.serial='$serialpantalla'";
    $resmonitor = mysqli_query($conglpi, $querymonitor);
    while ($monitor = $resmonitor->fetch_assoc()) {
      $marcamonitor=$monitor['marcamonitor'];
      $modelomonitor=$monitor['modelomonitor'];
    }
    }

    $marcapantalla = strtoupper($marcamonitor);
    $modelopantalla = strtoupper($modelomonitor);
    $teclado = $rowm['tecladoglpi'];
    $serialteclado = strtoupper($rowm['tecladoserialglpi']);
    $mouse = $rowm['mouseglpi'];
    $serialmouse = strtoupper($rowm['mouseserialglpi']);
    $maletin = $rowm['bolsoglpi'];
    $guaya = $rowm['guayaglpi'];
    $satechi = $rowm['adaptadorglpi'];
    $otros = ucfirst(strtolower($rowm['otrosglpi']));
    $observaciones = strtoupper($_POST['observaciones']);
    $tipoacta = 'entrega';
    $cable = $rowm['cablelightningglpi'];
    $cargador = $rowm['cargadorglpi'];
    $base = $rowm['baseglpi'];

      $placa = $rowm['placa'];
      $nombreequipo = $rowm['nombre'];
      $marcapc = $rowm['marca'];
      $modelopc = $modelotraducido;
      $serialpc = $rowm['serial'];
      $procesadorglpi = $rowm['procesador'];
      $discoglpi1 = round($rowm['disco']/1000);
      $discoglpi = $discoglpi1." GB";
      $ramglpi1 = round($rowm['ram']/1000);
      $ramglpi = $ramglpi1." GB";

      $recordck = "SELECT * FROM $tabla11 WHERE id_glpi='$id'";
      $result = mysqli_query($con, $recordck);
      $filaas = mysqli_num_rows($result);
    
      if ($filaas > 0) {
        while ($resultadodisco = $result->fetch_array()) {
          $discoduro = $resultadodisco['disco'];
          $ram = $resultadodisco['ram'];
          $procesador = $resultadodisco['procesador'];
        }
      }else{
        $discoduro = $ramglpi;
        $ram = $discoglpi;
        $procesador = $procesadorglpi;
      }
      $sistema = $rowm['sistemaversion'];
      $pos = strpos($sistema, ' ');
      if ($pos !== false) {
        $sistema2 = substr($sistema, 0, $pos);
      } else {
        $sistema2 = $rowm['sistemaversion'];
      }
    
      $cargo = $rowm['cargo'];
      $area = $rowm['area'];
      $cedula = $rowm['cedula'];
      $usuario = $rowm['nombreusuario'] ." ". $rowm['apellido'];
    

    $query4 = "SELECT * FROM $tabla7 WHERE sistema_glpi = '$sistema2'";
    $resultado4 = mysqli_query($con, $query4);
    if ($sistemaconsulta = $resultado4->fetch_assoc()) {
      $sistematraducido = $sistemaconsulta['nombre'];
    }

    $itusuario = $_SESSION['username'];
    $query3 = "SELECT * FROM $tabla1 WHERE nombre = '$itusuario' ";
    $resultado3 = mysqli_query($con, $query3);
    if ($fila3 = $resultado3->fetch_assoc()) {
      $itcargo = $fila3['cargo'];
      $itcedula = $fila3['cedula'];
    }
    $nombreacta = "Acta Entrega ".$usuario." ".date("d-m-Y");
    $check7 = "SELECT * FROM $tabla5 WHERE actaid='$id' AND tipoacta='$tipoacta' ";
    $resultado7 = mysqli_query($con, $check7);

    if (mysqli_num_rows($resultado7) > 0) {
      $query = $con->query("UPDATE $tabla5 SET actaid='$id',tipo='$tipopc',maleta='$maletin',guaya='$guaya',teclado='$teclado',mouse='$mouse',satechi='$satechi',tecladosn='$serialteclado',mousesn='$serialmouse',monitormarca='$marcapantalla',monitormodelo='$modelopantalla',otros='$otros',observaciones='$observaciones',cargador='$cargador',cable_lightning='$cable',base='$base' WHERE actaid='$id' AND tipoacta='$tipoacta'");
    } else {
      $query = $con->query("INSERT INTO $tabla5 (actaid,tipo,tipoacta,satechi,maleta,guaya,teclado,mouse,tecladosn,mousesn,monitormarca,monitormodelo,otros,observaciones,cargador,cable_lightning,base) VALUES ('$id','$tipopc','$tipoacta','$satechi','$maletin','$guaya','$teclado','$mouse','$serialteclado','$serialmouse','$marcapantalla','$modelopantalla','$otros','$observaciones','$cargador','$cable','$base')");
    }
  }
} else {

  header("location: ../usr/login.php");
}


?>

<html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"
    xmlns:w="urn:schemas-microsoft-com:office:word" xmlns:dt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"
    xmlns:m="http://schemas.microsoft.com/office/2004/12/omml" xmlns="http://www.w3.org/TR/REC-html40">

<head>
    <meta http-equiv=Content-Type content="text/html; charset=unicode">
    <meta name=ProgId content=Word.Document>
    <meta name=Generator content="Microsoft Word 15">
    <meta name=Originator content="Microsoft Word 15">
    <link rel=File-List href="acta_entrega.fld/filelist.xml">
    <link rel=Edit-Time-Data href="acta_entrega.fld/editdata.mso">
    <link rel="icon" href="../Login/favicon.png">
    <title><?php echo $nombreacta; ?></title>
    <!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
    <!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Online2PDF.com</o:Author>
  <o:LastAuthor>Mauricio Rios Ortiz (DDB Group Medellin)</o:LastAuthor>
  <o:Revision>19</o:Revision>
  <o:TotalTime>7</o:TotalTime>
  <o:LastPrinted>2022-06-21T20:46:00Z</o:LastPrinted>
  <o:Created>2022-06-23T15:36:00Z</o:Created>
  <o:LastSaved>2022-06-23T15:57:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>342</o:Words>
  <o:Characters>1887</o:Characters>
  <o:Lines>15</o:Lines>
  <o:Paragraphs>4</o:Paragraphs>
  <o:CharactersWithSpaces>2225</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
 <o:CustomDocumentProperties>
  <o:Created dt:dt="date">2022-06-15</o:Created>
  <o:LastSaved dt:dt="date">2022-06-15</o:LastSaved>
 </o:CustomDocumentProperties>
</xml><![endif]-->
    <link rel=dataStoreItem href="acta_entrega.fld/item0011.xml" target="acta_entrega.fld/props012.xml">
    <link rel=themeData href="acta_entrega.fld/themedata.thmx">
    <link rel=colorSchemeMapping href="acta_entrega.fld/colorschememapping.xml">
    <!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:HyphenationZone>21</w:HyphenationZone>
  <w:PunctuationKerning/>
  <w:DrawingGridHorizontalSpacing>5,5 pto</w:DrawingGridHorizontalSpacing>
  <w:DisplayHorizontalDrawingGridEvery>2</w:DisplayHorizontalDrawingGridEvery>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>DE-AT</w:LidThemeOther>
  <w:LidThemeAsian>ZH-CN</w:LidThemeAsian>
  <w:LidThemeComplexScript>AR-SA</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:ULTrailSpace/>
   <w:BreakWrappedTables/>
   <w:SnapToGridInCell/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
   <w:DontFlipMirrorIndents/>
   <w:OverrideTableStyleHps/>
  </w:Compatibility>
  <w:DoNotOptimizeForBrowser/>
  <m:mathPr>
   <m:mathFont m:val="Cambria Math"/>
   <m:brkBin m:val="before"/>
   <m:brkBinSub m:val="&#45;-"/>
   <m:smallFrac m:val="off"/>
   <m:dispDef/>
   <m:lMargin m:val="0"/>
   <m:rMargin m:val="0"/>
   <m:defJc m:val="centerGroup"/>
   <m:wrapIndent m:val="1440"/>
   <m:intLim m:val="subSup"/>
   <m:naryLim m:val="undOvr"/>
  </m:mathPr></w:WordDocument>
</xml><![endif]-->
    <!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="false"
  DefSemiHidden="false" DefQFormat="false" DefPriority="99"
  LatentStyleCount="376">
  <w:LsdException Locked="false" Priority="1" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" Priority="9" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" Priority="9" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index 9"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 1"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 2"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 3"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 4"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 5"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 6"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 7"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 8"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" Name="toc 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footnote text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="header"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footer"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="index heading"/>
  <w:LsdException Locked="false" Priority="35" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="table of figures"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="envelope address"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="envelope return"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="footnote reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="line number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="page number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="endnote reference"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="endnote text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="table of authorities"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="macro"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="toa heading"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Bullet 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Number 5"/>
  <w:LsdException Locked="false" Priority="10" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Closing"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Signature"/>
  <w:LsdException Locked="false" Priority="1" SemiHidden="true"
   UnhideWhenUsed="true" Name="Default Paragraph Font"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="List Continue 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Message Header"/>
  <w:LsdException Locked="false" Priority="11" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Salutation"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Date"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text First Indent"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text First Indent 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Note Heading"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Body Text Indent 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Block Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Hyperlink"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="FollowedHyperlink"/>
  <w:LsdException Locked="false" Priority="22" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" Priority="20" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Document Map"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Plain Text"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="E-mail Signature"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Top of Form"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Bottom of Form"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal (Web)"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Acronym"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Address"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Cite"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Code"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Definition"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Keyboard"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Preformatted"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Sample"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Typewriter"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Variable"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Table"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="annotation subject"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="No List"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Outline List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Simple 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Classic 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Colorful 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Columns 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Grid 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table List 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table 3D effects 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Contemporary"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Elegant"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Professional"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Subtle 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Subtle 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Web 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Balloon Text"/>
  <w:LsdException Locked="false" Priority="59" Name="Table Grid"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Theme"/>
  <w:LsdException Locked="false" SemiHidden="true" Name="Placeholder Text"/>
  <w:LsdException Locked="false" Priority="1" QFormat="true" Name="No Spacing"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 1"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 1"/>
  <w:LsdException Locked="false" SemiHidden="true" Name="Revision"/>
  <w:LsdException Locked="false" Priority="1" QFormat="true"
   Name="List Paragraph"/>
  <w:LsdException Locked="false" Priority="29" QFormat="true" Name="Quote"/>
  <w:LsdException Locked="false" Priority="30" QFormat="true"
   Name="Intense Quote"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 1"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 1"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 1"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 1"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 1"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 2"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 2"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 2"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 2"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 2"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 2"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 3"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 3"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 3"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 3"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 3"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 3"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 4"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 4"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 4"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 4"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 4"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 4"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 5"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 5"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 5"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 5"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 5"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 5"/>
  <w:LsdException Locked="false" Priority="60" Name="Light Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="61" Name="Light List Accent 6"/>
  <w:LsdException Locked="false" Priority="62" Name="Light Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="63" Name="Medium Shading 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="64" Name="Medium Shading 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="65" Name="Medium List 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="66" Name="Medium List 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="67" Name="Medium Grid 1 Accent 6"/>
  <w:LsdException Locked="false" Priority="68" Name="Medium Grid 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="69" Name="Medium Grid 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="70" Name="Dark List Accent 6"/>
  <w:LsdException Locked="false" Priority="71" Name="Colorful Shading Accent 6"/>
  <w:LsdException Locked="false" Priority="72" Name="Colorful List Accent 6"/>
  <w:LsdException Locked="false" Priority="73" Name="Colorful Grid Accent 6"/>
  <w:LsdException Locked="false" Priority="19" QFormat="true"
   Name="Subtle Emphasis"/>
  <w:LsdException Locked="false" Priority="21" QFormat="true"
   Name="Intense Emphasis"/>
  <w:LsdException Locked="false" Priority="31" QFormat="true"
   Name="Subtle Reference"/>
  <w:LsdException Locked="false" Priority="32" QFormat="true"
   Name="Intense Reference"/>
  <w:LsdException Locked="false" Priority="33" QFormat="true" Name="Book Title"/>
  <w:LsdException Locked="false" Priority="37" SemiHidden="true"
   UnhideWhenUsed="true" Name="Bibliography"/>
  <w:LsdException Locked="false" Priority="39" SemiHidden="true"
   UnhideWhenUsed="true" QFormat="true" Name="TOC Heading"/>
  <w:LsdException Locked="false" Priority="41" Name="Plain Table 1"/>
  <w:LsdException Locked="false" Priority="42" Name="Plain Table 2"/>
  <w:LsdException Locked="false" Priority="43" Name="Plain Table 3"/>
  <w:LsdException Locked="false" Priority="44" Name="Plain Table 4"/>
  <w:LsdException Locked="false" Priority="45" Name="Plain Table 5"/>
  <w:LsdException Locked="false" Priority="40" Name="Grid Table Light"/>
  <w:LsdException Locked="false" Priority="46" Name="Grid Table 1 Light"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark"/>
  <w:LsdException Locked="false" Priority="51" Name="Grid Table 6 Colorful"/>
  <w:LsdException Locked="false" Priority="52" Name="Grid Table 7 Colorful"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 1"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 1"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 1"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 2"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 2"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 2"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 3"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 3"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 3"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 4"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 4"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 4"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 5"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 5"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 5"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="46"
   Name="Grid Table 1 Light Accent 6"/>
  <w:LsdException Locked="false" Priority="47" Name="Grid Table 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="48" Name="Grid Table 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="49" Name="Grid Table 4 Accent 6"/>
  <w:LsdException Locked="false" Priority="50" Name="Grid Table 5 Dark Accent 6"/>
  <w:LsdException Locked="false" Priority="51"
   Name="Grid Table 6 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="52"
   Name="Grid Table 7 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="46" Name="List Table 1 Light"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark"/>
  <w:LsdException Locked="false" Priority="51" Name="List Table 6 Colorful"/>
  <w:LsdException Locked="false" Priority="52" Name="List Table 7 Colorful"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 1"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 1"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 1"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 1"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 1"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 1"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 2"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 2"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 2"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 2"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 2"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 2"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 3"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 3"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 3"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 3"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 3"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 3"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 4"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 4"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 4"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 4"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 4"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 4"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 5"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 5"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 5"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 5"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 5"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 5"/>
  <w:LsdException Locked="false" Priority="46"
   Name="List Table 1 Light Accent 6"/>
  <w:LsdException Locked="false" Priority="47" Name="List Table 2 Accent 6"/>
  <w:LsdException Locked="false" Priority="48" Name="List Table 3 Accent 6"/>
  <w:LsdException Locked="false" Priority="49" Name="List Table 4 Accent 6"/>
  <w:LsdException Locked="false" Priority="50" Name="List Table 5 Dark Accent 6"/>
  <w:LsdException Locked="false" Priority="51"
   Name="List Table 6 Colorful Accent 6"/>
  <w:LsdException Locked="false" Priority="52"
   Name="List Table 7 Colorful Accent 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Mention"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Smart Hyperlink"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Hashtag"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Unresolved Mention"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Smart Link"/>
 </w:LatentStyles>
</xml><![endif]-->
    <style>
    <!--
    /* Font Definitions */
    @font-face {
        font-family: "Cambria Math";
        panose-1: 2 4 5 3 5 4 6 3 2 4;
        mso-font-charset: 0;
        mso-generic-font-family: roman;
        mso-font-pitch: variable;
        mso-font-signature: 3 0 0 0 1 0;
    }

    @font-face {
        font-family: Calibri;
        panose-1: 2 15 5 2 2 2 4 3 2 4;
        mso-font-charset: 0;
        mso-generic-font-family: swiss;
        mso-font-pitch: variable;
        mso-font-signature: -536859905 -1073732485 9 0 511 0;
    }

    @font-face {
        font-family: Tahoma;
        panose-1: 2 11 6 4 3 5 4 4 2 4;
        mso-font-charset: 0;
        mso-generic-font-family: swiss;
        mso-font-pitch: variable;
        mso-font-signature: -520081665 -1073717157 41 0 66047 0;
    }

    @font-face {
        font-family: Consolas;
        src: url("Consolas.ttf");
        panose-1: 2 11 6 9 2 2 4 3 2 4;
        mso-font-charset: 0;
        mso-generic-font-family: modern;
        mso-font-pitch: fixed;
        mso-font-signature: -520092929 1073806591 9 0 415 0;
    }

    /* Style Definitions */
    p.MsoNormal,
    li.MsoNormal,
    div.MsoNormal {
        mso-style-priority: 1;
        mso-style-unhide: no;
        mso-style-qformat: yes;
        mso-style-parent: "";
        margin: 0cm;
        mso-pagination: none;
        font-size: 11.0pt;
        font-family: "Calibri", sans-serif;
        mso-ascii-font-family: Calibri;
        mso-ascii-theme-font: minor-latin;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-hansi-font-family: Calibri;
        mso-hansi-theme-font: minor-latin;
        mso-bidi-font-family: "Times New Roman";
        mso-bidi-theme-font: minor-bidi;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    p.MsoHeader,
    li.MsoHeader,
    div.MsoHeader {
        mso-style-noshow: yes;
        mso-style-priority: 99;
        mso-style-link: "Encabezado Car";
        margin: 0cm;
        mso-pagination: none;
        tab-stops: center 212.6pt right 425.2pt;
        font-size: 11.0pt;
        font-family: "Calibri", sans-serif;
        mso-ascii-font-family: Calibri;
        mso-ascii-theme-font: minor-latin;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-hansi-font-family: Calibri;
        mso-hansi-theme-font: minor-latin;
        mso-bidi-font-family: "Times New Roman";
        mso-bidi-theme-font: minor-bidi;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    p.MsoFooter,
    li.MsoFooter,
    div.MsoFooter {
        mso-style-noshow: yes;
        mso-style-priority: 99;
        mso-style-link: "Pie de página Car";
        margin: 0cm;
        mso-pagination: none;
        tab-stops: center 212.6pt right 425.2pt;
        font-size: 11.0pt;
        font-family: "Calibri", sans-serif;
        mso-ascii-font-family: Calibri;
        mso-ascii-theme-font: minor-latin;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-hansi-font-family: Calibri;
        mso-hansi-theme-font: minor-latin;
        mso-bidi-font-family: "Times New Roman";
        mso-bidi-theme-font: minor-bidi;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    p.MsoAcetate,
    li.MsoAcetate,
    div.MsoAcetate {
        mso-style-noshow: yes;
        mso-style-priority: 99;
        mso-style-link: "Texto de globo Car";
        margin: 0cm;
        mso-pagination: none;
        font-size: 8.0pt;
        font-family: "Tahoma", sans-serif;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    p.MsoListParagraph,
    li.MsoListParagraph,
    div.MsoListParagraph {
        mso-style-priority: 1;
        mso-style-unhide: no;
        mso-style-qformat: yes;
        margin: 0cm;
        mso-pagination: none;
        font-size: 11.0pt;
        font-family: "Calibri", sans-serif;
        mso-ascii-font-family: Calibri;
        mso-ascii-theme-font: minor-latin;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-hansi-font-family: Calibri;
        mso-hansi-theme-font: minor-latin;
        mso-bidi-font-family: "Times New Roman";
        mso-bidi-theme-font: minor-bidi;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    p.msonormal0,
    li.msonormal0,
    div.msonormal0 {
        mso-style-name: msonormal;
        mso-style-unhide: no;
        mso-margin-top-alt: auto;
        margin-right: 0cm;
        mso-margin-bottom-alt: auto;
        margin-left: 0cm;
        mso-pagination: widow-orphan;
        font-size: 12.0pt;
        font-family: "Times New Roman", serif;
        mso-fareast-font-family: "Times New Roman";
        mso-fareast-theme-font: minor-fareast;
    }

    span.EncabezadoCar {
        mso-style-name: "Encabezado Car";
        mso-style-noshow: yes;
        mso-style-priority: 99;
        mso-style-unhide: no;
        mso-style-locked: yes;
        mso-style-link: Encabezado;
    }

    span.PiedepginaCar {
        mso-style-name: "Pie de página Car";
        mso-style-noshow: yes;
        mso-style-priority: 99;
        mso-style-unhide: no;
        mso-style-locked: yes;
        mso-style-link: "Pie de página";
    }

    span.TextodegloboCar {
        mso-style-name: "Texto de globo Car";
        mso-style-noshow: yes;
        mso-style-priority: 99;
        mso-style-unhide: no;
        mso-style-locked: yes;
        mso-style-link: "Texto de globo";
        mso-ansi-font-size: 8.0pt;
        mso-bidi-font-size: 8.0pt;
        font-family: "Tahoma", sans-serif;
        mso-ascii-font-family: Tahoma;
        mso-hansi-font-family: Tahoma;
        mso-bidi-font-family: Tahoma;
    }

    p.TableParagraph,
    li.TableParagraph,
    div.TableParagraph {
        mso-style-name: "Table Paragraph";
        mso-style-priority: 1;
        mso-style-unhide: no;
        mso-style-qformat: yes;
        margin: 0cm;
        mso-pagination: none;
        font-size: 11.0pt;
        font-family: "Calibri", sans-serif;
        mso-ascii-font-family: Calibri;
        mso-ascii-theme-font: minor-latin;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-hansi-font-family: Calibri;
        mso-hansi-theme-font: minor-latin;
        mso-bidi-font-family: "Times New Roman";
        mso-bidi-theme-font: minor-bidi;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    span.SpellE {
        mso-style-name: "";
        mso-spl-e: yes;
    }

    span.GramE {
        mso-style-name: "";
        mso-gram-e: yes;
    }

    .MsoChpDefault {
        mso-style-type: export-only;
        mso-default-props: yes;
        font-size: 11.0pt;
        mso-ansi-font-size: 11.0pt;
        mso-bidi-font-size: 11.0pt;
        font-family: "Calibri", sans-serif;
        mso-ascii-font-family: Calibri;
        mso-ascii-theme-font: minor-latin;
        mso-fareast-font-family: Calibri;
        mso-fareast-theme-font: minor-latin;
        mso-hansi-font-family: Calibri;
        mso-hansi-theme-font: minor-latin;
        mso-bidi-font-family: "Times New Roman";
        mso-bidi-theme-font: minor-bidi;
        mso-ansi-language: EN-US;
        mso-fareast-language: EN-US;
    }

    /* Page Definitions */
    @page {
        mso-footnote-separator: url("acta_entrega.fld/header.html") fs;
        mso-footnote-continuation-separator: url("acta_entrega.fld/header.html") fcs;
        mso-endnote-separator: url("acta_entrega.fld/header.html") es;
        mso-endnote-continuation-separator: url("acta_entrega.fld/header.html") ecs;
    }

    @page WordSection1 {
        size: 595.5pt 842.0pt;
        margin: 36.0pt 14.2pt 36.0pt 14.2pt;
        mso-header-margin: 36.0pt;
        mso-footer-margin: 36.0pt;
        mso-paper-source: 0;
    }

    div.WordSection1 {
        page: WordSection1;
    }
    -->
    </style>
    <!--[if gte mso 10]>
<style>
 /* Style Definitions */
 table.MsoNormalTable
	{mso-style-name:"Tabla normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:99;
	mso-style-parent:"";
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTableGrid
	{mso-style-name:"Tabla con cuadrícula";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-priority:59;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTable15Plain1
	{mso-style-name:"Tabla normal 1";
	mso-tstyle-rowband-size:1;
	mso-tstyle-colband-size:1;
	mso-style-priority:41;
	mso-style-unhide:no;
	border:solid #BFBFBF 1.0pt;
	mso-border-themecolor:background1;
	mso-border-themeshade:191;
	mso-border-alt:solid #BFBFBF .5pt;
	mso-border-themecolor:background1;
	mso-border-themeshade:191;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid #BFBFBF;
	mso-border-insideh-themecolor:background1;
	mso-border-insideh-themeshade:191;
	mso-border-insidev:.5pt solid #BFBFBF;
	mso-border-insidev-themecolor:background1;
	mso-border-insidev-themeshade:191;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTable15Plain1FirstRow
	{mso-style-name:"Tabla normal 1";
	mso-table-condition:first-row;
	mso-style-priority:41;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain1LastRow
	{mso-style-name:"Tabla normal 1";
	mso-table-condition:last-row;
	mso-style-priority:41;
	mso-style-unhide:no;
	mso-tstyle-border-top:1.5pt double #BFBFBF;
	mso-tstyle-border-top-themecolor:background1;
	mso-tstyle-border-top-themeshade:191;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain1FirstCol
	{mso-style-name:"Tabla normal 1";
	mso-table-condition:first-column;
	mso-style-priority:41;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain1LastCol
	{mso-style-name:"Tabla normal 1";
	mso-table-condition:last-column;
	mso-style-priority:41;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain1OddColumn
	{mso-style-name:"Tabla normal 1";
	mso-table-condition:odd-column;
	mso-style-priority:41;
	mso-style-unhide:no;
	mso-tstyle-shading:#F2F2F2;
	mso-tstyle-shading-themecolor:background1;
	mso-tstyle-shading-themeshade:242;}
table.MsoTable15Plain1OddRow
	{mso-style-name:"Tabla normal 1";
	mso-table-condition:odd-row;
	mso-style-priority:41;
	mso-style-unhide:no;
	mso-tstyle-shading:#F2F2F2;
	mso-tstyle-shading-themecolor:background1;
	mso-tstyle-shading-themeshade:242;}
table.MsoTable15Plain2
	{mso-style-name:"Tabla normal 2";
	mso-tstyle-rowband-size:1;
	mso-tstyle-colband-size:1;
	mso-style-priority:42;
	mso-style-unhide:no;
	border-top:solid #7F7F7F 1.0pt;
	mso-border-top-themecolor:text1;
	mso-border-top-themetint:128;
	border-left:none;
	border-bottom:solid #7F7F7F 1.0pt;
	mso-border-bottom-themecolor:text1;
	mso-border-bottom-themetint:128;
	border-right:none;
	mso-border-top-alt:solid #7F7F7F .5pt;
	mso-border-top-themecolor:text1;
	mso-border-top-themetint:128;
	mso-border-bottom-alt:solid #7F7F7F .5pt;
	mso-border-bottom-themecolor:text1;
	mso-border-bottom-themetint:128;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTable15Plain2FirstRow
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:first-row;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-tstyle-border-bottom:.5pt solid #7F7F7F;
	mso-tstyle-border-bottom-themecolor:text1;
	mso-tstyle-border-bottom-themetint:128;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain2LastRow
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:last-row;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-tstyle-border-top:.5pt solid #7F7F7F;
	mso-tstyle-border-top-themecolor:text1;
	mso-tstyle-border-top-themetint:128;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain2FirstCol
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:first-column;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain2LastCol
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:last-column;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain2OddColumn
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:odd-column;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-tstyle-border-left:.5pt solid #7F7F7F;
	mso-tstyle-border-left-themecolor:text1;
	mso-tstyle-border-left-themetint:128;
	mso-tstyle-border-right:.5pt solid #7F7F7F;
	mso-tstyle-border-right-themecolor:text1;
	mso-tstyle-border-right-themetint:128;}
table.MsoTable15Plain2EvenColumn
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:even-column;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-tstyle-border-left:.5pt solid #7F7F7F;
	mso-tstyle-border-left-themecolor:text1;
	mso-tstyle-border-left-themetint:128;
	mso-tstyle-border-right:.5pt solid #7F7F7F;
	mso-tstyle-border-right-themecolor:text1;
	mso-tstyle-border-right-themetint:128;}
table.MsoTable15Plain2OddRow
	{mso-style-name:"Tabla normal 2";
	mso-table-condition:odd-row;
	mso-style-priority:42;
	mso-style-unhide:no;
	mso-tstyle-border-top:.5pt solid #7F7F7F;
	mso-tstyle-border-top-themecolor:text1;
	mso-tstyle-border-top-themetint:128;
	mso-tstyle-border-bottom:.5pt solid #7F7F7F;
	mso-tstyle-border-bottom-themecolor:text1;
	mso-tstyle-border-bottom-themetint:128;}
table.MsoTable15Plain4
	{mso-style-name:"Tabla normal 4";
	mso-tstyle-rowband-size:1;
	mso-tstyle-colband-size:1;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTable15Plain4FirstRow
	{mso-style-name:"Tabla normal 4";
	mso-table-condition:first-row;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain4LastRow
	{mso-style-name:"Tabla normal 4";
	mso-table-condition:last-row;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain4FirstCol
	{mso-style-name:"Tabla normal 4";
	mso-table-condition:first-column;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain4LastCol
	{mso-style-name:"Tabla normal 4";
	mso-table-condition:last-column;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Plain4OddColumn
	{mso-style-name:"Tabla normal 4";
	mso-table-condition:odd-column;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-tstyle-shading:#F2F2F2;
	mso-tstyle-shading-themecolor:background1;
	mso-tstyle-shading-themeshade:242;}
table.MsoTable15Plain4OddRow
	{mso-style-name:"Tabla normal 4";
	mso-table-condition:odd-row;
	mso-style-priority:44;
	mso-style-unhide:no;
	mso-tstyle-shading:#F2F2F2;
	mso-tstyle-shading-themecolor:background1;
	mso-tstyle-shading-themeshade:242;}
table.MsoTableGridLight
	{mso-style-name:"Tabla con cuadrícula clara";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-priority:40;
	mso-style-unhide:no;
	border:solid #BFBFBF 1.0pt;
	mso-border-themecolor:background1;
	mso-border-themeshade:191;
	mso-border-alt:solid #BFBFBF .5pt;
	mso-border-themecolor:background1;
	mso-border-themeshade:191;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid #BFBFBF;
	mso-border-insideh-themecolor:background1;
	mso-border-insideh-themeshade:191;
	mso-border-insidev:.5pt solid #BFBFBF;
	mso-border-insidev-themecolor:background1;
	mso-border-insidev-themeshade:191;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTable15Grid2
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-tstyle-rowband-size:1;
	mso-tstyle-colband-size:1;
	mso-style-priority:47;
	mso-style-unhide:no;
	border-top:solid #666666 1.0pt;
	mso-border-top-themecolor:text1;
	mso-border-top-themetint:153;
	border-left:none;
	border-bottom:solid #666666 1.0pt;
	mso-border-bottom-themecolor:text1;
	mso-border-bottom-themetint:153;
	border-right:none;
	mso-border-top-alt:solid #666666 .25pt;
	mso-border-top-themecolor:text1;
	mso-border-top-themetint:153;
	mso-border-bottom-alt:solid #666666 .25pt;
	mso-border-bottom-themecolor:text1;
	mso-border-bottom-themetint:153;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.25pt solid #666666;
	mso-border-insideh-themecolor:text1;
	mso-border-insideh-themetint:153;
	mso-border-insidev:.25pt solid #666666;
	mso-border-insidev-themecolor:text1;
	mso-border-insidev-themetint:153;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
table.MsoTable15Grid2FirstRow
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-table-condition:first-row;
	mso-style-priority:47;
	mso-style-unhide:no;
	mso-tstyle-shading:white;
	mso-tstyle-shading-themecolor:background1;
	mso-tstyle-border-top:cell-none;
	mso-tstyle-border-bottom:1.5pt solid #666666;
	mso-tstyle-border-bottom-themecolor:text1;
	mso-tstyle-border-bottom-themetint:153;
	mso-tstyle-border-insideh:cell-none;
	mso-tstyle-border-insidev:cell-none;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Grid2LastRow
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-table-condition:last-row;
	mso-style-priority:47;
	mso-style-unhide:no;
	mso-tstyle-shading:white;
	mso-tstyle-shading-themecolor:background1;
	mso-tstyle-border-top:.75pt double #666666;
	mso-tstyle-border-top-themecolor:text1;
	mso-tstyle-border-top-themetint:153;
	mso-tstyle-border-bottom:cell-none;
	mso-tstyle-border-insideh:cell-none;
	mso-tstyle-border-insidev:cell-none;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Grid2FirstCol
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-table-condition:first-column;
	mso-style-priority:47;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Grid2LastCol
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-table-condition:last-column;
	mso-style-priority:47;
	mso-style-unhide:no;
	mso-ansi-font-weight:bold;
	mso-bidi-font-weight:bold;}
table.MsoTable15Grid2OddColumn
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-table-condition:odd-column;
	mso-style-priority:47;
	mso-style-unhide:no;
	mso-tstyle-shading:#CCCCCC;
	mso-tstyle-shading-themecolor:text1;
	mso-tstyle-shading-themetint:51;}
table.MsoTable15Grid2OddRow
	{mso-style-name:"Tabla de cuadrícula 2";
	mso-table-condition:odd-row;
	mso-style-priority:47;
	mso-style-unhide:no;
	mso-tstyle-shading:#CCCCCC;
	mso-tstyle-shading-themecolor:text1;
	mso-tstyle-shading-themetint:51;}
table.TableNormal
	{mso-style-name:"Table Normal";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-noshow:yes;
	mso-style-priority:2;
	mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	mso-padding-alt:0cm 0cm 0cm 0cm;
	mso-para-margin:0cm;
	mso-pagination:none;
	font-size:11.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;
	mso-ansi-language:EN-US;
	mso-fareast-language:EN-US;}
</style>
<![endif]-->
    <!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1028"/>
</xml><![endif]-->
    <!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=ES-CO style='tab-interval:36.0pt;word-wrap:break-word'>

    <div class=WordSection1>

        <table class=TableNormal border=1 cellspacing=0 cellpadding=0 align=left style='border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
 mso-border-alt:solid windowtext 1.5pt;mso-table-overlap:never;mso-yfti-tbllook:
 480;mso-table-lspace:7.05pt;margin-left:4.8pt;mso-table-rspace:7.05pt;
 margin-right:4.8pt;mso-table-anchor-vertical:paragraph;mso-table-anchor-horizontal:
 margin;mso-table-left:left;mso-table-top:-.1pt;mso-padding-alt:0cm 3.5pt 0cm 3.5pt;
 mso-border-insideh:.5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
            <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:13.15pt;mso-height-rule:
  exactly'>
                <td width=153 rowspan=3 valign=top style='width:115.0pt;border-top:1.5pt;
  border-left:1.5pt;border-bottom:1.0pt;border-right:1.0pt;border-color:windowtext;
  border-style:solid;mso-border-top-alt:1.5pt;mso-border-left-alt:1.5pt;
  mso-border-bottom-alt:.5pt;mso-border-right-alt:.5pt;mso-border-color-alt:
  windowtext;mso-border-style-alt:solid;padding:0cm 3.5pt 0cm 3.5pt;height:
  13.15pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.4pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:1.0pt;font-family:"Times New Roman",serif;
  mso-fareast-font-family:"Times New Roman"'>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                    <p class=TableParagraph style='margin-left:32.55pt;mso-line-height-alt:10.0pt;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'>
                        <!--[if gte vml 1]><v:shapetype
   id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
   path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
  </v:shapetype><v:shape id="Imagen_x0020_4" o:spid="_x0000_s1027" type="#_x0000_t75"
   style='position:absolute;left:0;text-align:left;margin-left:1.45pt;
   margin-top:5.1pt;width:69.95pt;height:45.95pt;z-index:-251656192;
   visibility:visible;mso-wrap-style:square;mso-width-percent:0;
   mso-height-percent:0;mso-wrap-distance-left:9pt;mso-wrap-distance-top:0;
   mso-wrap-distance-right:9pt;mso-wrap-distance-bottom:0;
   mso-position-horizontal:absolute;mso-position-horizontal-relative:text;
   mso-position-vertical:absolute;mso-position-vertical-relative:text;
   mso-width-percent:0;mso-height-percent:0;mso-width-relative:margin;
   mso-height-relative:margin'>
   <v:imagedata src="acta_entrega.fld/image003.png" o:title=""/>
  </v:shape><![endif]-->
                        <![if !vml]><span style='mso-ignore:vglayout;
  position:relative;z-index:-1895823360'><span style='left:0px;position:absolute;
  left:-12px;top:-1px;width:69px;height:46px'><img width=69 height=46 src="acta_entrega.fld/image005.jpg"
                                    v:shapes="Imagen_x0020_4"></span></span>
                        <![endif]>
                        <!--[if gte vml 1]><v:shape
   id="Imagen_x0020_3" o:spid="_x0000_s1026" type="#_x0000_t75" style='position:absolute;
   left:0;text-align:left;margin-left:70.45pt;margin-top:5.1pt;width:40.85pt;
   height:50.35pt;z-index:-251657216;visibility:visible;mso-wrap-style:square;
   mso-width-percent:0;mso-height-percent:0;mso-wrap-distance-left:9pt;
   mso-wrap-distance-top:0;mso-wrap-distance-right:9pt;
   mso-wrap-distance-bottom:0;mso-position-horizontal:absolute;
   mso-position-horizontal-relative:text;mso-position-vertical:absolute;
   mso-position-vertical-relative:text;mso-width-percent:0;
   mso-height-percent:0;mso-width-relative:margin;mso-height-relative:margin'>
   <v:imagedata src="acta_entrega.fld/image001.png" o:title="" cropright="41433f"/>
  </v:shape><![endif]-->
                        <![if !vml]><span style='mso-ignore:vglayout;
  position:relative;z-index:-1895824384'><span style='left:0px;position:absolute;
  left:57px;top:-1px;width:40px;height:51px'><img width=40 height=51 src="acta_entrega.fld/image006.jpg"
                                    v:shapes="Imagen_x0020_3"></span></span>
                        <![endif]><span lang=EN-US style='font-size:10.0pt;font-family:"Times New Roman",serif;
  mso-fareast-font-family:"Times New Roman"'>
                            <o:p></o:p>
                        </span>
                    </p>
                </td>
                <td width=422 colspan=7 rowspan=3 valign=top style='width:316.7pt;border-top:
  solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:13.15pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.25pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:11.5pt;font-family:"Times New Roman",serif;
  mso-fareast-font-family:"Times New Roman"'>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                    <p class=TableParagraph style='margin-left:13.0pt;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  mso-ansi-language:ES-CO'>ACTA<span style='letter-spacing:.35pt'> </span><span
                                style='letter-spacing:-.05pt'>DE</span><span style='letter-spacing:.4pt'>
                            </span>PRESTAMO<span style='letter-spacing:.35pt'> </span><span
                                style='letter-spacing:-.05pt'>DE</span><span style='letter-spacing:.35pt'>
                            </span>EQUIPOS<span style='letter-spacing:.35pt'>
                            </span><span style='letter-spacing:-.05pt'>DE</span><span style='letter-spacing:
  .4pt'> </span><span style='letter-spacing:-.05pt'>CÓMPUTO</span><span style='letter-spacing:.3pt'> </span>Y<span
                                style='letter-spacing:.1pt'> </span><span
                                style='letter-spacing:-.05pt'>ACCESORIOS</span></span><span style='font-size:
  9.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial;
  mso-ansi-language:ES-CO'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=48 colspan=2 valign=top style='width:35.9pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  mso-border-top-alt:solid windowtext 1.5pt;padding:0cm 0cm 0cm 0cm;height:
  13.15pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:3.5pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:5.7pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.1pt;mso-font-width:105%'>Código</span><span lang=EN-US style='font-size:
  7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=67 valign=top style='width:50.55pt;border-top:solid windowtext 1.5pt;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-top-alt:1.5pt;
  mso-border-left-alt:.5pt;mso-border-bottom-alt:.5pt;mso-border-right-alt:
  1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:solid;padding:
  0cm 0cm 0cm 0cm;height:13.15pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:4.05pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi'>TEC-FOR-02</span><span lang=EN-US style='font-size:7.0pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:1;height:13.1pt;mso-height-rule:exactly'>
                <td width=48 colspan=2 valign=top style='width:35.9pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:13.1pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:1.65pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:7.95pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span class=SpellE><span lang=EN-US style='font-size:7.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.05pt'>Fecha</span></span><span lang=EN-US style='font-size:
  7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=67 valign=top style='width:50.55pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:13.1pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:4.3pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt'>23/09/2021</span><span lang=EN-US style='font-size:7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:2;height:13.0pt;mso-height-rule:exactly'>
                <td width=48 colspan=2 valign=top style='width:35.9pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:13.0pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:1.65pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:5.8pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span class=SpellE><span lang=EN-US style='font-size:7.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt'>Versión</span></span><span lang=EN-US style='font-size:7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=67 valign=top style='width:50.55pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:13.0pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:3.7pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:1.1pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi'>07</span><span lang=EN-US style='font-size:7.0pt;font-family:"Arial",sans-serif;
  mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:3;height:46.1pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;padding:0cm 0cm 0cm 0cm;height:46.1pt;mso-height-rule:exactly'>
                    <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=754 style='border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
   mso-border-alt:solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:
   0cm 5.4pt 0cm 5.4pt'>
                        <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:9.35pt'>
                            <td width=159 valign=top style='width:118.9pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
    height:9.35pt'>
                                <p class=TableParagraph style='margin-top:.2pt;tab-stops:303.35pt;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;
    mso-ansi-language:ES-CO'>Nombre</span></b><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.7pt;mso-font-width:105%;
    mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:
    ES-CO'>del</span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.7pt;mso-font-width:105%;mso-ansi-language:ES-CO'>
                                        </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:
    7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
    Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
    letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:ES-CO'>responsable<o:p></o:p></span></b></p>
                            </td>
                            <td width=595 valign=top style='width:446.5pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt;height:9.35pt'>
                                <p class=TableParagraph align=center style='margin-top:.2pt;text-align:
    center;tab-stops:303.35pt;mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span class=SpellE><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:
    ES-CO'><?php echo $usuario; ?></span></span><b style='mso-bidi-font-weight:normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:
    ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:1'>
                            <td width=159 valign=top style='width:118.9pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.2pt;tab-stops:303.35pt;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-font-width:105%;mso-ansi-language:ES-CO'>Identificación</span></b><b style='mso-bidi-font-weight:normal'><span
                                            style='font-size:7.5pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
    Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
    letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                            <td width=595 valign=top style='width:446.5pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:
    solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=center style='margin-top:.2pt;text-align:
    center;tab-stops:303.35pt;mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;
    mso-ansi-language:ES-CO'><?php echo $cedula; ?></span><span style='font-size:7.5pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
    Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
    letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:2;height:11.05pt'>
                            <td width=159 valign=top style='width:118.9pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
    height:11.05pt'>
                                <p class=TableParagraph style='margin-top:.2pt;tab-stops:303.35pt;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-font-width:105%;mso-ansi-language:ES-CO'>Fecha</span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.5pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.5pt;mso-font-width:105%;mso-ansi-language:ES-CO'>
                                        </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:
    7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;mso-font-width:105%;mso-ansi-language:ES-CO'>de<span style='letter-spacing:-.45pt'> </span><span
                                                style='letter-spacing:-.05pt'>Recibo<o:p></o:p></span></span></b></p>
                            </td>
                            <td width=595 valign=top style='width:446.5pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:
    solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt;height:11.05pt'>
                                <p class=TableParagraph align=center style='margin-top:.2pt;text-align:
    center;tab-stops:303.35pt;mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;
    mso-ansi-language:ES-CO'>DIA:</span><span style='font-size:7.5pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.3pt;mso-font-width:105%;mso-ansi-language:ES-CO'>
                                    </span><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-font-width:105%;mso-ansi-language:ES-CO'><?php echo date('d'); ?></span><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.3pt;mso-font-width:105%;
    mso-ansi-language:ES-CO'> </span><span style='font-size:7.5pt;mso-bidi-font-size:
    11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
    letter-spacing:-.1pt;mso-font-width:105%;mso-ansi-language:ES-CO'>M</span><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.15pt;mso-font-width:105%;
    mso-ansi-language:ES-CO'>ES:</span><span style='font-size:7.5pt;mso-bidi-font-size:
    11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
    letter-spacing:-.25pt;mso-font-width:105%;mso-ansi-language:ES-CO'> </span><span style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;mso-font-width:105%;mso-ansi-language:ES-CO'><?php echo date('m'); ?><span
                                            style='letter-spacing:-.3pt'> </span><span
                                            style='letter-spacing:-.05pt'>AÑO:</span><span style='letter-spacing:-.3pt'>
                                        </span><span style='letter-spacing:-.05pt'><?php echo date('Y'); ?><o:p></o:p>
                                            </span></span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:3;mso-yfti-lastrow:yes;height:14.3pt'>
                            <td width=159 valign=top style='width:118.9pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
    height:14.3pt'>
                                <p class=TableParagraph style='margin-top:.2pt;tab-stops:303.35pt;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><span class=SpellE><b style='mso-bidi-font-weight:normal'><span
                                                lang=EN-US style='font-size:8.0pt;
    font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:
    -.05pt'>Compañía</span></b></span><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:8.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'>:<o:p></o:p></span></b></p>
                            </td>
                            <td width=595 valign=top style='width:446.5pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:
    solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt;height:14.3pt'>
                                <p class=TableParagraph align=center style='margin-top:.2pt;text-align:
    center;tab-stops:303.35pt;mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $rowm['empresa']; ?></span><span style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-font-width:105%;mso-ansi-language:
    ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                        </tr>
                    </table>
                    <p class=TableParagraph style='margin-top:.1pt;tab-stops:313.45pt'><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:4;height:10.2pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F8D852;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-top:.1pt;margin-right:
  .45pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>IDENTIFICACION</span></i></b><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.85pt;
  mso-font-width:105%'> </span></i></b><b style='mso-bidi-font-weight:normal'><i
                                style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;mso-font-width:
  105%'>DEL</span></i></b><b style='mso-bidi-font-weight:normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US
                                    style='font-size:7.5pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:-.85pt;mso-font-width:
  105%'> </span></i></b><b style='mso-bidi-font-weight:normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US
                                    style='font-size:7.5pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;mso-font-width:
  105%'>EQUIPO</span></i></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:5;height:10.7pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.7pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.2pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>MARCA</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.7pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span class=SpellE><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $marcapc; ?></span></span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:6;height:9.95pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:9.95pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.2pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>MODELO</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.95pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span class=SpellE><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $modelotraducido; ?></span></span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:7;height:9.95pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:9.95pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.2pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span class=GramE><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>No</span></b></span><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.25pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>DE</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.25pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>SERIE</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.95pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:Consolas;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-font-family:Arial;mso-bidi-theme-font:minor-bidi;
  mso-font-width:105%'><?php echo $serialpc; ?></span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:8;height:10.5pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.5pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.1pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>No</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.55pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>INVE</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>NTA</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>RIO</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.5pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span class=SpellE><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:Consolas;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'><?php echo $placa; ?></span></span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:9;height:10.2pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F8D852;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-top:.1pt;margin-right:
  .35pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:-.05pt'>CARACTERÍSTICAS</span></i></b><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext'> <span
                                        style='letter-spacing:1.95pt'>TÉCNICAS</span></span></i></b><span lang=EN-US
                            style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:10;height:10.25pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.25pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.2pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>PROCESADOR</span></b><span lang=EN-US style='font-size:
  7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.25pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.2pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.6pt;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span class=SpellE><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $procesador; ?></span></span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:11;height:10.2pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>MEMORIA</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.95pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>RAM</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.6pt;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $ram; ?></span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:12;height:10.2pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>DISCO</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.7pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>DURO</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.6pt;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $discoduro; ?></span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:13;height:10.5pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.5pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.1pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>SISTEMA</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-1.25pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>OPE</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>RA</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>TIVO</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.5pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.1pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.6pt;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span class=SpellE><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $sistematraducido; ?></span></span><span lang=EN-US
                            style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:14;height:10.25pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F8D852;padding:0cm 0cm 0cm 0cm;height:10.25pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-top:.15pt;margin-right:
  .6pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>SOFTWARE</span></i></b><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-1.4pt;
  mso-font-width:105%'> </span></i></b><b style='mso-bidi-font-weight:normal'><i
                                style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;mso-font-width:
  105%'>INSTALADO</span></i></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:15;height:10.25pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.25pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.2pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>P</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>A</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>Q</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>UE</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>TE</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.85pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;mso-font-width:105%'>OFICINA</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.25pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.2pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.95pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;mso-font-width:105%'>OFFICE<span style='letter-spacing:-.75pt'> </span><span
                                style='letter-spacing:-.05pt'>365</span></span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:16;height:10.2pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>P</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>RO</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>G</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>RAMA</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>S</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-1.05pt;
  mso-font-width:105%'> </span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>ESPE</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-font-width:105%'>CIA</span></b><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.15pt;
  mso-font-width:105%'>LES</span></b><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.8pt;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>CREATIVE</span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.95pt;mso-font-width:105%'> </span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>CLOUD</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:17;height:10.2pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>ANTIVIRUS</span></b><span lang=EN-US style='font-size:
  7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.85pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>SENTINEL</span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.9pt;mso-font-width:105%'> </span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>ONE</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:18;height:10.2pt;mso-height-rule:exactly'>
                <td width=153 rowspan=4 valign=top style='width:115.0pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;
  background:#F2F2F2;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph style='mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:8.0pt;font-family:"Times New Roman",serif;
  mso-fareast-font-family:"Times New Roman"'>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                    <p class=TableParagraph style='margin-top:6.15pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:16.6pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;mso-font-width:105%'>OTROS<span style='letter-spacing:-1.0pt'>
                                </span><span style='letter-spacing:-.15pt'>P</span><span
                                    style='letter-spacing:-.1pt'>RO</span><span
                                    style='letter-spacing:-.15pt'>G</span><span
                                    style='letter-spacing:-.1pt'>RAMA</span><span
                                    style='letter-spacing:-.15pt'>S</span></span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=99 valign=top style='width:74.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.5pt;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>JAMF</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=21 valign=top style='width:15.95pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:5.45pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=90 valign=top style='width:67.2pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:21.9pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>ZOOM</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.75pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=81 valign=top style='width:61.1pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.95pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:15.75pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span class=SpellE><span lang=EN-US style='font-size:7.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.1pt'>LOGME</span></span><span lang=EN-US style='font-size:
  7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:.5pt'> </span><span lang=EN-US style='font-size:7.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.05pt'>IN</span><span lang=EN-US style='font-size:7.0pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=32 valign=top style='width:23.9pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.85pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=87 colspan=2 valign=top style='width:65.3pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.75pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>BOX</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=22 valign=top style='width:16.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:5.7pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=67 rowspan=3 valign=top style='width:50.55pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:exactly'>
                    <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:19;height:10.2pt;mso-height-rule:exactly'>
                <td width=99 valign=top style='width:74.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:14.55pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:
  105%'>FUSION</span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.75pt;mso-font-width:105%'> </span><span lang=EN-US style='font-size:7.5pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  mso-font-width:105%'>INV</span><span lang=EN-US style='font-size:7.5pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=21 valign=top style='width:15.95pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:5.45pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=90 valign=top style='width:67.2pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:19.5pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>WEBEX</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                </td>
                <td width=81 valign=top style='width:61.1pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.95pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.85pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt'>VPN</span><span lang=EN-US style='font-size:7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=32 valign=top style='width:23.9pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.85pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=87 colspan=2 valign=top style='width:65.3pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:19.3pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>IWORK</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=22 valign=top style='width:16.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:20;height:10.2pt;mso-height-rule:exactly'>
                <td width=99 valign=top style='width:74.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:15.75pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:
  105%'>NETSKOPE</span><span lang=EN-US style='font-size:7.5pt;font-family:
  "Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=21 valign=top style='width:15.95pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:5.45pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=90 valign=top style='width:67.2pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:20.3pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:
  105%'>TEAMS</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;
  mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.75pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=81 valign=top style='width:61.1pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.95pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:7.35pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'>BOOKMARKS</span><span lang=EN-US style='font-size:7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=32 valign=top style='width:23.9pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.45pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:.85pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>X</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=87 colspan=2 valign=top style='width:65.3pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.45pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:7.0pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-font-width:
  105%'>ADVERTMIND</span><span lang=EN-US style='font-size:7.5pt;font-family:
  "Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=22 valign=top style='width:16.45pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.2pt;
  mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:21;height:10.4pt;mso-height-rule:exactly'>
                <td width=99 valign=top style='width:74.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;height:10.4pt;
  mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-top:.6pt;margin-right:0cm;margin-bottom:
  0cm;margin-left:22.95pt;margin-bottom:.0001pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>OTROS</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=438 colspan=9 valign=top style='width:328.8pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.4pt;mso-height-rule:exactly'>
                    <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:22;height:10.2pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F8D852;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-top:.1pt;margin-right:
  .4pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:center;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>ACCESORIOS</span></i></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:23;height:9.95pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;background:
  #F2F2F2;padding:0cm 0cm 0cm 0cm;height:9.95pt;mso-height-rule:exactly'>
                    <p class=TableParagraph style='margin-left:37.15pt;line-height:8.25pt;
  mso-line-height-rule:exactly;mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:-.1pt;mso-font-width:105%'>CANTIDAD</span></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  background:#F2F2F2;padding:0cm 0cm 0cm 0cm;height:9.95pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-left:.25pt;text-align:
  center;line-height:8.5pt;mso-line-height-rule:exactly;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>DESCRIPCION</span></b><span lang=EN-US style='font-size:
  7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <?php if ($tipopc == 'Desktop') : ?>
            <tr style='mso-yfti-irow:30;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Cable de poder</span><span lang=EN-US style='font-size:
  7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.6pt;mso-font-width:105%'> </span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>original</span></p>
                </td>
            </tr>
            <?php else : ?>
            <?php if ($cargador <> 'No') : ?>
            <tr style='mso-yfti-irow:29;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Cargador </span><span lang=EN-US style='font-size:
  7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.6pt;mso-font-width:105%'><?php echo $cargador; ?></span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php if ($cargador == "61 Watts") {
                                                          echo " con su respectivo cable usb TIPO C original de 2 metros";
                                                        } else {
                                                          if ($cargador == "67 Watts") {
                                                            echo " con su respectivo cable TIPO C - Magsafe 3 original de 2 metros";
                                                          }
                                                        } ?></span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php endif ?>
            <?php if ($satechi == 'Si') : ?>
            <tr style='mso-yfti-irow:28;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Satechi</span></p>
                </td>
            </tr>
            <?php endif ?>

            <?php if ($cable == 'Si') : ?>
            <tr style='mso-yfti-irow:28;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Cable lightning</span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($maletin == 'Si') : ?>
            <tr style='mso-yfti-irow:24;height:10.0pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:10.0pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='text-align:center;line-height:
  8.25pt;mso-line-height-rule:exactly;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;
  font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:105%'>1</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:10.0pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=center style='margin-top:.35pt;margin-right:
  0cm;margin-bottom:0cm;margin-left:1.0pt;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>Maletin</span><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($guaya == 'Si') : ?>
            <tr style='mso-yfti-irow:25;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Guaya</span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($base == 'Si') : ?>
            <tr style='mso-yfti-irow:28;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Base Refrigerante</span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($teclado == 'Si') : ?>
            <tr style='mso-yfti-irow:26;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Teclado</span><span lang=EN-US style='font-size:
  7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.6pt;mso-font-width:105%'> Serial: </span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $serialteclado; ?></span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($mouse == 'Si') : ?>
            <tr style='mso-yfti-irow:27;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Mouse</span><span lang=EN-US style='font-size:
  7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.6pt;mso-font-width:105%'> Serial: </span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'><?php echo $serialmouse; ?></span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($serialpantalla <> '') : ?>
            <tr style='mso-yfti-irow:29;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>1</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'>Monitor Serial: </span><span lang=EN-US style='font-size:
  7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.6pt;mso-font-width:105%'><?php echo $serialpantalla; ?></span><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-font-width:105%'>
                            <?php echo "Marca: " . $marcapantalla . " Modelo: " . $modelopantalla; ?></span></p>
                </td>
            </tr>
            <?php endif ?>
            <?php if ($otros <> '') : ?>
            <tr style='mso-yfti-irow:28;height:9.6pt;mso-height-rule:exactly'>
                <td width=153 valign=top style='width:115.0pt;border-top:none;border-left:
  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:
  solid windowtext 1.0pt;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;mso-border-left-alt:solid windowtext 1.5pt;padding:
  0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;mso-font-width:
  105%'>-</span></p>
                </td>
                <td width=538 colspan=10 valign=top style='width:403.15pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext 1.5pt;
  padding:0cm 0cm 0cm 0cm;height:9.6pt;mso-height-rule:exactly'>
                    <p class=MsoNormal align=center style='text-align:center;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  -.05pt;mso-font-width:105%'><?php echo $otros; ?></span></p>
                </td>
            </tr>
            <?php endif ?>
            <tr style='mso-yfti-irow:32;height:10.2pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F8D852;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-top:.1pt;margin-right:
  .45pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>OBSERVACIONES</span></i></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:33;height:91.35pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F2F2F2;padding:0cm 0cm 0cm 0cm;height:91.35pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph style='margin-top:5.4pt;margin-right:3.8pt;
  margin-bottom:0cm;margin-left:1.15pt;margin-bottom:.0001pt;line-height:110%;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;mso-ansi-language:ES-CO'>El<span style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.1pt'>responsable</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.05pt'>del</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.1pt'>equipo</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.1pt'>cómputo</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.1pt'>por</span><span style='letter-spacing:.3pt'>
                                </span><span style='letter-spacing:-.05pt'>medio</span><span
                                    style='letter-spacing:.15pt'> </span><span
                                    style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>su</span><span style='letter-spacing:.15pt'>
                                </span><span style='letter-spacing:-.05pt'>firma</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>confirma</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.1pt'>que</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.1pt'>conoce,</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>acepta</span><span style='letter-spacing:.2pt'>
                                </span>y<span style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>cumple</span><span style='letter-spacing:.15pt'>
                                </span><span style='letter-spacing:-.05pt'>la</span><span style='letter-spacing:
  .25pt'> </span><span style='letter-spacing:-.05pt'>política</span><span style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>de</span></span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:4.15pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-ansi-language:ES-CO'>Tecnología</span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:.15pt;mso-ansi-language:
  ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>de</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>la</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Información</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.15pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>del</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Grupo</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.15pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>DDB,</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;mso-ansi-language:ES-CO'>y<span style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.1pt'>que</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>se</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>hace</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.1pt'>responsable</span><span style='letter-spacing:
  .2pt'> </span><span style='letter-spacing:-.1pt'>por</span><span style='letter-spacing:.3pt'> </span><span
                                    style='letter-spacing:-.05pt'>cualquier</span><span style='letter-spacing:.3pt'>
                                </span><span style='letter-spacing:-.1pt'>violación</span><span
                                    style='letter-spacing:.2pt'> </span>o<span style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.1pt'>desviación</span><span style='letter-spacing:
  .2pt'> </span><span style='letter-spacing:-.1pt'>que</span><span style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>se</span></span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:4.05pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-ansi-language:ES-CO'>presente</span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:.2pt;mso-ansi-language:
  ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>sobre</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>dicha</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>política</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;mso-ansi-language:ES-CO'>o<span style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>el</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>reglamento</span><span style='letter-spacing:
  .15pt'> </span><span style='letter-spacing:-.05pt'>interno</span><span style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>trabajo</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>del</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>Grupo</span><span
                                    style='letter-spacing:.15pt'> </span><span
                                    style='letter-spacing:-.05pt'>DDB.</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.1pt'>Asume</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>el</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>costo</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>en</span><span style='letter-spacing:.15pt'>
                                </span><span style='letter-spacing:-.05pt'>libros</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.1pt'>por</span><span style='letter-spacing:.3pt'>
                                </span><span style='letter-spacing:-.05pt'>cualquier</span></span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:1.55pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-ansi-language:ES-CO'>daño</span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:.15pt;mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;mso-ansi-language:ES-CO'>o<span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.05pt'>pérdida</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>ocurrida</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>al</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.1pt'>equipo</span><span
                                    style='letter-spacing:.15pt'> </span><span
                                    style='letter-spacing:-.05pt'>bajo</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.05pt'>su</span><span style='letter-spacing:.15pt'>
                                </span><span style='letter-spacing:-.1pt'>custodia</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>fuera</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>las</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>labores</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.1pt'>asignadas</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.1pt'>por</span><span style='letter-spacing:.3pt'>
                                </span><span style='letter-spacing:-.05pt'>la</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.05pt'>empresa,</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.1pt'>por</span><span style='letter-spacing:.3pt'>
                                </span><span style='letter-spacing:-.05pt'>negligencia</span><span
                                    style='letter-spacing:.15pt'> </span><span
                                    style='letter-spacing:-.05pt'>en</span><span style='letter-spacing:.2pt'>
                                </span><span style='letter-spacing:-.05pt'>su</span></span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:3.75pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.1pt;
  mso-ansi-language:ES-CO'>custodia.</span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:.25pt;mso-ansi-language:
  ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Este</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>registro</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.2pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>será</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>actualizado</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>cada</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.1pt;mso-ansi-language:ES-CO'>vez</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.1pt;mso-ansi-language:ES-CO'>que</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>se</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>realice</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.1pt;mso-ansi-language:ES-CO'>una</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>modificación</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.2pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>sobre</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>la</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.1pt;mso-ansi-language:ES-CO'>configuración</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.2pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>del</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.1pt;mso-ansi-language:ES-CO'>equipo</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:4.45pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-ansi-language:ES-CO'>(hardware</span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:.25pt;mso-ansi-language:
  ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;mso-ansi-language:ES-CO'>o<span style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>software).</span><span style='letter-spacing:
  .25pt'> </span><span style='letter-spacing:-.05pt'>Recuerde</span><span style='letter-spacing:.3pt'> </span><span
                                    style='letter-spacing:-.1pt'>que</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>para</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>retirar</span><span style='letter-spacing:.35pt'>
                                </span><span style='letter-spacing:-.05pt'>el</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.1pt'>equipo</span><span
                                    style='letter-spacing:.2pt'> </span><span
                                    style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>las</span><span style='letter-spacing:.3pt'>
                                </span><span style='letter-spacing:-.05pt'>instalaciones</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>la</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>compañía</span><span
                                    style='letter-spacing:.25pt'> </span><span
                                    style='letter-spacing:-.1pt'>debe</span><span style='letter-spacing:.25pt'>
                                </span><span style='letter-spacing:-.05pt'>solicitar</span><span
                                    style='letter-spacing:.3pt'> </span><span
                                    style='letter-spacing:-.1pt'>previa</span></span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:windowtext;
  letter-spacing:3.05pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-ansi-language:ES-CO'>autorización</span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;letter-spacing:.25pt;mso-ansi-language:
  ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>con</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>su</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>jefe</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:110%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:.35pt;
  mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:110%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;color:black;mso-color-alt:
  windowtext;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>inmediato.</span></b><span style='font-size:9.0pt;line-height:110%;font-family:"Arial",sans-serif;
  mso-fareast-font-family:Arial;mso-ansi-language:ES-CO'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:34;height:83.4pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;padding:0cm 0cm 0cm 0cm;height:83.4pt;mso-height-rule:exactly'>
                    <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 style='border-collapse:collapse;mso-table-layout-alt:fixed;border:none;
   mso-border-alt:solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:
   0cm 5.4pt 0cm 5.4pt'>
                        <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:1'>
                            <td width=245 colspan=2 valign=top style='width:184.05pt;border:none;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=center style='margin-top:.35pt;text-align:
    center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
    around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-ansi-language:ES-CO'>Firma</span></b><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.8pt;
    mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>Entrega</span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:.85pt;mso-ansi-language:ES-CO'>
                                        </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:
    7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Tecnología</span></b><span style='font-size:7.5pt;font-family:"Times New Roman",serif;mso-fareast-font-family:
    "Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=253 colspan=2 valign=top style='width:189.85pt;border:none;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=center style='margin-top:.35pt;text-align:
    center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
    around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-ansi-language:ES-CO'>Firma</span></b><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.85pt;
    mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>Aceptación</span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:1.05pt;mso-ansi-language:
    ES-CO'> </span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>Empleado</span></b><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:2'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:3'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:4'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:5'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:6'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:7'>
                            <td width=104 valign=top style='width:77.75pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;border-bottom:
    solid windowtext 1.0pt;mso-border-bottom-alt:solid windowtext .5pt;
    padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:8'>
                            <td width=104 valign=top style='width:77.75pt;border:none;mso-border-top-alt:
    solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=right style='margin-top:.35pt;text-align:
    right;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
    around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-ansi-language:ES-CO'>Nombre:</span></b><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;mso-ansi-language:ES-CO'><span style='mso-spacerun:yes'> 
                                            </span><span style='letter-spacing:1.7pt'><span
                                                    style='mso-spacerun:yes'> </span></span><span
                                                style='letter-spacing:-.05pt'>
                                                <o:p></o:p>
                                            </span></span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;mso-border-top-alt:
    solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;text-align:justify;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-ansi-language:ES-CO'><?php echo $itusuario; ?></span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;mso-border-top-alt:
    solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=right style='margin-top:.35pt;text-align:
    right;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
    around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
    mso-ansi-language:ES-CO'>Nombre:</span></b><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;mso-ansi-language:ES-CO'><span style='mso-spacerun:yes'> 
                                            </span></span></b><span style='font-size:7.5pt;
    font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";
    mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;mso-border-top-alt:
    solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;text-align:justify;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'><?php echo $usuario; ?></span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:9;mso-yfti-lastrow:yes'>
                            <td width=104 valign=top style='width:77.75pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=right style='margin-top:.35pt;text-align:
    right;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
    around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;
    font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
    minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'>c.c.</span></b><b
                                        style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;text-align:justify;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;
    font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
    minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'><?php echo $itcedula; ?></span></b><b
                                        style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                            <td width=189 valign=top style='width:142.0pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><span style='font-size:7.5pt;font-family:"Times New Roman",serif;
    mso-fareast-font-family:"Times New Roman";mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=56 valign=top style='width:42.25pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph align=right style='margin-top:.35pt;text-align:
    right;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
    around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;
    font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
    minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'>c.c.</span></b><b
                                        style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                            <td width=197 valign=top style='width:147.6pt;border:none;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=TableParagraph style='margin-top:.35pt;text-align:justify;
    mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
    mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
    mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span lang=EN-US style='font-size:7.0pt;mso-bidi-font-size:11.0pt;
    font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
    minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'><?php echo $cedula; ?></span></b><b
                                        style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;
    mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
    Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
    letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p></o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                    </table>
                    <p class=TableParagraph style='margin-top:1.55pt;tab-stops:82.0pt 359.4pt 386.65pt'><b
                            style='mso-bidi-font-weight:normal'><span lang=EN-US style='font-size:7.0pt;
  mso-bidi-font-size:11.0pt;font-family:"Times New Roman",serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:Arial;
  mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt'><span
                                    style='mso-tab-count:
  3'>                                                                                                                                                                                                 
                                </span></span></b><span lang=EN-US style='font-size:7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:35;height:10.2pt;mso-height-rule:exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border-top:none;
  border-left:solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;
  border-right:solid windowtext 1.5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-top-alt:.5pt;mso-border-left-alt:1.5pt;mso-border-bottom-alt:.5pt;
  mso-border-right-alt:1.5pt;mso-border-color-alt:windowtext;mso-border-style-alt:
  solid;background:#F8D852;padding:0cm 0cm 0cm 0cm;height:10.2pt;mso-height-rule:
  exactly'>
                    <p class=TableParagraph align=center style='margin-top:.1pt;margin-right:
  .55pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:
  center;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.05pt;
  mso-font-width:105%'>Aceptacion</span></i></b><b style='mso-bidi-font-weight:
  normal'><i style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;color:black;mso-color-alt:windowtext;letter-spacing:-.5pt;
  mso-font-width:105%'> </span></i></b><b style='mso-bidi-font-weight:normal'><i
                                style='mso-bidi-font-style:normal'><span lang=EN-US style='font-size:7.5pt;
  mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:
  Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;
  color:black;mso-color-alt:windowtext;mso-font-width:105%'>de<span style='letter-spacing:-.5pt'> </span><span
                                        style='letter-spacing:-.05pt'>Politica</span><span style='letter-spacing:-.5pt'>
                                    </span>TI</span></i></b><span lang=EN-US style='font-size:7.5pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <tr style='mso-yfti-irow:36;mso-yfti-lastrow:yes;height:89.8pt;mso-height-rule:
  exactly'>
                <td width=691 colspan=11 valign=top style='width:518.15pt;border:solid windowtext 1.5pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;padding:0cm 0cm 0cm 0cm;
  height:89.8pt;mso-height-rule:exactly'>
                    <p class=TableParagraph align=right style='margin-right:51.8pt;text-align:
  right;line-height:7.8pt;mso-line-height-rule:exactly;mso-element:frame;
  mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
  paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
  mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Firma</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  .85pt;mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
  mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Aceptaci</span></b><b
                            style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:
  11.0pt;mso-ascii-font-family:Arial;letter-spacing:-.05pt;mso-ansi-language:
  ES-CO'>ó</span></b><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
  mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>n</span></b><b style='mso-bidi-font-weight:normal'><span
                                style='font-size:7.0pt;mso-bidi-font-size:
  11.0pt;font-family:"Arial",sans-serif;mso-hansi-font-family:Calibri;
  mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:minor-bidi;letter-spacing:
  1.05pt;mso-ansi-language:ES-CO'> </span></b><b style='mso-bidi-font-weight:
  normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
  mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Empleado<o:p></o:p></span></b></p>
                    <table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 align=right width=243 style='border-collapse:collapse;mso-table-layout-alt:fixed;
   border:none;mso-table-overlap:never;mso-yfti-tbllook:1184;mso-table-lspace:
   7.05pt;margin-left:4.8pt;mso-table-rspace:7.05pt;margin-right:4.8pt;
   mso-table-anchor-vertical:paragraph;mso-table-anchor-horizontal:margin;
   mso-table-left:right;mso-table-top:22.75pt;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
   mso-border-insideh:none;mso-border-insidev:none'>
                        <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:7.1pt'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt;
    height:7.1pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt;
    height:7.1pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span style='mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:1'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:2'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:3'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:4'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'>
                                            <o:p>&nbsp;</o:p>
                                        </span></b></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:5'>
                            <td width=102 valign=top style='width:76.3pt;border:none;border-top:solid windowtext 1.0pt;
    mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Nombre:</span></b><span style='mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;border:none;border-top:solid windowtext 1.0pt;
    mso-border-top-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'><?php echo $usuario; ?></span></b><span style='mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:6'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>c.c.</span></b><span style='mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:
    ES-CO'><?php echo $cedula; ?></span></b><span style='mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:7'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal align=right style='text-align:right;mso-element:frame;
    mso-element-frame-hspace:7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:
    paragraph;mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;
    mso-height-rule:exactly'><b style='mso-bidi-font-weight:normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:"Arial",sans-serif;
    mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;mso-bidi-theme-font:
    minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>Fecha:</span></b><span style='mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
    normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
    "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
    mso-bidi-theme-font:minor-bidi;mso-ansi-language:ES-CO'><?php echo $fechaimprime; ?></span></b><span
                                        style='mso-ansi-language:ES-CO'>
                                        <o:p></o:p>
                                    </span></p>
                            </td>
                        </tr>
                        <tr style='mso-yfti-irow:8;mso-yfti-lastrow:yes'>
                            <td width=102 valign=top style='width:76.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span style='mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                            <td width=142 valign=top style='width:106.3pt;padding:0cm 5.4pt 0cm 5.4pt'>
                                <p class=MsoNormal style='mso-element:frame;mso-element-frame-hspace:7.05pt;
    mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
    margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span style='mso-ansi-language:ES-CO'>
                                        <o:p>&nbsp;</o:p>
                                    </span></p>
                            </td>
                        </tr>
                    </table>
                    <p class=TableParagraph style='margin-top:1.2pt;margin-right:207.3pt;
  margin-bottom:0cm;margin-left:6.6pt;margin-bottom:.0001pt;line-height:101%;
  mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:around;
  mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:margin;
  mso-element-top:-.1pt;mso-height-rule:exactly'><span style='font-size:9.0pt;
  mso-bidi-font-size:11.0pt;line-height:101%;font-family:"Arial",sans-serif;
  mso-bidi-theme-font:minor-bidi;mso-ansi-language:ES-CO'>El<span style='letter-spacing:.2pt'> </span><span
                                style='letter-spacing:-.05pt'>usuario</span><span style='letter-spacing:.15pt'>
                            </span><span style='letter-spacing:-.05pt'>indica</span><span style='letter-spacing:.1pt'>
                            </span><span style='letter-spacing:-.05pt'>que</span><span style='letter-spacing:.15pt'>
                            </span><span style='letter-spacing:-.05pt'>tiene</span><span style='letter-spacing:.2pt'>
                            </span><span style='letter-spacing:-.05pt'>conocimiento</span><span
                                style='letter-spacing:.05pt'> </span><span style='letter-spacing:-.05pt'>de</span><span
                                style='letter-spacing:.2pt'> </span><span style='letter-spacing:-.05pt'>la</span><span
                                style='letter-spacing:.2pt'> </span><span
                                style='letter-spacing:-.05pt'>política</span><span style='letter-spacing:.05pt'>
                            </span><span style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.2pt'>
                            </span>TI,<span style='letter-spacing:.2pt'> </span><span
                                style='letter-spacing:-.05pt'>tratamiento</span> <span style='letter-spacing:
  -.05pt'>de</span></span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;
  line-height:101%;font-family:"Times New Roman",serif;mso-bidi-font-family:
  Arial;mso-bidi-theme-font:minor-bidi;letter-spacing:2.4pt;mso-font-width:
  101%;mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;
  mso-bidi-font-size:11.0pt;line-height:101%;font-family:"Arial",sans-serif;
  mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>información,</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.05pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>uso</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.1pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>adecuado</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.15pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>del</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>mail</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;mso-ansi-language:ES-CO'>y<span style='letter-spacing:.15pt'> </span><span
                                style='letter-spacing:-.05pt'>de</span><span style='letter-spacing:.15pt'> </span><span
                                style='letter-spacing:-.05pt'>mantener</span><span style='letter-spacing:
  .25pt'> </span><span style='letter-spacing:-.05pt'>el</span><span style='letter-spacing:.25pt'> </span><span
                                style='letter-spacing:-.05pt'>buen</span><span style='letter-spacing:.15pt'>
                            </span><span style='letter-spacing:-.05pt'>estado</span><span style='letter-spacing:.05pt'>
                            </span><span style='letter-spacing:-.05pt'>del</span><span style='letter-spacing:.25pt'>
                            </span><span style='letter-spacing:-.05pt'>equipo</span></span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Times New Roman",serif;mso-bidi-font-family:Arial;mso-bidi-theme-font:minor-bidi;
  letter-spacing:1.7pt;mso-font-width:101%;mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:-.05pt;
  mso-ansi-language:ES-CO'>asignado</span><span style='font-size:9.0pt;
  mso-bidi-font-size:11.0pt;line-height:101%;font-family:"Arial",sans-serif;
  mso-bidi-theme-font:minor-bidi;letter-spacing:.15pt;mso-ansi-language:ES-CO'>
                        </span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:
  101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.05pt;mso-ansi-language:ES-CO'>por</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.25pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>la</span><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;line-height:101%;font-family:
  "Arial",sans-serif;mso-bidi-theme-font:minor-bidi;letter-spacing:.3pt;
  mso-ansi-language:ES-CO'> </span><span style='font-size:9.0pt;mso-bidi-font-size:
  11.0pt;line-height:101%;font-family:"Arial",sans-serif;mso-bidi-theme-font:
  minor-bidi;letter-spacing:-.05pt;mso-ansi-language:ES-CO'>compañía.</span><span style='font-size:9.0pt;line-height:101%;font-family:"Arial",sans-serif;
  mso-fareast-font-family:Arial;mso-ansi-language:ES-CO'>
                            <o:p></o:p>
                        </span></p>
                    <p class=TableParagraph style='margin-left:6.6pt;line-height:10.3pt;
  mso-line-height-rule:exactly;tab-stops:352.25pt;mso-element:frame;mso-element-frame-hspace:
  7.05pt;mso-element-wrap:around;mso-element-anchor-vertical:paragraph;
  mso-element-anchor-horizontal:margin;mso-element-top:-.1pt;mso-height-rule:
  exactly'><span style='font-size:9.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Arial",sans-serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:minor-latin;
  mso-bidi-theme-font:minor-bidi;mso-ansi-language:ES-CO'>Se<span style='letter-spacing:.15pt'> </span><span
                                style='letter-spacing:-.05pt'>toma</span><span style='letter-spacing:.2pt'> </span><span
                                style='letter-spacing:-.05pt'>por</span><span style='letter-spacing:.15pt'> </span><span
                                style='letter-spacing:-.05pt'>aceptado</span><span style='letter-spacing:.1pt'>
                            </span><span style='letter-spacing:-.05pt'>lo</span><span style='letter-spacing:.25pt'>
                            </span><span style='letter-spacing:-.05pt'>mencionado</span><span
                                style='letter-spacing:.05pt'> </span><span style='letter-spacing:-.05pt'>en</span><span
                                style='letter-spacing:.2pt'> </span>esta<span style='letter-spacing:.15pt'> </span><span
                                style='letter-spacing:-.05pt'>acta.<span
                                    style='mso-tab-count:1'>                                              
                                </span></span></span><span style='font-size:9.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
  Arial;mso-ansi-language:ES-CO'>
                            <o:p></o:p>
                        </span></p>
                    <p class=TableParagraph align=right style='margin-right:106.2pt;text-align:
  right;mso-element:frame;mso-element-frame-hspace:7.05pt;mso-element-wrap:
  around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><span style='font-size:
  7.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:Arial;
  mso-ansi-language:ES-CO'>
                            <o:p>&nbsp;</o:p>
                        </span></p>
                    <p class=TableParagraph align=right style='margin-top:1.55pt;margin-right:
  92.0pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:
  right;tab-stops:27.2pt;mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman",serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-font-family:Arial;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.05pt;mso-ansi-language:ES-CO'><span style='mso-tab-count:
  1'>              </span></span></b><span style='font-size:7.0pt;font-family:
  "Arial",sans-serif;mso-fareast-font-family:Arial;mso-ansi-language:ES-CO'>
                            <o:p></o:p>
                        </span></p>
                    <p class=TableParagraph align=right style='margin-top:1.55pt;margin-right:
  38.75pt;margin-bottom:0cm;margin-left:0cm;margin-bottom:.0001pt;text-align:
  right;tab-stops:50.3pt;mso-element:frame;mso-element-frame-hspace:7.05pt;
  mso-element-wrap:around;mso-element-anchor-vertical:paragraph;mso-element-anchor-horizontal:
  margin;mso-element-top:-.1pt;mso-height-rule:exactly'><b style='mso-bidi-font-weight:
  normal'><span style='font-size:7.0pt;mso-bidi-font-size:11.0pt;font-family:
  "Times New Roman",serif;mso-hansi-font-family:Calibri;mso-hansi-theme-font:
  minor-latin;mso-bidi-font-family:Arial;mso-bidi-theme-font:minor-bidi;
  letter-spacing:-.05pt;mso-ansi-language:ES-CO'><span style='mso-tab-count:
  1'>                         </span></span></b><span style='font-size:7.0pt;
  font-family:"Arial",sans-serif;mso-fareast-font-family:Arial;mso-ansi-language:
  ES-CO'>
                            <o:p></o:p>
                        </span></p>
                </td>
            </tr>
            <![if !supportMisalignedColumns]>
            <tr height=0>
                <td width=173 style='border:none'></td>
                <td width=119 style='border:none'></td>
                <td width=24 style='border:none'></td>
                <td width=103 style='border:none'></td>
                <td width=38 style='border:none'></td>
                <td width=101 style='border:none'></td>
                <td width=32 style='border:none'></td>
                <td width=61 style='border:none'></td>
                <td width=31 style='border:none'></td>
                <td width=28 style='border:none'></td>
                <td width=77 style='border:none'></td>
            </tr>
            <![endif]>
        </table>

        <p class=MsoNormal style='margin-top:.25pt'><span style='font-size:3.0pt;
font-family:"Times New Roman",serif;mso-fareast-font-family:"Times New Roman";
mso-ansi-language:ES-CO'>
                <o:p>&nbsp;</o:p>
            </span></p>

        <p class=MsoNormal><span style='mso-ansi-language:ES-CO'><br clear=all style='mso-special-character:line-break'>
                <o:p></o:p>
            </span></p>

        <p class=MsoNormal><span style='mso-ansi-language:ES-CO'>
                <o:p>&nbsp;</o:p>
            </span></p>

    </div>

</body>

</html>