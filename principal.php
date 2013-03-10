<?php
require_once("php/01/oFunctions.php");
$f = oFunctions::getInstance();

?>
<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>SIEDEMUN | Centro 2013 - 2015</title>
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
	
	<script>
		var stream = io.connect('http://187.157.37.204:8080');
	</script>
	
	

<style type="text/css">

html,body{

margin:0px;

height:100%;

}
#bodysec{ text-align:center;background:#FFF; height:auto;  }

</style>

</head>

<body >
	<header>
		<h1><span id="span1"><span id="spanTit">SIEDEMUN 1.0</span> | <span>SISTEMA INTEGRAL DE ELECCI&Oacute;N DE DELEGADOS MUNICIPALES</span> </span>
		    <span id="span2">
		    		<span id="spanUser"> </span> | <span id="closeSession">Cerrar Sesi&oacute;n</span> | <span id="span4"><?php echo $f->getDateLong(date('Y-m-d'),0); ?></span></span>
					   
		</h1>
	</header>
	<section id="bodysec">
		<aside id="accordion" class=" ui-menu ">
    			<h3><a href="#">Opciones</a></h3>
			<div>
				<a id="btn-cli.0" href="#" class="btnMnuHome ou0" title="Candidato Propietario">
					<img src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>images/img-web/person-1.png" width="32" height="32" alt="Candidato Propietario" />
				</a>
					
				<a id="btn-cli.1" href="#" class="btnMnuHome ou0" title="Candidato Suplente">
					<img src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>images/img-web/person-2.png" width="32" height="32" alt="Candidato Suplente" />
				</a>	

				<a id="btn-cli.40" href="#" class="btnMnuHome ou5" title="Registro de Candidatos">
					<img src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>images/img-web/32/catalog-1.png" width="32" height="32" alt="Registro de Candidatos" />
				</a>	
				
				<a id="btn-cli.200" href="#" class="btnMnuHome ou6" title="Listado de Registros">
					<img src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>images/img-web/esquemar.png" width="32" height="32" alt="Panel de Reportes" />
				</a>	
			</div>

		</aside>	
		<section id="panelRight" class="asignaciones1 asignac2">
		<!--Codigo de Asignaciones-->
		</section><!--asignaciones1-->
	</section><!--bodysec-->
	
	<footer>H. Ayuntamiento Constitucional de Centro | <?php echo date('Y'); ?>  </footer>

<embed src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>sounds/success1.wav" autostart="false" width="0" height="0" id="sound1"
enablejavascript="true">

</body>
</html>
