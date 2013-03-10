<?php
header("text/html; charset=utf-8");  
header("Cache-Control: no-cache");

$arg = $_POST["data"];
parse_str($arg);


date_default_timezone_set('America/Mexico_City');

require_once('../vo/voConn.php');
require_once("../oFunctions.php");
require_once("../oCentura.php");


$Q = oFunctions::getInstance();
$f = oCentura::getInstance();
?>

<div class="ui-widget" style="text-align:left !important;">
	<div class="ui-state-highlight ui-corner-all" style=" padding: 0 .7em;">
		<p>
		<h2 class="demoHeaders">REGISTRO DE FÓRMULA </h2>| <strong>Comunidad: </strong> <span class="ui-icon ui-icon-image doti" ></span><?php echo strtoupper($txtcomunidad); ?>
		<span class="ui-icon ui-icon-person doti"></span>
		<strong>Registro de: </strong> <?php echo strtoupper($nombrec_prop)." (Delegado Propietario)"; ?>
		</p>
		
	</div>
</div>
<form id="formBodyii"  class="form ui-widget-content" >
<?php
foreach($Q->pregu as $i=>$valor){
?>
	
	<fieldset class="fieldset-margin-left ui-state-error ui-corner-all" id="fst-<?php echo $i+1; ?>">
	   		<label class="separ1" ><span class="ui-icon ui-icon-circle-arrow-e doti"></span><?php echo $i+1; ?>.- <?php echo $Q->pregu[$i]; ?> </label><br>
			<label for = "op-<?php echo $i+1; ?>-0" class="separ2">SI</label><input type = "radio" name = "op<?php echo $i+1; ?>" id = "op-<?php echo $i+1; ?>-0" value = "1"/>
			<label for = "op-<?php echo $i+1; ?>-1" class="separ2">NO</label><input type = "radio" name = "op<?php echo $i+1; ?>" id = "op-<?php echo $i+1; ?>-1" value = "0" checked/>
	   		<label for="op<?php echo $i+1; ?>_desc" class="separ2">Obs </label>
			<input type="text" name="op<?php echo $i+1; ?>_desc" id="op<?php echo $i+1; ?>_desc" value="" class="text ui-widget-content ui-corner-all"></input>
			
	</fieldset><br><br>

<?php
}
?>
<div class="ui-widget" style="text-align:left !important; margin-bottom:1em;">
	<div class="ui-priority-primary ui-corner-all" style=" padding: 0 .7em;">
		<p>
		<span class="ui-icon ui-icon-person doti"></span>
		<strong>Registro de: </strong> <?php echo strtoupper($nombrec_sup)." (Delegado Suplente)"; ?>
		
		</p>
		
	</div>
</div>

<?php
foreach($Q->pregu as $i=>$valor){
?>
	
	<fieldset class="fieldset-margin-left ui-state-error ui-corner-all" id="fst-<?php echo $i+11; ?>">
	   		<label class="separ1" ><span class="ui-icon ui-icon-circle-arrow-e doti"></span><?php echo $i+1; ?>.- <?php echo $Q->pregu[$i]; ?> </label><br>
			<label for = "op-<?php echo $i+11; ?>-0" class="separ2">SI</label><input type = "radio" name = "op<?php echo $i+11; ?>" id = "op-<?php echo $i+11; ?>-0" value = "1"/>
			<label for = "op-<?php echo $i+11; ?>-1" class="separ2">NO</label><input type = "radio" name = "op<?php echo $i+11; ?>" id = "op-<?php echo $i+11; ?>-1" value = "0" checked/>
	   		<label for="op<?php echo $i+11; ?>_desc" class="separ2">Obs </label>
			<input type="text" name="op<?php echo $i+11; ?>_desc" id="op<?php echo $i+11; ?>_desc" value="" class="text ui-widget-content ui-corner-all"></input>
			
	</fieldset><br><br>

<?php
}
?>

<div class="ui-widget">
	<div class="ui-priority-primary ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
		<strong>ATENCIÓN!</strong> para que el registro se complete satisfactoriamente no debe quedar ningun registro en rojo.</p>
	</div>
</div>
	<fieldset  class="fieldset-margin-left ui-widget-content ui-corner-all" style="display:none;">
		<label for="observaciones" class="1emBottom"  style="display:none;">Observaciones: </label><br>
        	<textarea type="text"  name="observaciones" id="observaciones" class="shrt text ui-widget-content ui-corner-all" style="display:none;"> </textarea>
	</fieldset>

    <fieldset class="formContract">
        <input type="submit" value="Registrar Información" /><span style="width:25% !important; height:1em; display:inline-block" ></span>

	<input type="hidden" name="idcomun" id="idcomun" value="<?php echo $idcomunidad; ?>" />
	<input type="hidden" name="idpropietario" id="idpropietario" value="<?php echo $idpropietario; ?>" />
	<input type="hidden" name="idsuplente" id="idsuplente" value="<?php echo $idsuplente; ?>" />
 	<input type="hidden" name="iduser"      id="iduser" value="<?php echo $iduser; ?>" />
   </fieldset>

</form>

<style>
body{ font-size:16px;}
#formBodyii {position:relative;display:inline-block; vertical-align:top; width:96%; margin-top:1em; font-size:16px;}
input[type=radio]{ width:5em;}
input[type=text]{ width:20em; background-color:#FFF !important;}
.separ1{ margin-bottom:0.5em;}
.separ2{ margin-right:0.5em;}
#formBodyii > fieldset{ padding:1em; width:97%;}
#formBodyii > fieldset > #observaciones{ padding:1em; width:90%;}
.doti{display:inline-block; vertical-align:top; margin-right: .3em;}
</style>

<script>
	
	$("#iduser").val(sessionStorage.Id);
	var iduser = sessionStorage.Id;
	

	// Operaciones con el Formulario 
	$('#formBodyii').submit(function() { 
    		$(this).ajaxSubmit({ success: evalSave }); 
     	return false;
	});
	
	$("#formBodyii > fieldset > input[type=radio]").on("click",function(event){
		var idt = event.currentTarget.id;
		//alert(idt);
		var id = idt.split("-");
		var fst = $("#fst-"+id[1]);
		if ($(this).val() == 1){
			fst.removeClass("ui-state-error");
			fst.addClass("ui-state-highlight");
		}else{
			fst.removeClass("ui-state-highlight");
			fst.addClass("ui-state-error");
		}
		
	});
	
function evalSave(){
	event.preventDefault();
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		width:380,
		height:320,
		modal: true,
		buttons: {
			"SI": function() {
					tipo = 2;
					invocarFormulario(); 
					$( this ).dialog( "close" );
			},
			"NO": function() {
				$( this ).dialog( "close" );
			}
		}
	});
}
	

function invocarFormulario(){
	var queryString = $('#formBodyii').formSerialize(); 
	$.post(och.getValue(0)+"getEC/", { o:40, t:0, p:2,c:queryString },
		function(json){
			if (json[0].msg=="OK"){
				stream.emit("cliente", {mensaje: "D9"}); 
				queryString = "<?php echo $nombrec_prop."|".$nombrec_sup."|".$txtcomunidad; ?>";
			}else{
				queryString = json[0].msg;
			}
			//alert(queryString);
			$.post(och.getValue(0)+"getEH/", { o:201, t:0, p:0,c:queryString },
			function(json){
				if (json.length<=0) { return false;}
					$(".asignaciones1").html(json);
 			}, "html");


 		}, "json"
	);
}

function validateFormReg(formData, jqForm, options) { 
 	var form = jqForm[0]; 
    if (!form.op1.value ) { alert('Responda la Pregunta 1'); return false; } 
    if (!form.op2.value ) { alert('Responda la Pregunta 2'); return false; } 
    if (!form.op3.value ) { alert('Responda la Pregunta 3'); return false; } 
    if (!form.op4.value ) { alert('Responda la Pregunta 4'); return false; } 
    if (!form.op5.value ) { alert('Responda la Pregunta 5'); return false; } 
    if (!form.op6.value ) { alert('Responda la Pregunta 6'); return false; } 
    if (!form.op7.value ) { alert('Responda la Pregunta 7'); return false; } 
    if (!form.op8.value ) { alert('Responda la Pregunta 8'); return false; } 
    if (!form.op9.value ) { alert('Responda la Pregunta 9'); return false; } 
    if (!form.op10.value ) { alert('Responda la Pregunta 10'); return false; } 
    if (!form.op11.value ) { alert('Responda la Pregunta 11'); return false; } 
    if (!form.op12.value ) { alert('Responda la Pregunta 12'); return false; } 
    if (!form.op13.value ) { alert('Responda la Pregunta 13'); return false; } 
    if (!form.op14.value ) { alert('Responda la Pregunta 14'); return false; } 
    if (!form.op15.value ) { alert('Responda la Pregunta 15'); return false; } 
    if (!form.op16.value ) { alert('Responda la Pregunta 16'); return false; } 
    if (!form.op17.value ) { alert('Responda la Pregunta 17'); return false; } 
    if (!form.op18.value ) { alert('Responda la Pregunta 18'); return false; } 
    if (!form.op19.value ) { alert('Responda la Pregunta 19'); return false; } 
    if (!form.op20.value ) { alert('Responda la Pregunta 20'); return false; } 
}


</script>

<div id="dialog-confirm" title="@DevCH" style="display:none;">
	<p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span>En este momento se dispone a guardar los datos <br><br>Esta seguro de hacerlo?</p>
</div>
