<?php 
function error_message_html($ar=array()){ 
$cad = "";
if (count($ar)>0){
$cad .= "<ul>";
	foreach($ar as $item=>$value){ 
	     $var1 = str_replace("Table 'tabascow.","",$ar[$item]);
	     $var1 = str_replace("' doesn't exist","",$var1);
		$cad .= "<li>".$var1."</li>";
	}
$cad .= "</ul>";
}
return $cad;
} 
?>

<?php
function messageBan($id=0,$cad="",$arr=array()){
	switch($id){
		case 0:
?>
<div class="ui-widget">
	<div class="ui-priority-primary ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong><?php echo strtoupper($arr[0]); ?></strong> fue registrado como Candidado a <strong>Delegado Propietario</strong><br>
		<strong><?php echo strtoupper($arr[1]); ?></strong> fue registrado como Candidado a <strong>Delegado Suplente</strong><br>
		LOCALIDAD: <strong><?php echo strtoupper($arr[2]); ?></strong>
		</p>
	</div>
</div>
<?php
	break;
		case 1:
?>
<div class="ui-widget">
	<div class="ui-priority-primary ui-state-error ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		<?php echo strtoupper($cad); ?>.
		</p>
	</div>
</div>
<?php
	break;
?>	
<?php
	}
}
?>