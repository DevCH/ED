<?php 

function cat_dep_prod_1($objPHPExcel,$result,$F,$iddep){

	$i=8;$k=0;	
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, $fila->idprod);
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->producto);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$iddep==0?"CATALOGO DE SERVICIOS POR DEPENDENCIA ":"CATALOGO DE SERVICIOS DE '".utf8_decode($fila->grupo)."'";
	}
	$j = $i+3;
	$objPHPExcel->getActiveSheet()->setCellValue("C3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B5", $F->getWith3LetterMonthH(date('Y-m-d H:i:s')));
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
}

function get_rep_1($objPHPExcel,$result,$fi, $ff,$F){
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));

	$i=8;	
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, $fila->idprodgpo);
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->sumid);
		++$i;
	}
}

function get_rep_esp($objPHPExcel,$result,$fi, $ff,$F,$iddep,$msg){
	$objPHPExcel->getActiveSheet()->setCellValue("I1", $F->getWith3LetterMonthH(date('Y-m-d H:i:s')));
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));
	$i=9;$k=0;	
	$title="";
	//$row = mysql_fetch_row($result);
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, date('d-m-Y',strtotime($fila->fecha)));
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->origen);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->cfolio);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $fila->nombrec." (".$fila->idcli.")");
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $fila->domc);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $fila->descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $fila->observaciones);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $fila->status);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, date('d-m-Y',strtotime($fila->fecha_dep)));
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, intval(substr($fila->fexecdep,0,2))>0?date('d-m-Y',strtotime($fila->fexecdep)):'');
		$objPHPExcel->getActiveSheet()->setCellValue("L".$i, $fila->areadep);
		$objPHPExcel->getActiveSheet()->setCellValue("M".$i, $fila->respuesta_dep);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$iddep==0?"SERVICIOS SOLICITADOS ":"SERVICIOS SOLICITADOS A '".utf8_decode($fila->grupo)."'";
	}
	$j = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue("E3", $title." POR ".$msg);
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
	
}




function get_rep_2($objPHPExcel,$result,$fi, $ff,$F,$iddep){
	$objPHPExcel->getActiveSheet()->setCellValue("I1", $F->getWith3LetterMonthH(date('Y-m-d')));
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));
	$i=9;$k=0;	
	$title="";
	//$row = mysql_fetch_row($result);
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, date('d-m-Y',strtotime($fila->fecha)));
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->origen);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->cfolio);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $fila->nombrec." (".$fila->idcli.")");
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $fila->domc);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $fila->descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $fila->observaciones);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $fila->status);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, date('d-m-Y',strtotime($fila->fecha_dep)));
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, $fila->respuesta_dep);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$iddep==0?"SERVICIOS SOLICITADOS ":"SERVICIOS SOLICITADOS A '".utf8_decode($fila->grupo)."'";
	}
	$j = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue("E3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
	
}

function get_rep_3($objPHPExcel,$result,$fi, $ff,$F,$iddep){
	$objPHPExcel->getActiveSheet()->setCellValue("I1", $F->getWith3LetterMonthH(date('Y-m-d')));
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));
	$i=9;$k=0;	
	$title="";
	//$row = mysql_fetch_row($result);
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, date('d-m-Y',strtotime($fila->fecha)));
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->origen);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->cfolio);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $fila->nombrec." (".$fila->idcli.")");
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $fila->domc);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $fila->descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $fila->observaciones);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $fila->status);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, date('d-m-Y',strtotime($fila->fecha_dep)));
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, $fila->respuesta_dep);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$iddep==0?"SERVICIOS SOLICITADOS":"SERVICIOS SOLICITADOS A '".utf8_decode($fila->grupo)."' CON STATUS DE '".strtoupper($fila->status)."'";
	}
	$j = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue("E3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
	
}


function get_rep_4($objPHPExcel,$result,$fi, $ff,$F,$origen){
	$objPHPExcel->getActiveSheet()->setCellValue("I1", $F->getWith3LetterMonthH(date('Y-m-d')));
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));
	$i=9;$k=0;	
	$title="";
	//$row = mysql_fetch_row($result);
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, date('d-m-Y',strtotime($fila->fecha)));
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->origen);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->cfolio);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $fila->nombrec." (".$fila->idcli.")");
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $fila->domc);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $fila->descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $fila->observaciones);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $fila->status);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, date('d-m-Y',strtotime($fila->fecha_dep)));
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, $fila->respuesta_dep);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$origen==0?"SERVICIOS SOLICITADOS :: TODOS LOS 'MEDIOS DE CAPTACION'":"SOLICITUDES CAPTADAS EN '".strtoupper($fila->origen)."'";
	}
	$j = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue("E3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
	
}

function get_rep_5($objPHPExcel,$result,$fi, $ff,$F,$status){
	$objPHPExcel->getActiveSheet()->setCellValue("I1", $F->getWith3LetterMonthH(date('Y-m-d')));
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));
	$i=9;$k=0;	
	$title="";
	//$row = mysql_fetch_row($result);
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, date('d-m-Y',strtotime($fila->fecha)));
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->origen);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->cfolio);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $fila->nombrec." (".$fila->idcli.")");
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $fila->domc);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $fila->descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $fila->observaciones);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $fila->status);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, date('d-m-Y',strtotime($fila->fecha_dep)));
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, $fila->respuesta_dep);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$status==0?"SERVICIOS SOLICITADOS :: TODOS LOS STATUS":"SOLICITUDES CON STATUS '".strtoupper($fila->status)."'";
	}
	$j = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue("E3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
	
}

function get_rep_6($objPHPExcel,$result,$fi, $ff,$F,$prioridad){
	$objPHPExcel->getActiveSheet()->setCellValue("I1", $F->getWith3LetterMonthH(date('Y-m-d')));
	$objPHPExcel->getActiveSheet()->setCellValue("C5", "DESDE:  ".$F->getWith3LetterMonthH($fi)." HASTA:  ".$F->getWith3LetterMonthH($ff));
	$i=9;$k=0;	
	$title="";
	//$row = mysql_fetch_row($result);
	while ($fila = mysql_fetch_object($result)) {

		$objPHPExcel->getActiveSheet()->setCellValue("A".$i, date('d-m-Y',strtotime($fila->fecha)));
		$objPHPExcel->getActiveSheet()->setCellValue("B".$i, $fila->origen);
		$objPHPExcel->getActiveSheet()->setCellValue("C".$i, $fila->cfolio);
		$objPHPExcel->getActiveSheet()->setCellValue("D".$i, $fila->nombrec." (".$fila->idcli.")");
		$objPHPExcel->getActiveSheet()->setCellValue("E".$i, $fila->domc);
		$objPHPExcel->getActiveSheet()->setCellValue("F".$i, $fila->descripcion);
		$objPHPExcel->getActiveSheet()->setCellValue("G".$i, $fila->grupo);
		$objPHPExcel->getActiveSheet()->setCellValue("H".$i, $fila->observaciones);
		$objPHPExcel->getActiveSheet()->setCellValue("I".$i, $fila->status);
		$objPHPExcel->getActiveSheet()->setCellValue("J".$i, date('d-m-Y',strtotime($fila->fecha_dep)));
		$objPHPExcel->getActiveSheet()->setCellValue("K".$i, $fila->respuesta_dep);
		++$i;++$k;
		$objPHPExcel->getActiveSheet()->insertNewRowBefore($i, 1);
		$title=$prioridad==0?"SERVICIOS SOLICITADOS :: TODOS LAS 'PRIORIDADES'":"SOLICITUDES CON PRORIDAD '".strtoupper($fila->prioridad)."'";
	}
	$j = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue("E3", $title);
	$objPHPExcel->getActiveSheet()->setCellValue("B".$j, $k);
	
}

?>
