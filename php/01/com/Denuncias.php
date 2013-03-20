
<div id="msgResponse"></div>

<form id="formContract" class="form fieldset2" >
	<fieldset id="itemContract">
	   	<label for="idpropietario2"># ID Propietario: </label>
        	<input type="number" name="idpropietario2" id="idpropietario2" class="text ui-widget-content ui-corner-all" required autofocus />
	   	<label for="idsuplente2"># ID Suplente: </label>
        	<input type="number" name="idsuplente2" id="idsuplente2" class="text ui-widget-content ui-corner-all" required autofocus />
          <input type="submit" value="Buscar" />
    </fieldset>
</form>
<form id="formBody" class="form ui-widget-content" >
	<fieldset >
	   	<label for="nombrec_prop" id="lblProp">Propietario: </label>
		<input type="text" name="nombrec_prop" id="nombrec_prop" class="text ui-widget-content ui-corner-all"  maxlength="30" min="4"  />
	   	<label for="nombrec_sup" id="lblSup" class="fieldset-margin-left">Suplente: </label>
		<input type="text" name="nombrec_sup" id="nombrec_sup" class="text ui-widget-content ui-corner-all"  maxlength="30" min="4"  />
	</fieldset>
	<fieldset>
	   	<label for="txtcomunidad" >Delegación </label>
        	<input type="text" name="txtcomunidad" id="txtcomunidad" class="text ui-widget-content ui-corner-all" required autofocus/>
	</fieldset>
	<input type="hidden" name="idcomunidad" id="idcomunidad" value="0" />
	<input type="hidden" name="idpropietario" id="idpropietario" value="0" />
	<input type="hidden" name="idsuplente" id="idsuplente" value="0" />
	<input type="hidden" name="iduser" id="iduser" value="0" />
	<input type="hidden" name="idreg" id="idreg" value="0" />
    <fieldset class="formContract">
        <input type="submit" value="Capturar Registro" />
    </fieldset>
</form>
<div id="toolbar" class="ui-widget-header ui-corner-all">
	<button id="delItem">Quitar</button>
	<!--<button id="refreshTable">Actualizar</button>-->
	<button id="find">Buscar</button>
	<button id="addPic">Agregar foto propietario</button>
	<button id="addPic2">Agregar foto suplente</button>
	<button id="printReg">Imprimir Registro</button>
	<span id="spanTitle">Candidatos Registrados</span>
</div>

<div id="users-contain" class="form ui-widget-content" >
	<table id="tableList" class="table_base" >
		<thead>
			<tr class="ui-widget-header">
			     <th class="item">Item</th>
				<th class="comunidad">Localidad</th>
				<th class="cpropietario">Propetario</th>
				<th class="csuplente">Suplente</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		<tfoot>
			<tr class="ui-widget-header borderBottom">
				<td colspan="8" > <span id="oPagination"></span> </td>
			</tr>
		</tfoot>
		
	</table>
</div>

<style>
#tableList .item{width:120px; padding-top:5px;}
#tableList{display:inline; position:relative;}
.opItem{width:30px; margin-top:3px; background-color:#09F;}
#tableList .cliente,#tableList .agente{width:200px;}
#tableList .total{width:100px;}
#tableList .fecha{width:100px;}
#tableList .descripcionc{width:400px;}
#tableList .dependencia{width:400px;}
#tableList .status{width:100px;}
#tableList .fecha_dep{width:100px; text-align:right !important;}
#tableList .money{ text-align:right; margin-right:1em !important;}
#tableList .comunidad{width:250px;}
#tableList .cpropietario{width:250px;}
#tableList .csuplente{width:250px;}

#tblfindCli .item{width:100px; padding-top:5px;}
#tblfindCli .nombrec_prop{widt:250px;}
#tblfindCli .nombrec_sup{widt:250px;}
#tblfindCli .domc{widt:200px;}
.money, .header1{ text-align:right; display:block; margin-right:1em !important; }

#toolbar, #formContract{width:99%; position: relative !important; margin:1em 0px; text-align:left; padding:0.4em 0em 0.5em 0.4em; }
#formBody, #users-contain {position:relative; width:96.7%;}
#users-contain{ padding:1em; overflow:scroll; overflow-x:hidden;  text-align:left;}
#formBody > #h3{ padding:0.4em 0.5em; margin-bottom:0.8em; text-align:left;}
#formBody > #h3 span{ display:inline-block;}

#formBody > fieldset > #nombrec_prop{ width:35% !important;}
#formBody > fieldset > #nombrec_sup{ width:35% !important;}
#formBody > fieldset > #domc{ width:50% !important;}
#formBody > fieldset > #descripcion{ width:50% !important;}
#formBody > fieldset > #respuesta{ width:50% !important;}
#formBody > fieldset > #noficio{ width:25% !important;}
#formBody > fieldset > #cantidad{width:40px !important;}

#form-respuesta-dep >  fieldset > #respuesta_dep{width:100% !important; height:10em !important;}

#form-respuesta-dep >  fieldset > #observaciones{width:100% !important; height:10em !important;}

.ui-autocomplete-loading { background: white url('../../images/img-web/ui-anim_basic_16x16.gif') right center no-repeat; }
.shrt{ width:50px !important} 
.btnPlusIcon{ background:url(../../images/img-web/plus-icon.png) top left no-repeat !important; margin-left:0.3em; width:16px; height:20px; line-height:18px; display:inline-block; cursor:pointer; }
input[name='datofis']{width:90% !important;}

.findNameComplete{ margin-bottom:0.2em !important;}
#users-contain{ overflow-y:scroll;}

</style>


<script type="text/javascript">

	var tipo          = 0;
	var currentItem   = 0;
	var index         = -1;
	var proc          = 2;
	var arrItems      = new Array();
	var arrDet        = new Array();
	var arOrderBy     = [" idreg asc "," idreg desc "," comunidad asc "," comunidad desc "," ccandidato asc "," ccandidato desc "," csuplente asc "," csuplente desc "];
	var objInAuto     = ["comunidad"];
	var orderBy       = arOrderBy[0];
	var urlSearch     = och.getValue(0)+"getSR/?o=";
	var indiceTabla   = 0;
	var oPag          = {totalPaginas:0,currentPage:0,CantidadPagina:20};
	var query         = "";
	var indice        = 0;
	var idreg         = 0;
	
	//var xc = och.getMinHeight()-($("#formContract").height()+$("#formBody").height()+$("#toolbar").height()+100);
	//$("#users-contain").height(xc);
	
	$("#iduser").val(sessionStorage.Id);
	var iduser = sessionStorage.Id;
	
	if (!och.getUser(13)){
		$("#delItem").hide();
	}	

	if (!och.getUser(14) || !och.getUser(15)){
		$("#cmdSave").hide();
	}	

	if (!och.getUser(16)){
		$("#response").hide();
	}	
	
	$("#formBody").hide();
	//$("#users-contain").hide();
	//$("#toolbar").hide();
	
	
	$("#delItem").on('click',function(event){
		event.preventDefault();
		proc = 2;
		eliminarRegistroActual();
		
	});

	$("#toolbar form #radio > h1").text("Tabla de "+och.cat[och.index].Catalogo); 
	$("#formBody > #h3 > #tituloForm").text(och.cat[och.index].Catalogo); 
	$("#radio").buttonset();

	// Operaciones con el Formulario 
	$('#formContract').submit(function() { 
    		$(this).ajaxSubmit({  success: buscarCliente }); 
     	return false; 
	});


	$( "#delItem" ).button({text: true,icons: {primary: "ui-icon-minusthick"}});
	/*$( "#refreshTable" ).button({text: true,icons: {primary: "ui-icon-refresh"}})*/
	$( "#addPic").button({text: true,icons: {primary: "ui-icon-person"}})
	$( "#addPic2").button({text: true,icons: {primary: "ui-icon-person"}})
	$( "#find").button({text: true,icons: {primary: "ui-icon-search"}})
	$( "#printReg" ).button({text: true,icons: {primary: "ui-icon-print"}})

	$( "#addPic").hide();
	$( "#addPic2").hide();
	$( "#printReg" ).hide();

	$.each(objInAuto, function(i, item) {
			var val = item;
			$("#txt"+val).autocomplete({source: urlSearch+i+"&s="+val,minLength: 2,autoFocus:true,
				select:function(event,ui) {$("#id"+val).val(ui.item.id);},
				change:function(event,ui) {$("#id"+val).val(ui.item.id);}
			});
			$("#txt"+val).on("change",function(){
				$("#id"+val).val(0);
				//alert($("#id"+val).val());
			})
	});



function sayPintaPaginacion(oPag){
	$("#oPagination").html("");
	for (var i=0;i<oPag.totalPaginas;i++){
		var j = i+1;
		var clasebase = i==0?'oPagBold':'';
		$("#oPagination").append("<a id='oPA-"+i+"' class='oPag "+ clasebase +"'>"+j+"</a>");
	}
	$(".oPag").on("click",function(event){
		var id = event.currentTarget.id
		var arr = id.split("-");
		oPag.currentPage=arr[1]*oPag.CantidadPagina;
		$(".oPag").removeClass('oPagBold');
		$(".oPag").addClass('oPagNormal');
		$("#"+id).addClass('oPagBold');
		tablaDeElementos();
	}); 
}

$('#idpropietario2').focus();


function clearObjects(){
	tipo = 0;
	proc = 2;
	idcli            = 0;
	idproducto       = 0;
	idareadep        = 0;
	iddep            = 0;
	orderBy          = arOrderBy[1];
	oPag.currentPage = 0;
	indiceTabla      = 0;
	query            = "";
	idreg            = 0;
	
	$('#idpropietario').focus();
}

stream.on("servidor", jsNewReg);  


function jsNewReg(datosServer){
	if (datosServer.mensaje=="D9"){
		tablaDeElementos();
	}
}

tablaDeElementos();


function buscarCliente(responseText, statusText, xhr, $form){
	//$("#tableList > tbody").html(getPreloader());
	//sayMsgPreloading($("#msgResponse"),1);
	
	var queryString = $form.formSerialize(); 
	
	//alert(queryString);
	
	$.post(och.getValue(0)+"getEC/", { o:40, t:19, p:5,c:queryString },
		function(json){
			if (json[0].msg!="OK") {
				alert(json[0].msg);
				idpropietario       = 0;
				return false;
			}else{
				//alert(json[0].idsuplente);
				   $("#formContract").hide();
				   $("#formBody").show();
				   $("#users-contain").show();
				   $("#toolbar").show();
				   $("#formBody > fieldset > input[name=nombrec_prop]").val(json[0].propietario);
				   $("#formBody > fieldset > input[name=nombrec_sup]").val(json[0].suplente);
				   $("#idpropietario").val(json[0].idpropietario);
				   $("#idsuplente").val(json[0].idsuplente);
				   //query = " and idpropietario = "+idpropietario+ " ";
				   tablaDeElementos();
				   $("#formBody > fieldset > input[name='txtcomunidad']").focus();
				   $('#formBody').submit(function() { 
    						$(this).ajaxSubmit({beforeSubmit:validateFormReg, success: invocarFormulario }); 
     					return false; 
				   });

			}
 	}, "json");
}


//Listado Registros Completos
function tablaDeElementos(){
	//event.preventDefault();
	var queryString = $("#formBody").formSerialize(); 
	$("#tableList > tbody").html(getPreloader());
	//alert(queryString);	
	oBy= orderBy!=""?" Order By ":"";
	//alert(" "+query+" "+oBy+orderBy);
	$.post(och.getValue(0)+"getEC/", { o:och.index, t:12, p:3,c:" "+query+" "+oBy+orderBy,from:oPag.currentPage, cantidad:oPag.CantidadPagina,s:queryString },
		function(json){
			if (json.length<=0) { return false;}
			//alert(2);
			cargarRegistrosLeidos(json);
			
 	}, "json");
}

function cargarRegistrosLeidos(json){
	//event.preventDefault();
	var str = "";
	var suma = 0;
	var id  = 0;
	
	$("#tableList tbody").html("");
	//alert(1);
	$.each(json, function(i, item) {
          id = item.idreg;
		arrItems[i] = {idreg:item.idreg,ccandidato:item.ccandidato, csuplente:item.csuplente, 
					comunidad:item.comunidad,idcomun:item.idcomun};
		str = "";
		str +='<tr id="tr-'+i+'" class="idsel">';	
		str +='<td><input type="radio" id="i-'+id+'" name="radio" class="opItem" />'+item.idreg+'</td>';
		str +='<td><span>'+item.comunidad+' ('+item.idcomun+')'+' ('+item.nformula+')'+'</span></td>'; 
		str +='<td><span>'+item.ccandidato+'</span></td>'; 
		str +='<td><span>'+item.csuplente+'</span></td>'; 
		str +="</tr>";
		$("#tableList > tbody").append(str);	
	});
	index = -1;
	indice = 0;
	
	
	$("#tableList tr").on('click',function(event){
		event.preventDefault();
		var i = this.id.split("-");
		index = i[1];
		$('td input[name=radio]',this).prop("checked", true);
		editarRegistroActual();
		//alert(index);
	})
	
}

function editarRegistroActual(){
	//event.preventDefault();
	
	tipo = 1;
	
	idreg = parseInt(arrItems[index].idreg);

	$("#idreg").val(parseInt(arrItems[index].idreg));
	
	$( "#addPic").show();
	$( "#addPic2").show();
	$( "#printReg" ).show();
	
	
}


function eliminarRegistroActual(){
	event.preventDefault();
	$("#delitem1").html("Desea eliminar la fórmula compuesta por<br>"+arrItems[index].ccandidato+",<br>"+arrItems[index].csuplente+"? <br><br> El cambio será irreversible");
	$( "#dialog-confirm" ).dialog({
		resizable: false,
		width:380,
		height:220,
		modal: true,
		buttons: {
			"SI": function() {
					tipo = 2;
					//invocarFormulario( $("#formBody") );
					$("#formBody").ajaxSubmit({  success: invocarFormularioFast }); 
					$( this ).dialog( "close" );
			},
			"NO": function() {
				$( this ).dialog( "close" );
			}
		}
	});
}


$("#printReg").on('click',function(event){
	printFolio(index,0);
});


function printFolio(i,format){	
	var PARAMS = {idreg:arrItems[i].idreg};  
	var url = och.getValue(0)+"php/01/docs/fmt-04.php";

	var temp=document.createElement("form");
	temp.action=url;
	temp.method="POST";
	temp.target="_blank";
	temp.style.display="none";
	for(var x in PARAMS) {
		var opt=document.createElement("textarea");
		opt.name=x;
		opt.value=PARAMS[x];
		temp.appendChild(opt);
	}
	document.body.appendChild(temp);
	temp.submit();
	return temp;

};


$("#find").on('click',function(event){
	//$( "#form-find-demanda > fieldset >  input[name=iddep3]" ).val(iddep);
	$( "#dialog-form-demanda").dialog({
		resizable: false,
		height:260,
		width:360,
		title:"Buscar dato",
		modal: true,
		buttons: {
			"Consultar": function() {
					tipo = 5;
					$("#form-find-demanda").submit();
					$( this ).dialog( "close" );
			},
			"Cerrar": function() {
				$(this).clearForm();
				$(this).resetForm();
				$( this ).dialog( "close" );

			}
		}
	});
});

$('#form-find-demanda').submit(function() {
	$(this).ajaxSubmit({ success: invocarFormFind }); 
     return false; 
});

function invocarFormFind(responseText, statusText, xhr, $form){
	var queryString = $('#form-find-demanda').formSerialize(); 
	$("#tableList > tbody").html(getPreloader());
	oBy= orderBy!=""?" Order By ":"";
	//alert(queryString);
	$.post(och.getValue(0)+"getEC/", { o:och.index, t:1002, p:3,c:oBy+orderBy,from:oPag.currentPage, cantidad:oPag.CantidadPagina,s:queryString },
		function(json){
			if (json.length<=0) { return false;}
			//getPag3(parseInt(json[0].registros));   
			cargarRegistrosLeidos(json);
			//$("#oPagination").html("");

 	}, "json");

}

function invocarFormulario(responseText, statusText, xhr, $form){
	var queryString = $("#formBody").formSerialize();  

	$.post(och.getValue(0)+"seted/", { data:queryString },
		function(json){
			if (json.length<=0) { return false;}
			$(".asignaciones1").html(json);
 	}, "html");
}

$("#addPic").on('click',function(event){
	//var queryString = $("#formBody").formSerialize();  

	$.post(och.getValue(0)+"php/01/com/imageUpload.php", { idreg:parseInt(arrItems[index].idreg), idu:iduser,tfoto:0 },
		function(json){
			if (json.length<=0) { return false;}
			$(".asignaciones1").html(json);
 	}, "html");
});

$("#addPic2").on('click',function(event){
	//var queryString = $("#formBody").formSerialize();  
	$.post(och.getValue(0)+"php/01/com/imageUpload.php", { idreg:parseInt(arrItems[index].idreg), idu:iduser,tfoto:1 },
		function(json){
			if (json.length<=0) { return false;}
			$(".asignaciones1").html(json);
 	}, "html");
});


function invocarFormularioFast(responseText, statusText, xhr, $form){
	event.preventDefault();
	sayMsgPreloading($("#msgResponse"),-1)
	var queryString = $form.formSerialize(); 
	$.post(och.getValue(0)+"getEC/", { o:och.index, t:tipo, p:2,c:queryString },
		function(json){
			sayMessage(json[0].msg,json[0].msg,$("#msgResponse"),"Datos guardados con éxito");
			if (json[0].msg=="OK"){
				$form.clearForm();
				$form.resetForm();
				tablaDeElementos();
				if (tipo == 0 || tipo == 2){
				   getPag2(idcandidato,"ed_registros","idreg", oPag,4,-1,20);
				}
				stream.emit("cliente", {mensaje: "D9"});
			}
 		}, "json"
	);
}


function validateFormReg(formData, jqForm, options) { 
 var form = jqForm[0]; 
    if (!form.idcomunidad.value || form.idcomunidad.value<=0 ) { 
        alert('Por favor, seleccione una localidad '); 
        return false; 
    } 
    if (!form.idpropietario.value || form.idpropietario.value<=0 ) { 
        alert('Por favor, intente buscar al propietario '); 
        return false; 
    } 
    if (!form.idsuplente.value || form.idsuplente.value<=0 ) { 
        alert('Por favor, intente buscar al suplente '); 
        return false; 
    } 
}
</script>

<div id="dialog-confirm" title="@DevCH" style="display:none;">
	<p><span class="ui-icon ui-icon-help" style="float:left; margin:0 7px 20px 0;"></span><strong id="delitem1">Desea eliminar el elemento seleccionado?</strong></p>
</div>

<div id="dialog-form-demanda" title="Buscar nombre" style="display:none;">

	<form id="form-find-demanda">
	<br/><br/>
	<fieldset>
		<label for="findDem" class="findNameComplete">Dato</label>
		<input type="text" name="findDem" id="findDem" class="text ui-widget-content ui-corner-all" /><br/><br/>
		<label for="optFindDem" >Buscar por</label>
		<select name="optFindDem" id="optFindDem" size=1  value="" >
			<option value="0" selected >ID del Comunidad</option>
	   	</select>
	<input type="hidden" id="iddep3" name="iddep3" value="0" />
			   
	</fieldset>
	</form>
</div>

