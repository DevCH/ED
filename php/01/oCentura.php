<?php
require_once('vo/voConn.php');
require_once('vo/voCombo.php');
require_once('vo/voUserPer1.php');
require_once('vo/voPersonal1.php');
require_once('vo/voCliente1.php');
require_once('vo/voProducto1.php');
require_once('vo/vo_viContratos1.php');
require_once('vo/vo_viContratoDetalles1.php');
require_once('vo/voFacEnc.php');
require_once('vo/voFacDet.php');
require_once('vo/vo_viFacturaDetalle1.php');
require_once('vo/vo_viFacturaEncab1.php');
require_once('vo/vo_viMovimientos1.php');
require_once('vo/vo_viContratoDetalles_Esq_Val.php');
require_once('vo/vo_viDemanda.php');
require_once('vo/vo_viUsers1.php');
require_once('vo/vo_ed_Candidatos.php');
require_once('vo/vo_ed_Registros.php');



class oCentura {
	 
	 private static $instancia;
	 public $IdUser;
	 public $User;
	 public $Pass;
	 public $Nav;
	 public $URL;
	 public $defaultMail;
	 public $CID;
	 public $Mail;
	 public $Foto;
	 public $iva;
	 
	 private function __construct(){ 
	 		$this->Nav      = "Ninguno";
			$this->IdUser    = 0;
			$this->User     = "";
			$this->Pass     = "";
			$this->iva      = 0.16;
	 }

	 public static function getInstance(){
				if (  !self::$instancia instanceof self){
					  self::$instancia = new self;
				}
				return self::$instancia;
	 }

	 
	 private function getIdUser($str){
		    $ar = explode("|",$str);
		    //$Conn = voConn::getInstance();
		    //$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		    //mysql_select_db($Conn->db);
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select iduser from usuarios where username = '$ar[1]' and password = '$ar[0]'");

			if (!$result) {
    				$ret=0;
			}else{
				//$fila = mysql_result($result, 0);
    				$ret=intval(mysql_result($result, 0,"iduser"));
			}
			//mysql_close($mysql);
		    return $ret;
	 }

	 private function getIdDepUser($iduser){
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select idprodgpo from usuarios where iduser = $iduser limit 1");

			if (!$result) {
    				$ret=0;
			}else{
				//$fila = mysql_result($result, 0);
    				$ret=intval(mysql_result($result, 0));
			}
			//mysql_close($mysql);
		    return $ret;
	 }

	 public function getFolioTim($serie){
		    //$Conn = voConn::getInstance();
		    //$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		    //mysql_select_db($Conn->db);
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select max(folio) as folio from facturas_encab where serie = '$serie' and isfe = 1 limit 1 ");

			if (!$result) {
    				$ret=1;
			}else{
    				$ret=intval(mysql_result($result, 0))+1;
			}
			//mysql_close($mysql);
		    return $ret;
	 }

	 public function getFormula($idcomun){
		    //$Conn = voConn::getInstance();
		    //$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		    //mysql_select_db($Conn->db);
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select max(nformula) as nformula from ed_registros where idcomun = $idcomun limit 1 ");

			if (!$result) {
    				$ret=1;
			}else{
    				$ret=intval(mysql_result($result, 0))+1;
			}
			//mysql_close($mysql);
		    return $ret;
	 }
	 
	 private function getIDFromTable($table){
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select last_insert_id() from ".$table." limit 1 ");

			if (!$result) {
    				$ret=1;
			}else{
    				$ret=intval(mysql_result($result, 0));
			}
			//mysql_close($mysql);
		    return $ret;
		 
	 }

	 private function getIDFromDenuncias(){
		    mysql_query("SET NAMES UTF8");
		  
		    $result = mysql_query("select last_insert_id() from denuncias limit 1 ");

			if (!$result) {
    				$ret=1;
			}else{
    				$ret=intval(mysql_result($result, 0));
			}
			
		    $rs = mysql_query("select cfolio from _viDemanda where iddenuncia = ".$ret." limit 1 ");
			if (!$rs) {
    				$ret2=1;
			}else{
    				//$ret2=mysql_result($rs, 0);
				$ret2 = mysql_result($rs, 0,"cfolio");
			}
		    return $ret2;
		 
	 }
	 
	 
	private function sayLiked($tipo,$val=""){
			switch(intval($tipo)){
					case 1:
					    return $val."%";
						break;
					case 2:
					    return "%".$val;
						break;
					default:
					    return "%".$val."%";
						break;
			}
	}	
	
	private function update_total_venta_contrato($id=0,$result=1,$opt=0){
		$ar = array("total_venta","total_cortesia","total_convenio","total_interno");
		if ($result==1){ 
			$query = "UPDATE contratos 
					SET $ar[$opt] = (SELECT SUM(importe) FROM contratos_detalles WHERE idcontrato = $id and tipo_publicacion = $opt) 
					WHERE idcontrato = $id";
			$result = mysql_query($query);
		}
	}

     public function getCombo($index=0,$arg="",$pag=0,$limite=0,$tipo=0){
		  $arr = array('voCombo');
		  $indice = 0;
		  $ret = array();
		  $query="";
		 
            	switch ($index){
					case -3:// Obtiene un listado de grupos a los que pertenece una persona
						$query = "select pg.grupo as label, pg.idpergpo as data 
								from personal_grupo pg 
									left join personal_asocia_grupo pag 
										on pg.idpergpo = pag.idpergpo 
								where pag.idper = $tipo";
						break;
					case -2:// Obtiene un listado de areas a las que pertenece una persona
						$query = "select pa.area as label, pa.idperarea as data 
								from personal_area pa 
									left join personal_asocia_area paa 
										on pa.idperarea = paa.idperarea 
								where paa.idper = $tipo";
						break;
					case -1:// valida loguin de usuarios
			          	$ar = explode(".",$arg);
						$pass = md5($ar[1]);
						$query = "SELECT username as label,password as data 
								FROM usuarios 
								Where username = '$ar[0]' and password = '$pass' ";
						break;
					case 0:
					case 1:
						switch($tipo){
							case 0:
								$query = "SELECT razon_social as label,idcli as data 
										FROM clientes 
										Order By label asc ";
								break;		
							case 1:
								$query = "SELECT grupocli as label,idcligpo as data 
										FROM clientes_grupo 
										Order By data desc ";
								break;
							case 2:
			          			$ar = explode(".",$arg);
								$query = "Select c.razon_social as label, cag.idcliasocgpo as data
										from clientes_asocia_grupo cag 
										Left Join clientes c 
											On cag.idcli = c.idcli
										Left Join clientes_grupo cg
											On cag.idcligpo = cg.idcligpo
										Where cag.idcligpo = $ar[1] order by label";	
								break;		
							case 3:
								$query = "SELECT categoria as label,idcategoria as data 
										FROM clientes_categorias 
										Order By data asc ";
								break;
						}
						break;
					case 2:
						switch($tipo){
							case 0:
								$query = "SELECT razon_social as label,idcli as data 
										FROM clientes 
										Order By data desc ";
								break;		
							case 1:
								$query = "SELECT razon_social as label,idcli as data 
										FROM clientes 
										Order By data desc ";
								break;
							case 2:
			          			$ar = explode(".",$arg);
								$query = "Select c.razon_social as label, cac.idcliparent as data
										from clientes_asocia_clientes cac 
										Left Join clientes c 
											On cac.idclichild = c.idcli
										Left Join clientes cg
											On cac.idcliparent = cg.idcli
										Where cac.idcliparent = $ar[1]";	
								break;		
						}
						break;
					case 11:
						switch($tipo){
							case 0:
								$query = "SELECT razon_social as label,idcli as data 
										FROM clientes 
										Order By label asc ";
								break;		
							case 1:
								$query = "SELECT descripcion as label,idcontpaq as data 
										FROM contpaq 
										Order By data asc ";
								break;
							case 2:
			          			$ar = explode(".",$arg);
								$query = "Select c.razon_social as label, cac.idcliasoccontpaq as data
										from clientes_asocia_contpaq cac 
										Left Join clientes c 
											On cac.idcli = c.idcli
										Left Join contpaq cg
											On cac.idcontpaq = cg.idcontpaq
										Where cac.idcontpaq = $ar[1]";	
								break;		
						}
						break;
					case 3:
						switch($tipo){
							case 200:
								$query = "SELECT medida as label,idmedida as data 
										FROM medidas 
										Order By data asc ";
								break;		
							case 300:
								$query = "SELECT prodgpo as label,idprodgpo as data 
										FROM productos_grupo 
										Order By data asc ";
								break;		
						}
						break;
					case 6:
					case 7:
						switch($tipo){
							case 0:
								$query = "SELECT username as label,iduser as data 
										FROM usuarios 
										Order By data desc ";
								break;		
							case 1:
								$query = "SELECT leyenda as label,idop as data 
										FROM usuarios_opciones 
										Order By data asc ";
								break;
							case 2:
			          			$ar = explode(".",$arg);
								$query = "Select u.username as label, uao.iduserop as data
										from usuarios_asocia_opciones uao 
										Left Join usuarios u 
											On uao.iduser = u.iduser
										Left Join usuarios_opciones uo
											On uao.idop = uo.idop
										Where uao.idop = $ar[1]";	
								break;		
							case 200:
								$query = "SELECT concat(app,' ',apm,' ',nombre) as label,idper as data 
										FROM personal 
										Order By data asc ";
								break;
							case 201:
								$query = "SELECT prodgpo as label, idprodgpo as data 
										FROM productos_grupo Order By data asc ";
								break;		
										
						}
						break;
					case 8:
					case 9:
						switch($tipo){
							case 0:
								$query = "SELECT concat(app,' ',apm,' ',nombre) as label,idper as data 
										FROM personal 
										Order By data desc ";
								break;		
							case 1:
								$query = "SELECT area as label,idperarea as data 
										FROM personal_area 
										Order By data desc ";
								break;
							case 2:
			          			$ar = explode(".",$arg);
								$query = "Select concat(p.app,' ',p.apm,' ',p.nombre) as label, paa.idperasocarea as data
										from personal_asocia_area paa 
										Left Join personal p 
											On paa.idper = p.idper
										Left Join personal_area pa
											On paa.idperarea = pa.idperarea
										Where paa.idperarea = $ar[1]";	
								break;		
						}
						break;
					case 10:
						switch($tipo){
							case 0:
								$query = "SELECT concat(app,' ',apm,' ',nombre) as label,idper as data 
										FROM personal 
										Order By data desc ";
								break;		
							case 1:
								$query = "SELECT grupo as label,idpergpo as data 
										FROM personal_grupo 
										Order By data desc ";
								break;
							case 2:
			          			$ar = explode(".",$arg);
								$query = "Select concat(p.app,' ',p.apm,' ',p.nombre) as label, pag.idperasocgpo as data
										from personal_asocia_grupo pag 
										Left Join personal p 
											On pag.idper = p.idper
										Left Join personal_grupo pg
											On pag.idpergpo = pg.idpergpo
										Where pag.idpergpo = $ar[1]";	
								break;		
							case 3:
			          			$ar = explode(".",$arg);
								$query = "Select pa.area as label, pa.idperarea as data
										From personal_asocia_area paa
										Left Join personal_area pa
											On pag.idperarea = pg.idperarea
										Where pag.idper = $ar[1] ";
												
								break;		
							case 4:
			          			$ar = explode(".",$arg);
								$query = "Select pg.grupo as label, pg.idpergpo as data
										From personal_asocia_grupo pag
										Left Join personal_grupo pg
											On pag.idpergpo = pg.idpergpo
										Where pag.idper = $ar[1] ";
												
								break;		
						}
						break;
					case 40:
						switch($tipo){
							case -1:
								$query = "SELECT area as label, idareagpo as data 
										FROM productos_grupos_areas where ".$arg." Order By data asc ";
								break;		
							case 0:
								$query = "SELECT prodgpo as label, idprodgpo as data 
										FROM productos_grupo Order By data asc ";
								break;		
							case 1:
								$query = "SELECT concat(producto,' (',medida,') ') as label, idprod as data 
										FROM _viProductos where ".$arg." Order By data asc ";
								break;		
							case 2:
								$query = "SELECT origen as label, idorigen as data 
										FROM origenes Order By data asc ";
								break;		
							case 3:
								$query = "SELECT status as label, idstatus as data 
										FROM status Order By data asc ";
								break;		
							case 4:
								$query = "SELECT prioridad as label, idprioridad as data 
										FROM prioridades Order By data desc ";
								break;		
						}
						break;
					case 200:
						switch($tipo){
							case 0:
								$query = "SELECT prodgpo as label, idprodgpo as data 
										FROM productos_grupo Order By data asc ";
								break;		
							case 1:
								$ar = explode(".",$arg);
								$query = "SELECT d.prodgpo AS label, count(n.iddependencia) AS data  
										FROM denuncias n LEFT JOIN productos_grupo d ON n.iddependencia = d.idprodgpo 
										WHERE (n.fecha_ingreso BETWEEN '$ar[0]' AND '$ar[1]') GROUP BY n.iddependencia  LIMIT 0 , 30";	
											
								break;		
						}
						break;
		  	}
		  
		  	$Conn = voConn::getInstance();
		   
		  	$mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  
		  	mysql_select_db($Conn->db);
		  	mysql_query("SET NAMES UTF8");
		  
		  	$result = mysql_query($query);
		  
		  	while ($obj = mysql_fetch_object($result, $arr[0])) {
			   	 $ret[] = $obj;
		  	}
		  
	       	mysql_close($mysql);
			
			return $ret;
			
	}

     public function setAsocia($tipo=0,$arg="",$pag=0,$limite=0,$var2=0){
		  $query="";

		  $ip=$_SERVER['REMOTE_ADDR']; 
		  $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
	
		  $vRet = "Error";
		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
		  mysql_query("SET NAMES 'utf8'");	
            	switch ($tipo){
					case 0:
						switch($var2){
							case 10:
							     parse_str($arg);
								$query = "Insert Into _dom_".$iddomfis." ($iddomfis)value(upper('".strtoupper($datofis)."'))";
								$result = mysql_query($query);
								$vRet = $result!=1?"error: ".mysql_error().count($namecolumn):"OK";
								break;
							case 11:
							     parse_str($arg);
								$query = "Insert Into $iddomfis ($namecolumn)value(upper('$datofis'))";
								$result = mysql_query($query);
								$vRet = $result!=1?"error: ".mysql_error():"OK";
								break;
						}
						break;		
					case 1:
						switch($var2){
							case 10:
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into clientes_asocia_grupo(idcli,idcligpo)value($item[$i],$ar[1])";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:
			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									$query = "Delete from clientes_asocia_grupo where idcliasocgpo = $ar[$i]";
									$result = mysql_query($query);
									$vRet = $result!=1?"Error.":"OK";
								}
								break;		
						}
						break;
					case 2:
						switch($var2){
							case 10:
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into clientes_asocia_clientes(idclichild,idcliparent)value($item[$i],$ar[1])";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:
			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									$query = "Delete from clientes_asocia_clientes where idcliasoccli = $ar[$i]";
									$result = mysql_query($query);
									$vRet = $result!=1?"Error.":"OK";
								}
								break;		
						}
						break;
					case 11:
						switch($var2){
							case 10:
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into clientes_asocia_contpaq(idcli,idcontpaq)value($item[$i],$ar[1])";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:
			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									$query = "Delete from clientes_asocia_contpaq where idcliasoccontpaq = $ar[$i]";
									$result = mysql_query($query);
									$vRet = $result!=1?"Error.":"OK";
								}
								break;		
						}
						break;
					case 7:
						switch($var2){
							case 10:
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into usuarios_asocia_opciones(iduser,idop)value($item[$i],$ar[1])";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:
			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									$query = "Delete from usuarios_asocia_opciones where iduserop = $ar[$i]";
									$result = mysql_query($query);
									$vRet = $result!=1?"Error.":"OK";
								}
								break;		
						}
						break;
					case 9:
						switch($var2){
							case 10:
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into personal_asocia_area(idper,idperarea)value($item[$i],$ar[1])";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:
			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									$query = "Delete from personal_asocia_area where idperasocarea = $ar[$i]";
									$result = mysql_query($query);
									$vRet = $result!=1?"Error.":"OK";
								}
								break;		
						}
						break;
					case 10:
						switch($var2){
							case 10:
			          			$ar = explode(".",$arg);
			          			$item = explode("|",$arg);
								foreach($item as $i=>$valor){
									if ((int)($item[$i])>0){
										$query = "Insert Into personal_asocia_grupo(idper,idpergpo)value($item[$i],$ar[1])";
										$result = mysql_query($query);
										$vRet = $result!=1?"Error.":"OK";
									}
								}
								break;		
							case 20:
			          			$ar = explode("|",$arg);
								foreach($ar as $i=>$valor){
									$query = "Delete from personal_asocia_grupo where idperasocgpo = $ar[$i]";
									$result = mysql_query($query);
									$vRet = $result!=1?"Error.":"OK";
								}
								break;		
						}
						break;
		  	}
		  
			mysql_close($mysql);

		  return  $vRet;
	}


     public function setSaveData($index=0,$arg="",$pag=0,$limite=0,$tipo=0){
		  $query="";

		  $ip=$_SERVER['REMOTE_ADDR']; 
		  $host=gethostbyaddr($_SERVER['REMOTE_ADDR']);//$_SERVER["REMOTE_HOST"]; 
	
		  $vRet = "Error";
		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
		  /*
		  if (!$Q->IsIE()){
		     for( $i = 0; $i < count($ar); $i ++) $ar[$i] = utf8_decode($ar[$i]);
		  }
			*/
			
		  mysql_query("SET NAMES 'utf8'");	
		  $ar = array();
		 
            	switch ($index){
					case 0:
					case 1:
                           switch($tipo){
	case 0:
		parse_str($arg);
		$idusr = $this->getIdUser($iduser);
		$query = "Insert Into ed_candidatos(idcalle,num_externo,num_interno,idcolonia,idlocalidad,idcodpos,
					tel1,cel1,email,app,apm,nombre,creado_por,creado_el,sexo,rol)
					value( $idcalle,'$num_externo','$num_interno',$idcolonia,$idlocalidad,
						  '$idcodpos','$tel1','$cel1','$email','".strtoupper($app_rs)."','".strtoupper($apm_rs)."',
						  '".strtoupper($nombre_rs)."',$idusr,NOW(),$sexo,$rol)";
		$result = mysql_query($query); 
		$vRet = $result!=1? mysql_error():"OK";
		break;		
	case 1:
	     //$ar = $this->unserialice_force($arg);
		parse_str($arg);
		$idusr = $this->getIdUser($iduser);
		$query = "update ed_candidatos set idcalle = $idcalle, num_externo = '$num_externo', num_interno = '$num_interno', 
								idcolonia = $idcolonia, idlocalidad = $idlocalidad, idcodpos  = '$idcodpos', 
								tel1 = '$tel1', cel1 = '$cel1', email = '$email', app = '".strtoupper($app_rs)."',
								apm = '".strtoupper($apm_rs)."', nombre = '".strtoupper($nombre_rs)."', 
								modi_por=$idusr,modi_el=NOW(), sexo = $sexo
				Where idcandidato = $idcandidato";
		$result = mysql_query($query);
		$vRet = $result!=1? mysql_error():"OK";
		break;		
	case 2:
	     //$ar = $this->unserialice_force($arg);
		parse_str($arg);
		$query = "delete from ed_candidatos Where idcandidato = $idcandidato";
		$result = mysql_query($query);
		$vRet = $result!=1? mysql_error():"OK";
		break;		
}
break;
					case 3:
						switch($tipo){
							case 0:
								parse_str($arg);
								$query = "Insert Into productos(producto,idmedida,idprodgpo)
											value('".strtoupper($producto)."',$idmedida,$iddep)";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$query = "update productos set producto = '".strtoupper($producto)."',idmedida=$idmedida,idprodgpo=$iddep
										Where idprod = $idprod";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$query = "delete from productos Where idprod = $idprod";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;
					case 6:
					case 7:
						switch($tipo){
							case 0:
								parse_str($arg);
								$x = intval($idper);
								if ( $x <= 0 ){
									$vRet = "ERROR: No seleccion&oacute; un Id Per";
								}else{
									
									$query = "Insert Into usuarios(username,password,idper,idprodgpo)
											value('$username','".md5(trim($password))."',$idper,$idprodgpo)";
									$result = mysql_query($query); 
									$vRet = $result!=1? mysql_error():"OK";
								}
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								if (intval($idper)>0){
									$query = "update usuarios set username = '$username',
														    idper = $idper,
														    idprodgpo = $idprodgpo 
													Where iduser = $iduser";
									$result = mysql_query($query);
									$vRet = $result!=1? mysql_error():"OK";
								}else{
									$vRet = "ERROR: No seleccion&oacute; un Id Per";
								}
								//$vRet = $a[0];
								break;		
							case 2:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$query = "delete from usuarios Where iduser = $iduser";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 3:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								if ($password1 != $password2){
								    $vRet = "ERROR: No coinciden los valores";
								}else{
									if (trim($password1)=="" || trim($password2)==""){
								    		$vRet = "ERROR: No se aceptan valores nulos";
									}else{
										$query = "update usuarios set password = '".md5(trim($password1))."' Where iduser = $iduser2";
										$result = mysql_query($query);
										$vRet = $result!=1? mysql_error():"OK";
									}
								}
								break;		
						}
						break;
					case 8:
					case 9:
					case 10:
						switch($tipo){
							case 0:
							     
								parse_str($arg);
								$query = "Insert Into personal(app, apm, nombre,tel, cel, mail, f_alta, sexo)
										value('".strtoupper($app)."', '".strtoupper($apm)."', '".strtoupper($nombre)."','$tel', '$cel', '$mail', '$f_alta', '$sexo')";
								$result = mysql_query($query); 
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$query = "update personal set nombre = '".strtoupper($nombre)."', app = '".strtoupper($app)."', apm = '".strtoupper($apm)."', tel = '$cel', 
														cel = '$cel', mail = '$mail', f_alta = '$f_alta', sexo = '$sexo' 
												    Where idper = $idper";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
							case 2:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$query = "delete from personal Where idper = $idper";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								break;		
						}
						break;
					case 40:
						switch($tipo){
							case 0:
							     
								parse_str($arg);
								$idusr = $this->getIdUser($iduser);
								$nformula = $this->getFormula($idcomun);
  									//$foo = "idproducto_0";
								$query = "Insert Into ed_registros(idcandidato,idsuplente,idcomun,nformula,fecha,observaciones,creado_por,creado_el,
								op1,op1_desc,op2,op2_desc,op3,op3_desc,op4,op4_desc,op5,op5_desc,
								op6,op6_desc,op7,op7_desc,op8,op8_desc,op9,op9_desc,op10,op10_desc,
								op11,op11_desc,op12,op12_desc,op13,op13_desc,op14,op14_desc,op15,op15_desc,
								op16,op16_desc,op17,op17_desc,op18,op18_desc,op19,op19_desc,op20,op20_desc
								)value(
								$idpropietario,$idsuplente,$idcomun,$nformula,NOW(),'$observaciones',$idusr,NOW(),
								$op1,'$op1_desc',$op2,'$op2_desc',$op3,'$op3_desc',$op4,'$op4_desc',$op5,'$op5_desc',
								$op6,'$op6_desc',$op7,'$op7_desc',$op8,'$op8_desc',$op9,'$op9_desc',$op10,'$op10_desc',
								$op11,'$op11_desc',$op12,'$op12_desc',$op13,'$op13_desc',$op14,'$op14_desc',$op15,'$op15_desc',
								$op16,'$op16_desc',$op17,'$op17_desc',$op18,'$op18_desc',$op19,'$op19_desc',$op20,'$op20_desc'
								)";
								$result = mysql_query($query); 
								
								if ($result!=1){
									$vRet = "ERROR: ".mysql_error();
								}else{
									$vRet = "OK";
								}
								break;		
							case 1:
							     //$ar = $this->unserialice_force($arg);
								parse_str($arg);
								$idusr = $this->getIdUser($iduser);
								
								$query = "update denuncias set fecha_ingreso = '$fecha', idcli = $idcli,
															 idprod = $producto, cantidad = $cantidad,
															 descripcion = '$descripcion', oficio_envio = '$noficio',
															 iddependencia = $iddep, idareadep = $idareadep,
															 idorigen = $origen,idprioridad = $prioridad, 
															 modi_por = $idusr, modi_el = NOW()
														where iddenuncia = $iddenuncia";
								$result = mysql_query($query);
								$vRet = $result!=1? "CMHR ".mysql_error():"OK";
								break;		
							case 2:
							     //$ar = $this->unserialice_force($arg);
								
								
								parse_str($arg);
								$query = "delete from ed_registros Where idreg = $idreg";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
								
								$vRet = "OK";
									break;		
							case 3:
							     //$ar = $this->unserialice_force($arg);
								//parse_str($arg);
								$query = "delete from factura_detalle Where idfacdet = $arg";
								$result = mysql_query($query);
								$vRet = $result!=1? mysql_error():"OK";
									break;		
							case 4:
							     //$ar = $this->unserialice_force($arg);
								//parse_str($arg);
								$x = explode("|",$arg);
								$idusr = $this->getIdUser($x[0]);
								
								$query = "update ed_registros set foto = '$x[2]', modi_por = $idusr
														where idreg = $x[1]";
								$result = mysql_query($query);
								$vRet = $result!=1? "CMHR ".mysql_error():"OK";
								break;		
						}
						break;

		  	}
		  
			mysql_close($mysql);

		  return  $vRet;
	}



	public function getQuerys($tipo=0,$cad="",$type=0,$from=0,$cant=0,$ar=array(),$otros="",$withPag=1) {
		  $arr = array('voUserPer1','voPersonal1','voCliente1','voProducto1','vo_viContratos1','vo_viContratoDetalles1',
		  			'vo_viDemanda','vo_viFacturaDetalle1','vo_viMovimientos1','vo_viContratoDetalles_Esq_Val','voCombo',
					'vo_ed_Candidatos','vo_ed_Registros');
		  $index = 0;
		  $ret = array();

		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
			
		  mysql_query("SET NAMES 'utf8'");	
		  
            	switch ($tipo){
				case 0:
				      $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT u.username,u.password,concat(p.app,' ',p.apm,' ',p.nombre) as nombre_completo,u.iduser,u.idper,u.idprodgpo
							FROM usuarios u left join personal p
							 	on u.idper = p.idper ".$cad.$str;
					$index = 0;		
					break;
				case 1:
				      $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT idper, concat(app,' ',apm,' ',nombre) as nombre_completo, app, apm, nombre, 		
								  tel, cel, mail, f_alta, sexo
							FROM personal ".$cad.$str;
					$index = 1;		
					break;
				case 2:
				     $cad0 = explode("|",$cad);
					parse_str($cad0[1]);
					$critStr = $this->sayLiked($crit,$nombrec); 
			          $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT idper, concat(app,' ',apm,' ',nombre) as nombre_completo, app, apm, nombre, 		
								  tel, cel, mail, f_alta, sexo
							FROM personal where $opciones like('$critStr') ".$cad0[0].$str;
					$index = 1;		
					break;
				case 3:
				
				      $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT * FROM _vi_ed_Candidatos ".$cad.$str;
					$index = 11;		
					break;
				case 4:
				     $cad0 = explode("|",$cad);
					parse_str($cad0[1]);
					$critStr = $this->sayLiked($crit,$datoc); 
			          $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT * FROM _viClientes where $opciones like('$critStr') ".$cad0[0].$str;
					$index = 2;		
					break;
				case 5:
				
				      $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT * FROM _viProductos ".$cad.$str;
					$index = 3;		
					break;
				case 6:
				     $cad0 = explode("|",$cad);
					parse_str($cad0[1]);
					$critStr = $this->sayLiked($crit,$datoc); 
			          $str = $from > 0 ? " limit $from, $cant " : "";
					$query = "SELECT * FROM _viProductos where $opciones like('$critStr') ".$cad0[0].$str;
					$index = 3;		
					break;
				case 12:
				/*
					if (count($otros)>0){
					     parse_str($otros);
						if (intval($iddep)==20 || intval($iddep)==0){
							$query = "SELECT * FROM _vi_ed_Candidatos Where iddepuser > 0 $cad limit $from, $cant ";
						}else{
							$query = "SELECT * FROM _vi_ed_Candidatos Where iddependencia = $iddep $cad limit $from, $cant ";
						}
					}else{
						*/
						$query = "SELECT * FROM _vi_ed_Registros $cad limit $from, $cant ";
					//}
					
					$index = 12;		
					break;
				case 13:
				          $cPag = $withPag==1?" limit $from, $cant ":"";
					     parse_str($otros);
						if (intval($iddep)==20 || intval($iddep)==0){
							switch(intval($optFindDem)){
								case 0:
									$query = "SELECT * FROM _viDemanda Where iddenuncia = $findDem order by iddenuncia desc ".$cPag;
									break;
								case 1:
									$query = "SELECT * FROM _viDemanda Where idcli = $findDem order by iddenuncia desc ".$cPag;
									break;
								case 2:
									$query = "SELECT * FROM _viDemanda Where nombrec Like('%$findDem%') order by iddenuncia desc ".$cPag;
									break;
								case 3:
									$query = "SELECT * FROM _viDemanda Where descripcion Like('%$findDem%') order by iddenuncia desc ".$cPag;
									break;
							}
							
						}else{
							switch(intval($optFindDem)){
								case 0:
									$query = "SELECT * FROM _viDemanda Where iddenuncia = $findDem and iddependencia = $iddep3 order by iddenuncia desc ".$cPag;
									break;
								case 1:
									$query = "SELECT * FROM _viDemanda Where idcli = $findDem and iddependencia = $iddep3  order by iddenuncia desc ".$cPag;
									break;
								case 2:
									$query = "SELECT * FROM _viDemanda Where (nombrec Like('%$findDem%')) and iddependencia = $iddep3  order by iddenuncia desc ".$cPag;
									break;
								case 3:
									$query = "SELECT * FROM _viDemanda Where (descripcion Like('%$findDem%')) and iddependencia = $iddep3  order by iddenuncia desc ".$cPag;
									break;
							}
						}
					
					$index = 6;		
					break;
				case 18:
					parse_str($cad);
			          
					$query = "SELECT * FROM _viClientes where nombrec like('%".$findnombrec."%') ";
					$index = 2;		
					break;
				case 19:
					parse_str($cad);
			          
					$query = "SELECT * FROM _vi_ed_Candidatos where idcandidato = $idpropietario ";
					$index = 11;		
					break;
				case 20:
				     
					$query = "SELECT * FROM _viProductos $cad limit $from, $cant";
					$index = 3;		
					break;
				case 21:
				     
					$query = "SELECT * FROM _vi_ed_Candidatos $cad limit $from, $cant";
					$index = 11;		
					break;
				case 22:
				     $cad0 = explode("|",$cad);
					parse_str($cad0[1]);
					$critStr = $this->sayLiked($crit,$datoc); 
					$query = "SELECT * FROM _vi_ed_Candidatos where $opciones like('$critStr') ".$cad0[0];
					$index = 11;		
					break;
				case 197:
					parse_str($cad);
					$query = "SELECT * FROM _vi_ed_Registros where (idcandidato = $idpropietario2 and idsuplente = $idsuplente2) limit 1 ";
					$index = 12;		
					break;
				case 198:
					parse_str($cad);
					$query = "SELECT * FROM _vi_ed_Candidatos where idcandidato = $idpropietario2 and rol = 1  limit 1 ";
					$index = 11;		
					break;
				case 199:
					parse_str($cad);
					$query = "SELECT * FROM _vi_ed_Candidatos where idcandidato = $idsuplente2 and rol = 2 limit 1 ";
					$index = 11;		
					break;
				case 1000:	
					$query = "select * from _viUsers where iduser = $idusers limit 1 ";
					$index = 12;		
					break;
				case 1001:	
					$query = "select * from _vi_ed_Registros where idreg = $type limit 1 ";
					$index = 12;		
					break;
				case 1002:
				     $cPag = $withPag==1?" limit $from, $cant ":"";
					parse_str($otros);
					//$query = "SELECT * FROM _vi_ed_Registros $cad limit $from, $cant";
					$query = "SELECT * FROM _vi_ed_Registros Where idcomun = $findDem ".$cad.$cPag;
					$index = 12;		
					break;
		  }
		  $result = mysql_query($query);

		  while ($obj = mysql_fetch_object($result, $arr[$index])) {
				   $ret[] = $obj;
		  }
		  mysql_free_result($result);
	       mysql_close($mysql);
		  
		  return $ret;
	
	}
	
	public function getDepFromUser($iduser=""){
		  $ret = array();

		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
			
		  mysql_query("SET NAMES 'utf8'");	
		
		  $idusr  = $this->getIdUser($iduser);
		  $iddepuser = $this->getIdDepUser($idusr);

		  $ret = array($idusr,$iddepuser);

		  mysql_free_result($result);
	       mysql_close($mysql);
		  
		  return $ret;
	}

	public function getPermissions($iduser=""){
		  $arr = array('vo_viUsers1');
		  $ret = array();

		  $Conn = voConn::getInstance();
		  $mysql = mysql_connect($Conn->server, $Conn->user, $Conn->pass);
		  mysql_select_db($Conn->db);
		  
		  $idusers = $this->getIdUser($iduser);	
		  
		  $query = "select * from _viUsers where iduser = $idusers limit 1 ";
		  
		  $result = mysql_query($query);

		  while ($obj = mysql_fetch_object($result, $arr[0])) {
				   $ret[] = $obj;
		  }
		  mysql_free_result($result);
	       mysql_close($mysql);
		  
		  return $ret;
	}
	

 }  


?>