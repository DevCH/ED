<!DOCTYPE HTML>
<html lang="es">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>SIEDEMUN | Centro 2013 - 2015</title>
 	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/external/normalize.css" />
   	<link rel="stylesheet" type="text/css" href="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>css/config.css" />
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/api/jquery-1.7.2.min.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/01/persistent.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/01/base.js"></script>
   	<script  src="<? echo "http://".$_SERVER['SERVER_NAME']."/";?>js/init.js"></script>

</head>

<body>
	<header>
		<h1>Centro 2013 - 2015</h1>
		<h2>SISTEMA INTEGRAL DE ELECCI&Oacute;N DE DELEGADOS MUNICIPALES</h2>
	</header>
	<section id="bodysec" class="initLogin">
	<form class="form formLogin" id="formLogin">
	        	<fieldset>
				<label for="username" class="lblLogin">Usuario </label>
				<input type ="text" placeholder="Nombre de Usuario" autofocus title="Nombre de Usuario" required id="username" />
			</fieldset>	
	        	<fieldset>
				<label for="password" class="lblLogin">Password </label>
				<input type="password" placeholder="Password" title="Password" required id="password" />
			</fieldset>	
	        	<fieldset>
				<label for="submit" class="lblLogin"> </label>
               	<input id="submit" type="submit" value="Ingresar" />
			</fieldset>	
      </form>
	 <div id="preloader">
	 </div>
	</section>
	<footer>H. Ayuntamiento Constitucional de Centro | <?php echo date('Y'); ?>  </footer>

</body>
</html>
