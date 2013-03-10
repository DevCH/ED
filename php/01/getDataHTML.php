<?php
header("html/text; charset=utf-8");  
header("Cache-Control: no-cache");

$index    = $_POST['o'];
$var2     = $_POST['t'];
$cad      = $_POST['c'];
$proc     = $_POST['p'];
$from     = $_POST['from'];
$cantidad = $_POST['cantidad'];
$otros    = $_POST['s'];

$ret = "---";
switch($index){
	case 201:
		switch($proc){
			case 0:
				require_once('core/messages.php');
				$va = (get_magic_quotes_gpc()) ? stripslashes($cad) : $cad;
				
				if (substr($cad,0,5)!="ERROR"){
					 $arr = explode("|",$cad);
					 messageBan(0,"",$arr);
				}else{
					 messageBan(1,$va);
				}
				break;

		}
		
}
//echo $ret ;
?>
