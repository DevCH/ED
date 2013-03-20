<?php

/*
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$arr = array(
"Es originario del lugar y acredita mínimo 2 años de residencia?", 
"Presentó original con copia del acta de nacimiento para su cotejo y devolución?", 
"Presentó Original con copia de la credencial de elector que acredita mayoría de edad?", 
"Sabe leer y escribir, presentó documentación comprobatoria del nivel de estudio o carta bajo protesta de decir verdad",
"Presenta constancia de laicismo",
"Tiene vigene sus derechos políticos",
"Es propietario de ningun antro ni establecimiento que expenda licores",
"Ha sido Delegado durante el periodo inmediato anterior",
"Es servidor público federal",
"Presenta por lo menos 50 firmas de votantes que lo apoyan en su comunidad",
);
*/
date_default_timezone_set('America/Mexico_City');

require_once('../vo/voConn.php');
require_once("../oFunctions.php");
require_once("../oCentura.php");

$arg = $_POST["data"];
parse_str($arg);

$F = oFunctions::getInstance();
$Conn = voConn::getInstance();
$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
mysql_select_db($Conn->db);
mysql_query("SET NAMES UTF8");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>SIEDMUN | Centro 2013 - 2015</title>
 	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/external/normalize.css" />
   	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/config.css" />
   	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/01/class_gen.css" />
   	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/01/forms.css" />
   	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/01/tables.css" />
	<link href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/external/pepper-grinder/jquery-ui-1.10.1.custom.css" rel="stylesheet" type="text/css"/>
   	<script src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/api/jquery-1.9.1.js"></script>
	<script src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/api/jquery-ui-1.10.1.custom.min.js"></script>
   	<script src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/api/prefixfree.min.js"></script>
	<script src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/api/jquery.formatCurrency-1.4.0.min.js"></script>
	<script src="http://187.157.37.204:8080/socket.io/socket.io.js" > </script> 
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/01/base.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/01/persistent.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/01/core.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/01/environment.js"></script>
	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/api/jquery.form.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/init.js"></script>
<style>
body{ font-size:16px;}
#formBody {position:relative;display:inline-block; vertical-align:top; width:98%; margin-top:1em; font-size:16px;}
input[type=radio]{ width:5em;}
input[type=text]{ width:20em;}
.separ1{ margin-bottom:0.5em;}
.separ2{ margin-right:0.5em;}
#formBody > fieldset{ padding:1em; width:97%;}
.doti{display:inline-block; vertical-align:top; margin-right: .3em;}
</style>

	
</head>

<body>

	<header >
		<h1><span id="span1"><span id="spanTit">SIEDMUN 1.0</span> | <span>SISTEMA INTEGRAL DE ELECCI&Oacute;N DE DELEGADOS MUNICIPALES</span> </span>
		    <span id="span2">
		    		<span id="spanUser"> </span> | <span id="closeSession">Cerrar Sesi&oacute;n</span> | <span id="span4"><?php echo $F->getDateLong(date('Y-m-d'),0); ?></span></span>
					   
		</h1>
	</header>
	<section id="bodysec" style="background:#EEE; padding:1em; margin:1em; width:96.5%;">
	
<h2 class="demoHeaders">PANEL DE REGISTRO</h2>
<div class="ui-widget" style="text-align:left !important;">
	<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-person doti"></span>
		<strong>Registro de: </strong> <?php echo strtoupper($nombrec); ?>
		<span class="ui-icon ui-icon-image doti" ></span>
		<strong>Comunidad: </strong> <?php echo strtoupper($txtlocalidad); ?></p>
	</div>
</div>
<form id="formBody"  class="form ui-widget-content" >
<?php
foreach($arr as $i=>$valor){
?>
	
	<fieldset class="fieldset-margin-left ui-state-highlight ui-corner-all">
	   		<label class="separ1" ><span class="ui-icon ui-icon-circle-arrow-e doti"></span> <?php echo $arr[$i]; ?> </label><br>
			<label for = "op<?php echo $i+1; ?>0" class="separ2">SI</label><input type = "radio" name = "op<?php echo $i+1; ?>" id = "op<?php echo $i+1; ?>0" value = "1"/>
			<label for = "op<?php echo $i+1; ?>1" class="separ2">NO</label><input type = "radio" name = "op<?php echo $i+1; ?>" id = "op<?php echo $i+1; ?>1" value = "0"/>
			<label for = "op<?php echo $i+1; ?>2" class="separ2">Incompleto</label><input type = "radio" name = "op<?php echo $i+1; ?>" id = "op<?php echo $i+1; ?>2" value = "2" checked = "checked"/>
	   		<label for="op<?php echo $i+1; ?>_desc" class="separ2">Obs </label>
			<input type="text" name="op<?php echo $i+1; ?>_desc" id="op<?php echo $i+1; ?>_desc" value="" />
			
	</fieldset><br><br>

<?php
}
?>
    <fieldset class="formContract">
        <input type="submit" value="Registrar Información" /><span style="width:50% !important; height:1em; display:inline-block" ></span>
        <input type="button" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" value="Cerrar Ventana" />

	<input type="hidden" name="idlocalidad" id="idlocalidad" value="<?php echo strtoupper($idlocalidad); ?>" />
	<input type="hidden" name="idcandidato" id="idcandidato" value="<?php echo strtoupper($idcandidato); ?>" />
    </fieldset>

</form>

	</section><!--bodysec-->
	
	<footer>H. Ayuntamiento Constitucional de Centro | <?php echo date('Y'); ?>  </footer>

</body>
</html>

