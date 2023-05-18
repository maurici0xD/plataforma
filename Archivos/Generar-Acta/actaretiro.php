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
  
  if (isset($_GET['id'])) {
    $id= $_GET['id'];
    $check7 = "SELECT * FROM $tabla5 WHERE actaid='$id' AND tipoacta='entrega' ";
    $resultado7 = mysqli_query($con, $check7);
    if (mysqli_num_rows($resultado7) > 0) {
      $itusuario = $_SESSION['username'];
      $n = mysqli_fetch_array($resultado7);
      $observaciones = $n['observaciones'];

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
        $placa = $rowm['placa'];
        $nombreequipo = $rowm['nombre'];
        $usuario = $rowm['nombreusuario'] ." ". $rowm['apellido'];
        $cargo = $rowm['cargo'];
        $area = $rowm['area'];
        $cedula = $rowm['cedula'];
        $correo = $rowm['correo'];
        $dominio = strpos($correo, '@');
        $dominio = substr($correo, 0, $dominio);
        $marcapc = $rowm['marca'];
        $modelopc = $rowm['modelo'];
        $querymodelo = "SELECT * FROM $tabla6 WHERE modelo_glpi = '$modelopc'";
        $resultadomodelo = mysqli_query($con, $querymodelo);
        if ($modeloconsulta = $resultadomodelo->fetch_assoc()) {
            $modelotraducido = $modeloconsulta['modelo'];
            $tipopc = $modeloconsulta['tipo'];
        }
        $serialpc = $rowm['serial'];
        $serialpantalla = $rowm['pantalla'];
        $sistema = $rowm['sistemaversion'];
        $pos = strpos($sistema, ' ');
        if ($pos !== false) {
          $sistema2 = substr($sistema, 0, $pos);
        } else {
          $sistema2 = $rowm['sistemaversion'];
        }
      }
  
      $query4 = "SELECT * FROM $tabla7 WHERE sistema_glpi = '$sistema2'";
      $resultado4 = mysqli_query($con, $query4);
      if ($sistemaconsulta = $resultado4->fetch_assoc()) {
        $sistematraducido = $sistemaconsulta['nombre'];
      }
     $nombreacta = "Acta retiro ".$usuario." ".date("d-m-Y");


    } else {
      $_SESSION['message'] = "Equipo sin acta de entrega registrada!";
      echo "<script type='text/javascript'>";
      echo "window.history.back(-1)";
      echo "</script>";   }
  }else{
    $_SESSION['message'] = "No se envio informacion de equipo";
    echo "<script type='text/javascript'>";
    echo "window.history.back(-1)";
    echo "</script>";
  }
}else{

header("location: ../usr/login.php");
}
?>
<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=unicode">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 15">
<meta name=Originator content="Microsoft Word 15">
<link rel=File-List href="Acta%20retiro.fld/filelist.xml">
<link rel="icon" href="../Login/favicon.png">
  <title><?php echo $nombreacta?></title>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Mauricio Rios Ortiz (DDB Group Medellin)</o:Author>
  <o:LastAuthor>Mauricio Rios Ortiz (DDB Group Medellin)</o:LastAuthor>
  <o:Revision>3</o:Revision>
  <o:TotalTime>62</o:TotalTime>
  <o:LastPrinted>2022-06-27T16:31:00Z</o:LastPrinted>
  <o:Created>2022-06-27T17:02:00Z</o:Created>
  <o:LastSaved>2022-06-27T17:09:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>279</o:Words>
  <o:Characters>2387</o:Characters>
  <o:Lines>159</o:Lines>
  <o:Paragraphs>45</o:Paragraphs>
  <o:CharactersWithSpaces>2621</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:AllowPNG/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<link rel=themeData href="Acta%20retiro.fld/themedata.thmx">
<link rel=colorSchemeMapping href="Acta%20retiro.fld/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:View>Print</w:View>
  <w:Zoom>124</w:Zoom>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:HyphenationZone>21</w:HyphenationZone>
  <w:PunctuationKerning/>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>ES-CO</w:LidThemeOther>
  <w:LidThemeAsian>ZH-CN</w:LidThemeAsian>
  <w:LidThemeComplexScript>AR-SA</w:LidThemeComplexScript>
  <w:Compatibility>
   <w:BreakWrappedTables/>
   <w:SnapToGridInCell/>
   <w:ApplyBreakingRules/>
   <w:WrapTextWithPunct/>
   <w:UseAsianBreakRules/>
   <w:DontGrowAutofit/>
   <w:SplitPgBreakAndParaMark/>
   <w:EnableOpenTypeKerning/>
   <w:DontFlipMirrorIndents/>
   <w:OverrideTableStyleHps/>
   <w:UseFELayout/>
  </w:Compatibility>
  <w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>
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
</xml><![endif]--><!--[if gte mso 9]><xml>
 <w:LatentStyles DefLockedState="false" DefUnhideWhenUsed="false"
  DefSemiHidden="false" DefQFormat="false" DefPriority="99"
  LatentStyleCount="376">
  <w:LsdException Locked="false" Priority="0" QFormat="true" Name="Normal"/>
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
  <w:LsdException Locked="false" Priority="39" Name="Table Grid"/>
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
  <w:LsdException Locked="false" Priority="34" QFormat="true"
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
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:-536870145 1107305727 0 0 415 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-536859905 -1073732485 9 0 511 0;}
@font-face
	{font-family:Consolas;
        src: url("Consolas.ttf");
	panose-1:2 11 6 9 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:modern;
	mso-font-pitch:fixed;
	mso-font-signature:-520092929 1073806591 9 0 415 0;}
@font-face
	{font-family:"Century Gothic";
        src: url("GOTHIC.TTF");
	panose-1:2 11 5 2 2 2 2 2 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:647 0 0 0 159 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:"Times New Roman";
	mso-fareast-theme-font:minor-fareast;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;}
a:link, span.MsoHyperlink
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:#0563C1;
	text-decoration:underline;
	text-underline:single;}
a:visited, span.MsoHyperlinkFollowed
	{mso-style-noshow:yes;
	mso-style-priority:99;
	color:#954F72;
	mso-themecolor:followedhyperlink;
	text-decoration:underline;
	text-underline:single;}
p.msonormal0, li.msonormal0, div.msonormal0
	{mso-style-name:msonormal;
	mso-style-unhide:no;
	mso-margin-top-alt:auto;
	margin-right:0cm;
	mso-margin-bottom-alt:auto;
	margin-left:0cm;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman",serif;
	mso-fareast-font-family:"Times New Roman";
	mso-fareast-theme-font:minor-fareast;}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-fareast-font-family:"Times New Roman";
	mso-fareast-theme-font:minor-fareast;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;}
@page WordSection1
	{size:595.3pt 841.9pt;
	margin:34.0pt 36.0pt 34.0pt 36.0pt;
	mso-header-margin:35.45pt;
	mso-footer-margin:35.45pt;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
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
	font-size:10.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;}
table.MsoTableGrid
	{mso-style-name:"Tabla con cuadrícula";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-priority:39;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Calibri",sans-serif;
	mso-ascii-font-family:Calibri;
	mso-ascii-theme-font:minor-latin;
	mso-hansi-font-family:Calibri;
	mso-hansi-theme-font:minor-latin;
	mso-bidi-font-family:"Times New Roman";
	mso-bidi-theme-font:minor-bidi;}
</style>
<![endif]--><!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="1026"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=ES-CO link="#0563C1" vlink="#954F72" style='tab-interval:35.4pt;
word-wrap:break-word'>

<div class=WordSection1>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=695
 style='width:521.05pt;border-collapse:collapse;border:none;mso-border-alt:
 solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:29.1pt'>
  <td width=695 colspan=6 style='width:521.05pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:29.1pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.5pt;font-family:"Century Gothic",sans-serif'>ACTA DE
  RETIRO EQUIPOS DE CÓMPUTO<o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>DATOS COLABORADOR</span></b><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>NOMBRE<o:p></o:p></span></p>
  </td>
  <td width=214 valign=top style='width:160.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>CARGO<o:p></o:p></span></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>USUARIO –
  DOMINIO<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;height:11.05pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.05pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php echo $usuario;?><o:p></o:p></span></p>
  </td>
  <td width=214 valign=top style='width:160.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.05pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php echo $cargo;?><o:p></o:p></span></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.05pt'>
  <p class=MsoNormal align=center style='text-align:center'><span class=SpellE><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php echo $dominio;?></span></span><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>E-MAIL<o:p></o:p></span></p>
  </td>
  <td width=214 valign=top style='width:160.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>AREA/DEPARTAMENTO<o:p></o:p></span></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>TEL/EXT<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><a
  href="mailto:Paulo.correa@zerogravity.com.co"><span style='font-size:10.0pt;
  font-family:"Century Gothic",sans-serif;mso-bidi-font-family:Calibri;
  text-decoration:none;text-underline:none'><?php echo $correo;?></span></a><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif;mso-bidi-font-family:
  Calibri;color:#0563C1'><o:p></o:p></span></p>
  </td>
  <td width=214 valign=top style='width:160.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php echo $area;?><o:p></o:p></span></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6;height:12.65pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>DESCRIPCION EQUIPO DE COMPUTO</span></b><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7;height:11.85pt'>
  <td width=109 colspan=2 valign=top style='width:81.5pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>TIPO<o:p></o:p></span></p>
  </td>
  <td width=94 valign=top style='width:70.15pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>NOMBRE<o:p></o:p></span></p>
  </td>
  <td width=111 valign=top style='width:83.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>MARCA<o:p></o:p></span></p>
  </td>
  <td width=214 valign=top style='width:160.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>MODELO<o:p></o:p></span></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>SERIAL<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:8;height:14.2pt'>
  <td width=74 valign=top style='width:55.35pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php if ($tipopc=='Laptop'){echo 'Laptop';}else{ if ($tipopc=='MacBook'){echo 'MacBook';}else{echo 'Laptop';}} ?><o:p></o:p></span></p>
  </td>
  <td width=35 style='width:26.15pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><?php if (($tipopc=='Laptop') || ($tipopc=='MacBook')){echo 'X';} ?><o:p></o:p></b></p>
  </td>
  <td width=94 rowspan=2 style='width:70.15pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-family:Consolas'><?php echo $placa;?><o:p></o:p></span></b></p>
  </td>
  <td width=111 rowspan=2 style='width:83.35pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php echo $marcapc;?><o:p></o:p></span></p>
  </td>
  <td width=214 rowspan=2 style='width:160.8pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:9.0pt;font-family:"Century Gothic",sans-serif'><?php echo $modelotraducido;?><o:p></o:p></span></p>
  </td>
  <td width=167 rowspan=2 style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-family:Consolas'><?php echo $serialpc;?><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:9;height:13.4pt'>
  <td width=74 valign=top style='width:55.35pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php if ($tipopc=='IMAC'){echo 'IMAC';}else{ if ($tipopc=='Desktop'){echo 'Desktop';}else{echo 'Desktop';}} ?><o:p></o:p></span></p>
  </td>
  <td width=35 style='width:26.15pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><?php if (($tipopc=='Desktop') || ($tipopc=='IMAC')){echo 'X';}?><o:p></o:p></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:10;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>CONTIGENCIAS / HOME OFFICE</span></b><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:11;height:88.7pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
  padding:0cm 3.5pt 0cm 3.5pt;height:88.7pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif;
  color:black;mso-themecolor:dark1'>Como empleado del Grupo DDB certifico que:<o:p></o:p></span></p>
  <p class=MsoNormal style='vertical-align:baseline'><span style='font-size:
  10.0pt;font-family:"Century Gothic",sans-serif;color:black;mso-themecolor:
  dark1'><span style='mso-spacerun:yes'>          </span><b>*</b> Cuento con
  conexión a internet de alta velocidad.<o:p></o:p></span></p>
  <p class=MsoNormal style='vertical-align:baseline'><b><span style='font-size:
  10.0pt;font-family:"Century Gothic",sans-serif;color:black;mso-themecolor:
  dark1'><span style='mso-spacerun:yes'>           </span>* Conozco y aplico la
  política de protección de datos y manejo de información confidencial.<o:p></o:p></span></b></p>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif;
  color:black;mso-themecolor:dark1'><span style='mso-spacerun:yes'>       
  </span><b><span style='mso-spacerun:yes'>  </span>*<span
  style='mso-spacerun:yes'>  </span></b>Todos mis archivos se encuentran
  almacenados de acuerdo a la política de manejo de archivos; en la nube de BOX
  y bajo las estructuras definidas.<o:p></o:p></span></p>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:12;height:13.4pt'>
  <td width=74 valign=top style='width:55.35pt;border:none;border-left:solid windowtext 1.0pt;
  mso-border-left-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:13.4pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=35 valign=top style='width:26.15pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:13.4pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=94 valign=top style='width:70.15pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:13.4pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=111 valign=top style='width:83.35pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:13.4pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=214 valign=top style='width:160.8pt;border:none;padding:0cm 5.4pt 0cm 5.4pt;
  height:13.4pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-top-alt:solid windowtext .5pt;mso-border-bottom-alt:
  solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;padding:
  0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal><span style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'>FIRMA
  EMPLEADO<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:13;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;background:#D0CECE;mso-background-themecolor:
  background2;mso-background-themeshade:230;padding:0cm 5.4pt 0cm 5.4pt;
  height:13.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>ESTADO EQUIPO</span></b><b><span style='font-size:
  11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:14;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>Equipo
  en perfecto estado físico y funcional.<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:15;height:14.2pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-left-alt:solid windowtext .5pt;mso-border-bottom-alt:
  solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;padding:
  0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:16;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>OBSERVACIONES</span></b><b><span style='font-size:
  11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:17;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border-top:none;
  border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>Equipo
  en perfecto estado físico y funcional. <?php echo $observaciones;?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:18;height:14.2pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-left-alt:solid windowtext .5pt;mso-border-bottom-alt:
  solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;padding:
  0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:19;height:14.2pt'>
  <td width=74 valign=top style='width:55.35pt;border-top:none;border-left:
  solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-left-alt:solid windowtext .5pt;mso-border-bottom-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=35 valign=top style='width:26.15pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.2pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=94 valign=top style='width:70.15pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.2pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=111 valign=top style='width:83.35pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.2pt'>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
  <td width=214 style='width:160.8pt;border:none;border-bottom:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;
  height:14.2pt'>
  <p class=MsoNormal align=right style='text-align:right'><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'>FECHA:<o:p></o:p></span></p>
  </td>
  <td width=167 valign=top style='width:125.25pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-top-alt:solid windowtext .5pt;
  mso-border-bottom-alt:solid windowtext .5pt;mso-border-right-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:14.2pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'><?php echo $fechaimprime;?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:20;height:214.0pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 3.5pt 0cm 3.5pt;height:214.0pt'>
  <p class=MsoNormal><span style='font-size:10.5pt;font-family:"Century Gothic",sans-serif;
  color:black;mso-themecolor:dark1'>Certifico que los elementos detallados en
  el presente documento, me han sido entregados en las cantidades descritas
  para mi cuidado y custodia con el propósito de cumplir con las tareas y
  asignaciones propias de mi cargo en la empresa, siendo estos de mi única y
  exclusiva responsabilidad. Me comprometo a usar correctamente los recursos, y
  solo para los fines establecidos, a no instalar ni permitir la instalación de
  software por personal ajeno al área de Sistemas; declaro además conocer y
  cumplir las normas internas actualizadas de seguridad TIC, publicadas y
  accesibles en todo momento desde la intranet de la empresa, (<u>https://ddbco.sharepoint.com/sites/Intranet-</u>
  Sección Sistema Integrado de Gestión - carpeta Documentos de los
  Procesos-carpeta Tecnología de la Información-Procedimientos. <b><u>Todo daño
  físico causado por maltrato o por el uso inapropiado de los equipos
  asignados, el robo o pérdida de éstos es de mi única y exclusiva
  responsabilidad</u></b>, por lo cual autorizo se descuente el valor
  correspondiente del pago de nómina; en caso de finalizar mi contrato laboral
  me comprometo a realizar la devolución de la totalidad de los equipos
  asignados y autorizo el descuento de salarios, prestaciones sociales,
  vacaciones, indemnizaciones, bonificaciones, auxilios y demás derechos que me
  correspondan del valor correspondiente a daños, pérdida o robo de los equipos
  en comento.<o:p></o:p></span></p>
  <p class=MsoNormal><o:p>&nbsp;</o:p></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:21;height:13.4pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:13.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>RETIRO DE EQUIPO</span></b><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:22;height:12.65pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>RECIBE</span></b><b><span style='font-size:11.0pt;
  font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D0CECE;mso-background-themecolor:
  background2;mso-background-themeshade:230;padding:0cm 5.4pt 0cm 5.4pt;
  height:12.65pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>ENTREGA</span></b><b><span style='font-size:11.0pt;
  font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:23;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>NOMBRE:
    <?php echo $usuario;?><o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>NOMBRE:
    <?php echo $itusuario;?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:24;height:32.1pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:32.1pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FIRMA:<o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:32.1pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FIRMA:<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:25;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FECHA: <?php echo $fechaimprime;?><o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FECHA: <?php echo $fechaimprime;?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:26;height:12.65pt'>
  <td width=695 colspan=6 valign=top style='width:521.05pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>INGRESO DE EQUIPO</span></b><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:27;height:12.65pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#D0CECE;mso-background-themecolor:background2;mso-background-themeshade:
  230;padding:0cm 5.4pt 0cm 5.4pt;height:12.65pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>RECIBE</span></b><span style='font-size:10.0pt;
  font-family:"Century Gothic",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#D0CECE;mso-background-themecolor:
  background2;mso-background-themeshade:230;padding:0cm 5.4pt 0cm 5.4pt;
  height:12.65pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:11.0pt;font-family:"Century Gothic",sans-serif;color:black;
  mso-color-alt:windowtext'>ENTREGA</span></b><span style='font-size:10.0pt;
  font-family:"Century Gothic",sans-serif'><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:28;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>NOMBRE:
  <o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>NOMBRE:
    <?php echo $usuario;?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:29;height:24.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:24.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FIRMA<o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:24.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FIRMA<o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:30;mso-yfti-lastrow:yes;height:11.85pt'>
  <td width=313 colspan=4 valign=top style='width:235.0pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FECHA:<o:p></o:p></span></p>
  </td>
  <td width=381 colspan=2 valign=top style='width:286.05pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:11.85pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;font-family:"Century Gothic",sans-serif'>FECHA:<o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal><o:p>&nbsp;</o:p></p>

</div>

</body>

</html>
