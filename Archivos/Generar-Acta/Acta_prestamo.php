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

  include ('../db/conexion.php');

  if (isset($_POST['generaractaprestamo'])) {
    
    $id= $_POST['id'];
    $teclado= $_POST['teclado'];
    $serialteclado= strtoupper($_POST['steclado']);
    $mouse= $_POST['mouse'];
    $serialmouse= strtoupper($_POST['smouse']);
    $maletin= $_POST['bag'];
    $guaya= $_POST['guaya'];    
    $otros= ucfirst(strtolower($_POST['otros']));
    $observaciones= strtoupper($_POST['observaciones']);
    $cargador= strtoupper($_POST['cargador']);
    $nombrepc= strtoupper($_POST['nombrepc']);
    $tipoacta= 'prestamo';
$query = "SELECT * FROM $tabla3 WHERE id = '$id' ";
$resultado = mysqli_query($con, $query);

  if ($fila = $resultado->fetch_assoc()) {
    $codigoavon = $fila['Codigo'];    
    $usuario1 = $fila['upres'];
    $fechapresta1 = $fila['fpres'];
    $fechaentrega1 = $fila['fdel'];
    $serialpc = $fila['nserial'];
    

$fechapresta = strftime("%A %e de %B de %Y", strtotime($fechapresta1)); 
$fechaentrega = strftime("%A %e de %B de %Y", strtotime($fechaentrega1)); 
 
  }

  $query2 = "SELECT * FROM $tabla5 WHERE id = '$usuario1' ";
$resultado2 = mysqli_query($con, $query2);
if ($fila2 = $resultado2->fetch_assoc()) {
$cargo = $fila2['cargo'];
$area = $fila2['area'];
$cedula = $fila2['cedula'];
$usuario = $fila2['nombre'];
}

$itusuario= $_SESSION['username'];
  $query3 = "SELECT * FROM $tabla2 WHERE unombre = '$itusuario' ";
$resultado3 = mysqli_query($con, $query3);
if ($fila3 = $resultado3->fetch_assoc()) {
$itcargo = $fila3['cargo'];
$itcedula = $fila3['cedula'];

}

$check7 = "SELECT * FROM $tabla7 WHERE actaid='$id' AND tipoacta='$tipoacta' ";
$resultado7 = mysqli_query($con, $check7);
$filas7 = mysqli_num_rows($resultado7);

     if ($filas7>0) {      
                $query=$con->query("UPDATE $tabla7 SET actaid='$id',tipo='',maleta='$maletin',guaya='$guaya',teclado='$teclado',mouse='$mouse',cd='',cdsn='',tecladosn='$serialteclado',mousesn='$serialmouse',monitormarca='',monitormodelo='',otros='$otros',observaciones='$observaciones' WHERE actaid='$id' AND tipoacta='$tipoacta'");
                $query=$con->query("UPDATE $tabla3 SET nombreequipo='$nombrepc',cargador='$cargador' WHERE id='$id'");

    }else{
                $con->query("INSERT INTO $tabla7 (actaid,tipoacta,tipo,maleta,guaya,teclado,mouse,cd,cdsn,tecladosn,mousesn,monitormarca,monitormodelo,otros,observaciones) VALUES ('$id','$tipoacta','','$maletin','$guaya','$teclado','$mouse','','','$serialteclado','$serialmouse','','','$otros','$observaciones')");
                $query=$con->query("UPDATE $tabla3 SET nombreequipo='$nombrepc',cargador='$cargador' WHERE id='$id'");

    }

    
}






}else{

   header("location: ../usr/login.php");
}


?>


<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:m="http://schemas.microsoft.com/office/2004/12/omml"
xmlns:st1="urn:schemas-microsoft-com:office:smarttags"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=unicode">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 15">
<meta name=Originator content="Microsoft Word 15">
<link rel=File-List href="Acta_prestamo_archivos/filelist.xml">
<link rel=Edit-Time-Data href="Acta_prestamo_archivos/editdata.mso">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
w\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<title><?php echo $serialpc; ?></title>
<o:SmartTagType namespaceuri="urn:schemas-microsoft-com:office:smarttags"
 name="PersonName"/>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>kmquintero</o:Author>
  <o:LastAuthor>Mauricio Ortiz Rios/HPE/Consultant</o:LastAuthor>
  <o:Revision>11</o:Revision>
  <o:TotalTime>15</o:TotalTime>
  <o:LastPrinted>2016-11-04T18:51:00Z</o:LastPrinted>
  <o:Created>2019-11-07T23:06:00Z</o:Created>
  <o:LastSaved>2019-11-07T23:34:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Words>830</o:Words>
  <o:Characters>4566</o:Characters>
  <o:Company>LC</o:Company>
  <o:Lines>38</o:Lines>
  <o:Paragraphs>10</o:Paragraphs>
  <o:CharactersWithSpaces>5386</o:CharactersWithSpaces>
  <o:Version>16.00</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<link rel=themeData href="Acta_prestamo_archivos/themedata.thmx">
<link rel=colorSchemeMapping
href="Acta_prestamo_archivos/colorschememapping.xml">
<!--[if gte mso 9]><xml>
 <w:WordDocument>
  <w:SpellingState>Clean</w:SpellingState>
  <w:GrammarState>Clean</w:GrammarState>
  <w:TrackMoves>false</w:TrackMoves>
  <w:TrackFormatting/>
  <w:HyphenationZone>21</w:HyphenationZone>
  <w:ValidateAgainstSchemas/>
  <w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>
  <w:IgnoreMixedContent>false</w:IgnoreMixedContent>
  <w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>
  <w:DoNotPromoteQF/>
  <w:LidThemeOther>ES-CO</w:LidThemeOther>
  <w:LidThemeAsian>X-NONE</w:LidThemeAsian>
  <w:LidThemeComplexScript>X-NONE</w:LidThemeComplexScript>
  <w:Compatibility>
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
  DefSemiHidden="false" DefQFormat="false" LatentStyleCount="376">
  <w:LsdException Locked="false" QFormat="true" Name="Normal"/>
  <w:LsdException Locked="false" QFormat="true" Name="heading 1"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 2"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 3"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 4"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 5"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 6"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 7"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 8"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="heading 9"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   QFormat="true" Name="caption"/>
  <w:LsdException Locked="false" QFormat="true" Name="Title"/>
  <w:LsdException Locked="false" Priority="1" Name="Default Paragraph Font"/>
  <w:LsdException Locked="false" QFormat="true" Name="Subtitle"/>
  <w:LsdException Locked="false" QFormat="true" Name="Strong"/>
  <w:LsdException Locked="false" QFormat="true" Name="Emphasis"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Sample"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="HTML Typewriter"/>
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Normal Table"/>
  <w:LsdException Locked="false" Priority="99" Name="No List"/>
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
  <w:LsdException Locked="false" SemiHidden="true" UnhideWhenUsed="true"
   Name="Table Theme"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   Name="Placeholder Text"/>
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
  <w:LsdException Locked="false" Priority="99" SemiHidden="true" Name="Revision"/>
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
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   UnhideWhenUsed="true" Name="Mention"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   UnhideWhenUsed="true" Name="Smart Hyperlink"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   UnhideWhenUsed="true" Name="Hashtag"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   UnhideWhenUsed="true" Name="Unresolved Mention"/>
  <w:LsdException Locked="false" Priority="99" SemiHidden="true"
   UnhideWhenUsed="true" Name="Smart Link"/>
 </w:LatentStyles>
</xml><![endif]--><!--[if !mso]><object
 classid="clsid:38481807-CA0E-42D2-BF39-B33AF135CC4D" id=ieooui></object>
<style>
st1\:*{behavior:url(#ieooui) }
</style>
<![endif]-->
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:"Cambria Math";
	panose-1:2 4 5 3 5 4 6 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:roman;
	mso-font-pitch:variable;
	mso-font-signature:3 0 0 0 1 0;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-536870145 1073786111 1 0 415 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520081665 -1073717157 41 0 66047 0;}
@font-face
	{font-family:"Segoe UI";
	panose-1:2 11 5 2 4 2 4 2 2 3;
	mso-font-charset:0;
	mso-generic-font-family:swiss;
	mso-font-pitch:variable;
	mso-font-signature:-520084737 -1073683329 41 0 479 0;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman",serif;
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-unhide:no;
	mso-style-link:"Encabezado Car";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 212.6pt right 425.2pt;
	font-size:12.0pt;
	font-family:"Times New Roman",serif;
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-unhide:no;
	mso-style-link:"Pie de página Car";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	tab-stops:center 212.6pt right 425.2pt;
	font-size:12.0pt;
	font-family:"Times New Roman",serif;
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-noshow:yes;
	mso-style-link:"Texto de globo Car";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:8.0pt;
	font-family:"Tahoma",sans-serif;
	mso-fareast-font-family:"Times New Roman";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
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
span.EncabezadoCar
	{mso-style-name:"Encabezado Car";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:Encabezado;
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
span.PiedepginaCar
	{mso-style-name:"Pie de página Car";
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Pie de página";
	mso-ansi-font-size:12.0pt;
	mso-bidi-font-size:12.0pt;
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
span.TextodegloboCar
	{mso-style-name:"Texto de globo Car";
	mso-style-noshow:yes;
	mso-style-unhide:no;
	mso-style-locked:yes;
	mso-style-link:"Texto de globo";
	mso-ansi-font-size:9.0pt;
	mso-bidi-font-size:9.0pt;
	font-family:"Segoe UI",sans-serif;
	mso-ascii-font-family:"Segoe UI";
	mso-hansi-font-family:"Segoe UI";
	mso-bidi-font-family:"Segoe UI";
	mso-ansi-language:ES;
	mso-fareast-language:ES;}
span.SpellE
	{mso-style-name:"";
	mso-spl-e:yes;}
.MsoChpDefault
	{mso-style-type:export-only;
	mso-default-props:yes;
	font-size:10.0pt;
	mso-ansi-font-size:10.0pt;
	mso-bidi-font-size:10.0pt;}
 /* Page Definitions */
 @page
	{mso-footnote-separator:url("Acta_prestamo_archivos/header.htm") fs;
	mso-footnote-continuation-separator:url("Acta_prestamo_archivos/header.htm") fcs;
	mso-endnote-separator:url("Acta_prestamo_archivos/header.htm") es;
	mso-endnote-continuation-separator:url("Acta_prestamo_archivos/header.htm") ecs;}
@page WordSection1
	{size:612.0pt 792.0pt;
	margin:42.55pt 1.0cm 70.9pt 1.0cm;
	mso-header-margin:34.0pt;
	mso-footer-margin:35.45pt;
	mso-header:url("Acta_prestamo_archivos/header.htm") h1;
	mso-footer:url("Acta_prestamo_archivos/header.htm") f1;
	mso-paper-source:0;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 @list l0
	{mso-list-id:47387921;
	mso-list-type:hybrid;
	mso-list-template-ids:756333502 201981967 201981977 201981979 201981967 201981977 201981979 201981967 201981977 201981979;}
@list l0:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l0:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:54.0pt;
	mso-level-number-position:left;
	margin-left:54.0pt;
	text-indent:-18.0pt;}
@list l0:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:90.0pt;
	mso-level-number-position:right;
	margin-left:90.0pt;
	text-indent:-9.0pt;}
@list l0:level4
	{mso-level-tab-stop:126.0pt;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l0:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:162.0pt;
	mso-level-number-position:left;
	margin-left:162.0pt;
	text-indent:-18.0pt;}
@list l0:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:198.0pt;
	mso-level-number-position:right;
	margin-left:198.0pt;
	text-indent:-9.0pt;}
@list l0:level7
	{mso-level-tab-stop:234.0pt;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l0:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:270.0pt;
	mso-level-number-position:left;
	margin-left:270.0pt;
	text-indent:-18.0pt;}
@list l0:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:306.0pt;
	mso-level-number-position:right;
	margin-left:306.0pt;
	text-indent:-9.0pt;}
@list l1
	{mso-list-id:1009596797;
	mso-list-type:hybrid;
	mso-list-template-ids:767591400 201981967 201981977 201981979 201981967 201981977 201981979 201981967 201981977 201981979;}
@list l1:level1
	{mso-level-tab-stop:18.0pt;
	mso-level-number-position:left;
	margin-left:18.0pt;
	text-indent:-18.0pt;}
@list l1:level2
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:54.0pt;
	mso-level-number-position:left;
	margin-left:54.0pt;
	text-indent:-18.0pt;}
@list l1:level3
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:90.0pt;
	mso-level-number-position:right;
	margin-left:90.0pt;
	text-indent:-9.0pt;}
@list l1:level4
	{mso-level-tab-stop:126.0pt;
	mso-level-number-position:left;
	margin-left:126.0pt;
	text-indent:-18.0pt;}
@list l1:level5
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:162.0pt;
	mso-level-number-position:left;
	margin-left:162.0pt;
	text-indent:-18.0pt;}
@list l1:level6
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:198.0pt;
	mso-level-number-position:right;
	margin-left:198.0pt;
	text-indent:-9.0pt;}
@list l1:level7
	{mso-level-tab-stop:234.0pt;
	mso-level-number-position:left;
	margin-left:234.0pt;
	text-indent:-18.0pt;}
@list l1:level8
	{mso-level-number-format:alpha-lower;
	mso-level-tab-stop:270.0pt;
	mso-level-number-position:left;
	margin-left:270.0pt;
	text-indent:-18.0pt;}
@list l1:level9
	{mso-level-number-format:roman-lower;
	mso-level-tab-stop:306.0pt;
	mso-level-number-position:right;
	margin-left:306.0pt;
	text-indent:-9.0pt;}
ol
	{margin-bottom:0cm;}
ul
	{margin-bottom:0cm;}
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
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman",serif;}
table.MsoTableGrid
	{mso-style-name:"Tabla con cuadrícula";
	mso-tstyle-rowband-size:0;
	mso-tstyle-colband-size:0;
	mso-style-unhide:no;
	border:solid windowtext 1.0pt;
	mso-border-alt:solid windowtext .5pt;
	mso-padding-alt:0cm 5.4pt 0cm 5.4pt;
	mso-border-insideh:.5pt solid windowtext;
	mso-border-insidev:.5pt solid windowtext;
	mso-para-margin:0cm;
	mso-para-margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:10.0pt;
	font-family:"Times New Roman",serif;}
</style>
<![endif]-->
<meta charset=UTF-8>
<meta name=viewport
content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel=icon href="../images/login.png">
<!--[if gte mso 9]><xml>
 <o:shapedefaults v:ext="edit" spidmax="2049"/>
</xml><![endif]--><!--[if gte mso 9]><xml>
 <o:shapelayout v:ext="edit">
  <o:idmap v:ext="edit" data="1"/>
 </o:shapelayout></xml><![endif]-->
</head>

<body lang=ES-CO style='tab-interval:35.4pt'>

<div class=WordSection1>

<p class=MsoNormal align=center style='text-align:center'><!--[if gte vml 1]><v:shapetype
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
</v:shapetype><v:shape id="Imagen_x0020_2" o:spid="_x0000_s1026" type="#_x0000_t75"
 alt="avon" style='position:absolute;left:0;text-align:left;margin-left:71.8pt;
 margin-top:-.75pt;width:123pt;height:45pt;z-index:-251658752;visibility:visible;
 mso-wrap-style:square;mso-width-percent:0;mso-height-percent:0;
 mso-wrap-distance-left:9pt;mso-wrap-distance-top:0;mso-wrap-distance-right:9pt;
 mso-wrap-distance-bottom:0;mso-position-horizontal:right;
 mso-position-horizontal-relative:margin;mso-position-vertical:absolute;
 mso-position-vertical-relative:margin;mso-width-percent:0;
 mso-height-percent:0;mso-width-relative:page;mso-height-relative:page'>
 <v:imagedata src="Acta_prestamo_archivos/image001.gif" o:title="avon"/>
 <w:wrap type="tight" anchorx="margin" anchory="margin"/>
</v:shape><![endif]--><![if !vml]><img width=164 height=60
src="Acta_prestamo_archivos/image002.jpg" align=right hspace=12 alt=avon
v:shapes="Imagen_x0020_2"><![endif]><b style='mso-bidi-font-weight:normal'><span
lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'><o:p></o:p></span></b></p>

<p class=MsoHeader style='tab-stops:center 212.6pt right 513.0pt'><span
lang=ES-MX style='font-family:"Arial",sans-serif;mso-ansi-language:ES-MX'>IT –
Avon Colombia</span><span lang=ES-TRAD style='font-size:8.0pt;mso-ansi-language:
ES-TRAD'><o:p></o:p></span></p>

<p class=MsoNormal><span lang=ES-TRAD style='font-size:8.0pt;mso-ansi-language:
ES-TRAD'><?php echo $codigoavon; ?><o:p></o:p></span></p>

<p class=MsoNormal><span lang=ES-TRAD style='font-size:8.0pt;mso-ansi-language:
ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><span lang=ES-TRAD style='font-size:8.0pt;mso-ansi-language:
ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
style='font-size:11.0pt;mso-bidi-font-size:10.0pt;font-family:"Calibri",sans-serif;
mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><span
style='mso-spacerun:yes'>                                             
</span>PRESTAMO DE PORTÁTIL AL EMPLEADO PARA SU MANEJO Y CUSTODIA<o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=715
 style='width:536.4pt;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
 .5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>FECHA DE PRESTAMO<o:p></o:p></span></b></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo $fechapresta; ?><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;color:black;mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>FECHA
  DE DEVOLUCION:</span></b><b style='mso-bidi-font-weight:normal'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><span style='mso-spacerun:yes'></span><?php echo $fechaentrega; ?><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;color:black;mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>CODIGO
  AVON</span></b><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo $codigoavon; ?><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;color:black;mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>EQUIPO</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo $nombrepc; ?><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;color:black;mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>SERIAL</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><b style='mso-bidi-font-weight:normal'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo $serialpc; ?><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5'>
  <td width=715 colspan=2 valign=top style='width:536.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>DATOS DEL EMPLEADO QUE
  RECIBE EL EQUIPO</span></b><b style='mso-bidi-font-weight:normal'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:10.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Nombres
  y apellidos completos del Empleado:<o:p></o:p></span></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:10.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><?php echo "$usuario"; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:10.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Documento
  de Identidad:<o:p></o:p></span></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:10.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><?php echo "$cedula"; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:8'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:10.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Cargo
  actual:<o:p></o:p></span></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='tab-stops:40.5pt'><span lang=ES-TRAD
  style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo "$cargo"; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:9;mso-yfti-lastrow:yes'>
  <td width=331 valign=top style='width:248.4pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:10.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Área
  a la que pertenece:<o:p></o:p></span></p>
  </td>
  <td width=384 valign=top style='width:288.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=EN-US style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:EN-US'><?php echo "$area"; ?><o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=EN-US style='font-size:10.0pt;font-family:"Calibri",sans-serif;
mso-bidi-font-family:Arial;mso-ansi-language:EN-US'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'>Todos los datos del cuadro siguiente deben
completarse. Si se entrega un elemento no relacionado, debe adicionarse en el
campo otros.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=716
 style='width:537.0pt;border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
 .5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=158 rowspan=2 style='width:118.8pt;border:solid windowtext 1.0pt;
  mso-border-alt:solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'>HARDWARE<o:p></o:p></span></b></p>
  </td>
  <td width=189 rowspan=2 style='width:5.0cm;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>Descripción</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=76 colspan=2 valign=top style='width:2.0cm;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>Entrega</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=217 rowspan=2 style='width:163.05pt;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>SOFTWARE</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=76 colspan=2 style='width:2.0cm;border:solid windowtext 1.0pt;
  border-left:none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:
  solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>Entrega</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:7.55pt'>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt;
  height:7.55pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>Si</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt;
  height:7.55pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>No</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt;
  height:7.55pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>Si</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;background:#CCCCCC;padding:0cm 5.4pt 0cm 5.4pt;
  height:7.55pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;color:black;
  mso-color-alt:windowtext;mso-ansi-language:ES-TRAD'>No</span></b><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:10.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p></o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Cargador <o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo "$cargador"; ?><o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($cargador<>""){ echo "X";}else{echo "";} ?><o:p></o:p></span></b></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($cargador<>""){ echo "";}else{echo "X";} ?></span></b><span lang=ES-TRAD style='font-size:9.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p></o:p></span></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Microsoft Office versión 365<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES
  style='font-family:"Calibri",sans-serif'>X<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;height:6.45pt'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Mouse<o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo "$serialmouse"; ?><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($mouse=="Si"){ echo "X";}else{echo "";} ?></span></b><span lang=ES style='font-family:"Calibri",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($mouse=="Si"){ echo "";}else{echo "X";} ?><o:p></o:p></span></b></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>SW de antivirus<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES
  style='font-family:"Calibri",sans-serif'>X<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:6.45pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;height:5.95pt'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Maletín<o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($maletin=="Si"){ echo "X";}else{echo "";} ?></span></b><span lang=ES style='font-family:"Calibri",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($maletin=="Si"){ echo "";}else{echo "X";} ?><o:p></o:p></span></b></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>JAVA<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES
  style='font-family:"Calibri",sans-serif'>X<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:5.95pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Guaya<o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($guaya=="Si"){ echo "X";}else{echo "";} ?></span></b><span lang=ES style='font-family:"Calibri",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($guaya=="Si"){ echo "";}else{echo "X";} ?><o:p></o:p></span></b></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:9.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Flash
  Player<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES
  style='font-family:"Calibri",sans-serif'>X<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Teclado<o:p></o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo "$serialteclado"; ?><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($teclado=="Si"){ echo "X";}else{echo "";} ?></span></b><span lang=ES style='font-family:"Calibri",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($teclado=="Si"){ echo "";}else{echo "X";} ?></span></b><span lang=ES style='font-family:"Calibri",sans-serif'><o:p></o:p></span></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Adobe<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES
  style='font-family:"Calibri",sans-serif'>X<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
  normal'><span lang=ES-TRAD style='font-size:9.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal><span lang=ES-TRAD style='font-size:9.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>VPN<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES
  style='font-family:"Calibri",sans-serif'>X</span><b style='mso-bidi-font-weight:
  normal'><span lang=ES-TRAD style='font-size:9.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p></o:p></span></b></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify'><b style='mso-bidi-font-weight:
  normal'><span lang=ES-TRAD style='font-size:9.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:8;mso-yfti-lastrow:yes;height:25.8pt'>
  <td width=158 valign=top style='width:118.8pt;border:solid windowtext 1.0pt;
  border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:25.8pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Otros: <?php echo "$otros"; ?><o:p></o:p></span></p>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=189 valign=top style='width:5.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><?php echo "$observaciones"; ?><o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($otros<>""){ echo "X";}else{echo "";} ?><o:p></o:p></span></b></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span lang=ES-TRAD style='font-size:9.0pt;
  font-family:"Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:
  ES-TRAD'><?php if ($otros<>""){ echo "";}else{echo "X";} ?></span></b><span lang=ES-TRAD style='font-size:9.0pt;font-family:
  "Calibri",sans-serif;mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'><o:p></o:p></span></p>
  </td>
  <td width=217 valign=top style='width:163.05pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:25.8pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'>Otros:<o:p></o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:25.8pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
  <td width=38 valign=top style='width:1.0cm;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:25.8pt'>
  <p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
  style='font-size:9.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
  Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal style='text-align:justify;line-height:150%'><span
lang=ES-TRAD style='font-size:7.0pt;line-height:150%;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'>Los firmantes de ésta Acta damos constancia y
declaramos que:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;line-height:150%;mso-list:l1 level1 lfo2;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:7.0pt;line-height:150%;font-family:"Arial",sans-serif;
mso-fareast-font-family:Arial;mso-ansi-language:ES-TRAD'><span
style='mso-list:Ignore'>1.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span lang=ES-TRAD style='font-size:7.0pt;
line-height:150%;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Los
elementos aquí relacionados, han sido recibidos a satisfacción y así mismo
adquirimos el compromiso de leer y aplicar las instrucciones de uso y custodia
que se entregan al responsable del equipo y nos comprometemos a cumplir todas
las recomendaciones y las Políticas de Seguridad de Información.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;line-height:150%;mso-list:l1 level1 lfo2;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:7.0pt;line-height:150%;font-family:"Arial",sans-serif;
mso-fareast-font-family:Arial;mso-ansi-language:ES-TRAD'><span
style='mso-list:Ignore'>2.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span></span><![endif]><span lang=ES-TRAD style='font-size:7.0pt;
line-height:150%;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>El
empleado será el único responsable por la pérdida o robo del equipo dentro o
fuera de las instalaciones de Avon, o de cualquier daño causado al mismo, salvo
del deterioro natural. Asimismo, el empleado autoriza expresamente a Avon para
que descuente de su nómina, el monto equivalente al valor de las reparaciones o
reposición del equipo.<span style='mso-spacerun:yes'>  </span><o:p></o:p></span></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'>INSTRUCCIONES DE USO Y CUSTODIA DE EQUIPOS<o:p></o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-size:10.0pt;font-family:"Arial",sans-serif;
mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b style='mso-bidi-font-weight:
normal'><span lang=ES-TRAD style='font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'><o:p>&nbsp;</o:p></span></b></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>A
partir de la fecha, usted es responsable de la <span style='mso-tab-count:1'>   </span>|custodia
y cuidado permanente del equipo recibido y de los elementos detallados en el
recuadro de descripción y características del equipo, por lo tanto, no está
autorizado para trasladar este equipo a otro funcionario sin oportuna
autorización del área de Sistemas de la compañía.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Debe
leer cuidadosamente y cumplir con las siguientes medidas:<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Generales:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Si es equipo portátil, mantenga siempre el equipo con Guaya mientras
este en las instalaciones de la empresa.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>El equipo debe ser utilizado sólo para actividades relacionadas con el
negocio de <st1:PersonName ProductID="la Compa￱￭a." w:st="on">la Compañía.</st1:PersonName><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Bloquear equipo en recesos.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Esté atento a todas las medidas de seguridad para evitar el hurto o
extravío del equipo.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>5.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>El equipo ha sido construido dentro de márgenes de fortaleza para el
uso razonable que tienen los equipos de escritorio, por lo tanto deben evitarse
los golpes, caídas, maltrato, puesta de objetos sobre el mismo, temperaturas
extremas, radiaciones solares, utilización de químicos de cualquier naturaleza
para su limpieza, etc.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Cuidado
con el portátil en sus viajes:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>6.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Si está en otra locación AVON de visita laboral, si quiere evitar el
traslado del equipo al hotel en las horas de la noche, debe guardarlo en lugar
seguro. No debe ser entregado a ninguna otra persona inclusive si es empleado.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>7.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Manténgalo siempre con usted. No lo deje expuesto en vehículos
habitación o con empleados del hotel.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>8.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Por ninguna circunstancia debe considerarse como equipaje y siempre
debe llevarse a mano. Igual situación debe considerarse cuando el transporte
sea por vía terrestre<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>9.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Debido al efecto que pueda tener en las comunicaciones del avión el
equipo encendido, antes de utilizarlo dentro de éste, debe obtener autorización
de un miembro de la tripulación.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Uso
de programas y copia de respaldo:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>10.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Sólo está permitido el uso de programas y software instalado por
personal autorizado de <st1:PersonName ProductID="la Compa￱￭a. Nunca" w:st="on">la
 Compañía. Nunca</st1:PersonName> copie o duplique software no autorizado, la
piratería de software es una actividad ilícita en contra de la ley y puede
significar daños financieros y morales contra AVON COLOMBIA y contra usted.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>11.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>El software Antivirus debe estar siempre activo y con actualización
periódica. Utilícelo siempre para verificar disquetes-memorias <span
class=SpellE>usb</span>-etc. en uso.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>12.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Para realizar conexión remota a los sistemas de <st1:PersonName
ProductID="la Compa￱￭a" w:st="on">la Compañía</st1:PersonName> a través de VPN,
debe ser un usuario autorizado, contar con el software definido por <st1:PersonName
ProductID="la Compa￱￭a" w:st="on">la Compañía</st1:PersonName> y cumplir con
las normas de acceso externo. <o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>13.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Mantenga siempre sus archivos más importantes de trabajo en las
unidades G o H definidas por la empresa y a las cuales periódicamente se les
realiza un completo <span class=SpellE>backup</span>.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Fallas
técnicas:<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>14.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Cualquier falla que se presente debe ser informada inmediatamente al
personal de IT HELP DESK donde se encuentre. Por ninguna circunstancia, permita
la intervención de terceros o personal no autorizado para repararlo.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'>Atención.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>15.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Antes de utilizar el equipo debe conocer las normas y políticas de
Seguridad de <st1:PersonName ProductID="la Informaci￳n." w:st="on">la
 Información.</st1:PersonName><o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>16.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Para mayor información y soporte dirigirse al área de Tecnología.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>17.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>En el evento de retiro de <st1:PersonName ProductID="la Compa￱￭a"
w:st="on">la Compañía</st1:PersonName>, la constancia de recibo del equipo y
todos los elementos relacionados en el presente, será requisito para la firma
del paz y salvo respectivo.<o:p></o:p></span></p>

<p class=MsoNormal style='margin-left:18.0pt;text-align:justify;text-indent:
-18.0pt;mso-list:l0 level1 lfo4;tab-stops:list 18.0pt'><![if !supportLists]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-fareast-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-list:Ignore'>18.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp; </span></span></span><![endif]><span
lang=ES-TRAD style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:
ES-TRAD'>Muy especialmente tenga en cuenta la política de seguridad de la
información que dice: <b style='mso-bidi-font-weight:normal'>“</b>Usted es responsable
de usar los recursos y la información a la que tiene acceso, solamente para
propósitos del negocio<b style='mso-bidi-font-weight:normal'>”</b>.<o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:8.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-spacerun:yes'>        </span><u>X___________________________________</u><span
style='mso-tab-count:2'>                     </span><span
style='mso-spacerun:yes'>                        </span><u>X_________________________________<o:p></o:p></u></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-tab-count:1'>                </span><span
style='mso-spacerun:yes'>             </span>FIRMA DEL EMPLEADO<span
style='mso-tab-count:4'>                                                        </span><span
style='mso-spacerun:yes'>            </span>FIRMA PERSONA DE IT QUE ENTREGA<span
style='mso-tab-count:1'>                </span><o:p></o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='margin-left:21.05pt;border-collapse:collapse;border:none;mso-border-alt:
 solid windowtext .5pt;mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes'>
  <td width=378 valign=top style='width:10.0cm;border:solid white 1.0pt;
  mso-border-themecolor:background1;mso-border-alt:solid white .5pt;mso-border-themecolor:
  background1;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify;tab-stops:35.4pt 105.75pt'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Nombre: <?php echo "$usuario"; ?><o:p></o:p></span></p>
  </td>
  <td width=246 valign=top style='width:184.25pt;border:solid white 1.0pt;
  mso-border-themecolor:background1;border-left:none;mso-border-left-alt:solid white .5pt;
  mso-border-left-themecolor:background1;mso-border-alt:solid white .5pt;
  mso-border-themecolor:background1;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify;tab-stops:35.4pt 105.75pt'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Nombre: <?php echo "$itusuario"; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1'>
  <td width=378 valign=top style='width:10.0cm;border:solid white 1.0pt;
  mso-border-themecolor:background1;border-top:none;mso-border-top-alt:solid white .5pt;
  mso-border-top-themecolor:background1;mso-border-alt:solid white .5pt;
  mso-border-themecolor:background1;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify;tab-stops:35.4pt 105.75pt'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Cargo: <?php echo "$cargo"; ?><o:p></o:p></span></p>
  </td>
  <td width=246 valign=top style='width:184.25pt;border-top:none;border-left:
  none;border-bottom:solid white 1.0pt;mso-border-bottom-themecolor:background1;
  border-right:solid white 1.0pt;mso-border-right-themecolor:background1;
  mso-border-top-alt:solid white .5pt;mso-border-top-themecolor:background1;
  mso-border-left-alt:solid white .5pt;mso-border-left-themecolor:background1;
  mso-border-alt:solid white .5pt;mso-border-themecolor:background1;padding:
  0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify;tab-stops:35.4pt 105.75pt'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Cargo: <?php echo "$itcargo"; ?><o:p></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;mso-yfti-lastrow:yes'>
  <td width=378 valign=top style='width:10.0cm;border:solid white 1.0pt;
  mso-border-themecolor:background1;border-top:none;mso-border-top-alt:solid white .5pt;
  mso-border-top-themecolor:background1;mso-border-alt:solid white .5pt;
  mso-border-themecolor:background1;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify;tab-stops:35.4pt 105.75pt'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Cedula: <?php echo "$cedula"; ?><o:p></o:p></span></p>
  </td>
  <td width=246 valign=top style='width:184.25pt;border-top:none;border-left:
  none;border-bottom:solid white 1.0pt;mso-border-bottom-themecolor:background1;
  border-right:solid white 1.0pt;mso-border-right-themecolor:background1;
  mso-border-top-alt:solid white .5pt;mso-border-top-themecolor:background1;
  mso-border-left-alt:solid white .5pt;mso-border-left-themecolor:background1;
  mso-border-alt:solid white .5pt;mso-border-themecolor:background1;padding:
  0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='text-align:justify;tab-stops:35.4pt 105.75pt'><span
  lang=ES-TRAD style='font-size:10.0pt;font-family:"Calibri",sans-serif;
  mso-bidi-font-family:Arial;mso-ansi-language:ES-TRAD'>Cedula: <?php echo "$itcedula"; ?><o:p></o:p></span></p>
  </td>
 </tr>
</table>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:10.0pt;font-family:"Calibri",sans-serif;mso-bidi-font-family:
Arial;mso-ansi-language:ES-TRAD'><span style='mso-tab-count:1'>                </span><o:p></o:p></span></p>

<p class=MsoNormal><span lang=ES style='font-size:10.0pt;font-family:"Calibri",sans-serif;
display:none;mso-hide:all'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal style='text-align:justify'><span lang=ES-TRAD
style='font-size:9.0pt;font-family:"Arial",sans-serif;mso-ansi-language:ES-TRAD'><o:p>&nbsp;</o:p></span></p>

</div>

</body>

</html>

<?php

ob_end_flush();

?>