<?php
$idreg      = $_POST["idreg"];

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

require('../diag/sector.php');
require_once("../oFunctions.php");
require_once("../oCentura.php");
$F = oFunctions::getInstance();
$f = oCentura::getInstance();


class PDF_Diag extends PDF_Sector {
    var $legends;
    var $wLegend;
    var $sum;
    var $NbVal;
    var $ley;
    var $datos;
    var $cand;
    var $idreg;
    var $flag;
    var $pic;
    var $ccomunidad;
    var $nformula;
    var $obsi;


    function Header()
    {   
		$this->SetFillColor(64,64,64);
          $this->Image('../../../images/img-web/siedmun-constancia-logo-1.gif',5,5,51);
		if ($this->flag==0){
          	$this->Image('../docs/filex/'.$this->pic,180,19,25,30);
		}else{
          	$this->Image('../docs/filex/'.$this->pic,180,19,25,30);
		}
		$this->SetFont('Arial','B',18);
		$this->SetTextColor(0,0,0);

		$this->SetFont('Arial','',14);
		$this->Ln(10);
		if ($this->flag==0){
			$this->Cell(130, 5, "ASPIRANTE A DELEGADO PROPIETARIO ", 0,1, 'C');
		}else{
			//$this->Cell(198, 5, "ASPIRANTE A DELEGADO SUPLENTE ", 0,1, 'C');
			$this->Cell(130, 5, "ASPIRANTE A DELEGADO SUPLENTE ", 0,1, 'C');
		}
		$this->SetFont('Arial','B',16);
		$this->SetTextColor(64,64,64);
		if ($this->flag==0){
			$this->Cell(130, 12, "CONSTANCIA DE SOLICITUD DE REGISTRO", '',1, 'C');
		}else{
			//$this->Cell(198, 12, "CONSTANCIA DE SOLICITUD DE REGISTRO", '',1, 'C');
			$this->Cell(130, 12, "CONSTANCIA DE SOLICITUD DE REGISTRO", '',1, 'C');
		}

		$this->SetFont('Arial','B',14);
		$this->SetTextColor(250,250,250);
		if ($this->flag==0){
			$this->Cell(165, 12, " ".$this->cand, 1,1, 'L',true);
		}else{
			//$this->Cell(198, 12, " ".$this->cand, 1,1, 'C',true);
			$this->Cell(165, 12, " ".$this->cand, 1,1, 'L',true);
		}
			
		$this->Ln(2);

		$this->SetFont('Arial','',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(40, 8, utf8_decode("DELEGACIÓN: "), 0,0, 'L');
		
		$this->SetFont('Arial','B',12);
		$this->Write(8,utf8_decode($this->ccomunidad));
		$this->Cell(10, 8, " ", 0,1, 'L');

		$this->SetFont('Arial','',12);
		$this->SetTextColor(0,0,0);
		$this->Cell(40, 8, utf8_decode("FÓRMULA: "), 0,0, 'L');
		
		$this->SetFont('Arial','B',12);
		$this->Write(8,$this->nformula);
		$this->Cell(10, 8, " ", 0,1, 'L');

		$this->Ln(2);

		$this->SetFont('Arial','',9);
		$this->SetTextColor(0,0,0);
		$this->MultiCell(200, 6, utf8_decode("Con fundamento en la convocatoria públicada el ## de ______ del año 2013 y apegados estrictamente al requerimiento de la misma, en su Base 1 relativo a los requisitos para ser candidatos, bajo protesta de decir verdad y bajo las penas en que incurren los falsos declarantes, manifesto que cumplo con todos y cada uno de los mismos, tal y como lo demuestro con la documentación siguiente:"), 0);
		
		$this->Ln(2);
	
		$this->SetFont('Arial','B',12);
			
		$this->SetTextColor(255,255,255);
     	$this->Cell(14,6,'SI',1,0,'C',true);
     	$this->Cell(14,6,'NO',1,0,'C',true);
     	$this->Cell(170,6,"REQUISITOS",1,1,'C',true);
		$this->SetFont('Arial','',10);
		$this->SetTextColor(0,0,0);
		$this->Ln(0);
		
} 
    
}




$res = $f->getQuerys(1001,"",$idreg);

$pdf = new PDF_Diag('P','mm','Letter');
$pdf->cand = $res[0]->ccandidato;
$pdf->idreg = $idreg;
$pdf->ccomunidad = $res[0]->comunidad;
$pdf->nformula = $res[0]->nformula;
if (is_file('../docs/filex/'.$res[0]->foto)) {
   $pdf->pic = $res[0]->foto;
}else{
   $pdf->pic = 'siedmun-foto-intantil-2.gif';
}
$pdf->flag = 0;
$pdf->AddPage();
			
$pdf->SetTextColor(0,0,0);

		$csi = 0;
		$cno = 0;
		
		for($j=1;$j<=10;++$j){
			$pdf->SetFont('Arial','B',11);
			$obsi = "";
			$hi = 6.5;
			switch($j){
				case 1:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op1)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op1==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op1_desc;
					if (intval($res[0]->op1)==1) ++$csi; else ++$cno;
					break;
				case 2:
     				$pdf->Cell(14,$hi,intval($res[0]->op2)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op2==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op2_desc;
					if (intval($res[0]->op2)==1) ++$csi; else ++$cno;
					break;
				case 3:
     				$pdf->Cell(14,$hi,intval($res[0]->op3)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op3==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op3_desc;
					if (intval($res[0]->op3)==1) ++$csi; else ++$cno;
					break;
				case 4:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op4)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op4==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op4_desc;
					if (intval($res[0]->op4)==1) ++$csi; else ++$cno;
					break;
				case 5:
     				$pdf->Cell(14,$hi,intval($res[0]->op5)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op5==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op5_desc;
					if (intval($res[0]->op5)==1) ++$csi; else ++$cno;
					break;
				case 6:
     				$pdf->Cell(14,$hi,intval($res[0]->op6)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op6==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op6_desc;
					if (intval($res[0]->op6)==1) ++$csi; else ++$cno;
					break;
				case 7:
     				$pdf->Cell(14,$hi*3,intval($res[0]->op7)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*3,$res[0]->op7==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op7_desc;
					if (intval($res[0]->op7)==1) ++$csi; else ++$cno;
					break;
				case 8:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op8)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op8==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op8_desc;
					if (intval($res[0]->op8)==1) ++$csi; else ++$cno;
					break;
				case 9:
     				$pdf->Cell(14,$hi,intval($res[0]->op9)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op9==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op9_desc;
					if (intval($res[0]->op9)==1) ++$csi; else ++$cno;
					break;
				case 10:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op10)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op10==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op10_desc;
					if (intval($res[0]->op10)==1) ++$csi; else ++$cno;
					break;
			}
			$pdf->SetFont('Arial','',11);
     		//$pdf->Cell(100,16,$F->pregu[$j-1],'RBT','L');
			$pdf->MultiCell(170, $hi, $j.".- ".utf8_decode($F->pregu[$j-1]).". ".$obsi, 1);
			//$pdf->Ln(1);
		}

		$pdf->SetTextColor(255,255,255);
     	
		$pdf->Cell(14,$hi,' ',1,0,'C',true);
		$pdf->Cell(14,$hi,' ',1,0,'C',true);
		$pdf->Cell(170,$hi, "(".$csi.") documentos entregados y (".$cno.") documentos NO entregados.", 1,1,'C',true);
     	//$pdf->Cell(170,6,"REQUISITOS",1,1,'C',true);
		
		$pdf->SetTextColor(0,0,0);

$pdf->Ln(1);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(198, 5, utf8_decode("NOTA: El presente documento no implica el registro de los aspirantes, toda vez que está sujeto al análisis y revisión de las autoridades del H. Ayuntamiento"), 0);
$pdf->SetFont('Arial','',8);

$pdf->Ln(5);

$pdf->Cell(95,6,utf8_decode('Recibió'),'',0,'C');
$pdf->Cell(95,6,utf8_decode('Elaboró'),'',1,'C');
$pdf->Ln(10);
$pdf->Cell(95,4,'________________________________','',0,'C');
$pdf->Cell(95,4,'________________________________','',1,'C');
$pdf->Cell(95,4,'Nombre y Firma del Aspirante','',0,'C');
$pdf->Cell(95,4,'Nombre y Firma del Funcionario','',1,'C');





$pdf->cand = $res[0]->csuplente;
if (is_file('../docs/filex/'.$res[0]->foto2)) {
   $pdf->pic = $res[0]->foto2;
}else{
   $pdf->pic = 'siedmun-foto-intantil-2.gif';
}
$pdf->flag = 1;
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);


		$csi = 0;
		$cno = 0;
		for($j=1;$j<=10;++$j){
			$pdf->SetFont('Arial','B',10);
			$hi = 6.5;
			switch($j){
				case 1:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op11)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op11==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op11_desc;
					if (intval($res[0]->op1)==1) ++$csi; else ++$cno;
					break;
				case 2:
     				$pdf->Cell(14,$hi,intval($res[0]->op12)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op12==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op12_desc;
					if (intval($res[0]->op2)==1) ++$csi; else ++$cno;
					break;
				case 3:
     				$pdf->Cell(14,$hi,intval($res[0]->op13)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op13==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op13_desc;
					if (intval($res[0]->op3)==1) ++$csi; else ++$cno;
					break;
				case 4:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op14)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op14==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op14_desc;
					if (intval($res[0]->op4)==1) ++$csi; else ++$cno;
					break;
				case 5:
     				$pdf->Cell(14,$hi,intval($res[0]->op15)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op15==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op15_desc;
					if (intval($res[0]->op5)==1) ++$csi; else ++$cno;
					break;
				case 6:
     				$pdf->Cell(14,$hi,intval($res[0]->op16)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op16==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op16_desc;
					if (intval($res[0]->op6)==1) ++$csi; else ++$cno;
					break;
				case 7:
     				$pdf->Cell(14,$hi*3,intval($res[0]->op17)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*3,$res[0]->op17==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op17_desc;
					if (intval($res[0]->op7)==1) ++$csi; else ++$cno;
					break;
				case 8:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op18)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op18==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op18_desc;
					if (intval($res[0]->op8)==1) ++$csi; else ++$cno;
					break;
				case 9:
     				$pdf->Cell(14,$hi,intval($res[0]->op19)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi,$res[0]->op19==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op19_desc;
					if (intval($res[0]->op9)==1) ++$csi; else ++$cno;
					break;
				case 10:
     				$pdf->Cell(14,$hi*2,intval($res[0]->op20)==1?'SI':'','LT',0,'C');
     				$pdf->Cell(14,$hi*2,$res[0]->op20==0?'NO':'','LT',0,'C');
					$obsi = $res[0]->op20_desc;
					if (intval($res[0]->op10)==1) ++$csi; else ++$cno;
					//$pdf->MultiCell(14,$hi,intval($res[0]->op10)==1?'SI':'', 1);
					//$pdf->MultiCell(14,$hi,$res[0]->op10==0?'NO':'','RBT', 1);
					break;
			}
			$pdf->SetFont('Arial','',11);
     		//$pdf->Cell(100,16,$F->pregu[$j-1],'RBT','L');
			$pdf->MultiCell(170, $hi, $j.".- ".utf8_decode($F->pregu[$j-1]).". ".$obsi, 1);
		}

		$pdf->SetTextColor(255,255,255);
     	
		$pdf->Cell(14,$hi,' ',1,0,'C',true);
		$pdf->Cell(14,$hi,' ',1,0,'C',true);
		$pdf->Cell(170,$hi, "(".$csi.") documentos entregados y (".$cno.") documentos NO entregados.", 1,1,'C',true);
     	//$pdf->Cell(170,6,"REQUISITOS",1,1,'C',true);
		
		$pdf->SetTextColor(0,0,0);

$pdf->Ln(1);
$pdf->SetFont('Arial','',9);
$pdf->MultiCell(198, 5, utf8_decode("NOTA: El presente documento no implica el registro de los aspirantes, toda vez que está sujeto al análisis y revisión de las autoridades del H. Ayuntamiento"), 0);
$pdf->SetFont('Arial','',8);

$pdf->Ln(5);

$pdf->Cell(95,6,utf8_decode('Recibió'),'',0,'C');
$pdf->Cell(95,6,utf8_decode('Elaboró'),'',1,'C');
$pdf->Ln(10);
$pdf->Cell(95,4,'________________________________','',0,'C');
$pdf->Cell(95,4,'________________________________','',1,'C');
$pdf->Cell(95,4,'Nombre y Firma del Aspirante','',0,'C');
$pdf->Cell(95,4,'Nombre y Firma del Funcionario','',1,'C');

		
$pdf->Output();

?>
