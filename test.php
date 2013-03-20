<?php
 error_reporting(E_ALL);
 ini_set("display_errors", 1);

require_once("oConMS.php");

$con = oConMS::getInstance();

mssql_connect($con->myServer, $con->myUser, $con->myPass);
mssql_select_db ($con->myDB);
$sql= "select * from Polizas where Fecha > ('2013-01-01')";
$rs= mssql_query ($sql);
while ($fila = mssql_fetch_object($rs)) {
    echo $fila->Id."\n\n".$fila->RowVersion."\n\n".$fila->Ejercicio."\n\n".$fila->Periodo."\n\n".$fila->TipoPol."\n\n".$fila->Folio."\n\n".$fila->Clase."\n\n".$fila->Impresa."\n\n".$fila->Concepto."\n\n".$fila->Fecha."\n\n".$fila->Cargos."\n\n".$fila->Abonos."\n\n".$fila->IdDiario."\n\n".$fila->SistOrig."\n\n".$fila->IdUsuario."\n\n".$fila->Ajuste."\n\n".$fila->ConFlujo."\n\n".$fila->ConCuadre."\n\n"."<br/>";
    //echo $fila->nombre_completo;
}
mssql_free_result($rs);
?>
