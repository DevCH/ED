// JavaScript Document

$(document).on("ready",init);

function init(){
	hiddenButtom();
	$("#panelRight").addClass("asignaciones2");

		if ($("#formLogin").length){ 
		   $("#preloader").hide();	
		   $("#preloader").html(getPreloader());
		   $("#formLogin").on("submit", login);
		}
		
		if ($('#accordion').length){

			var icons = {
				header: "ui-icon-circle-arrow-e",
				headerSelected: "ui-icon-circle-arrow-s"
			};
	
			$("#accordion").accordion({
				autoHeight: false,
				navigation: true,
				collapsible: true,
				icons: icons
			});
			
			$( "#toggle" ).button().toggle(function() {
				$( "#accordion" ).accordion( "option", "icons", false );
			}, function() {
				$( "#accordion" ).accordion( "option", "icons", icons );
			});			
			
		}
		if ($("#spanUser").length) {
			if (sessionStorage.name){
				$("#spanUser").text(sessionStorage.name);
				
			}else {document.location.href = och.getValue(0); }
		} 
		
		if ($("#closeSession").length) {
			$("#closeSession").on("click",function(){
				//alert("hola");
				delete sessionStorage.Id;
				document.location.href = och.getValue(0);
			});
		} 
		
		if ($(".btnMnuHome").length){
			$(".btnMnuHome").on("click",openCat);
		}
		if ($(".asignaciones1").length){
			och.setMinHeight($(window).height()-och.height);
			$(".asignaciones1").css("min-height", function() { return och.getMinHeight();});
			
		}


		if ($(".initLogin").length){
			$(".initLogin").css("height", function() { return $(window).height()-och.height;});
		}
		
		
		if ($("#btn-cli.200")){
			$.post(och.getValue(0)+"getEC/",{o:-2,t:0,p:0,c:sessionStorage.Id},function(datax){$.each(datax,function(i,item){setValues(i,item)});for(j=0;j<30;j++){if(och.getUser(j+1)){$(".ou"+j).show()}}},"json");
		}
}

function login(event){
	event.preventDefault(); 
	$("#preloader").show();	
	//alert(och.getValue(0)+"getDC/");
	$.post(och.getValue(0)+"getDC/", { u:$("#username").val(), p:$("#password").val() },
 		function(json){
			if (json.length<=0) {$("#preloader").html("<p> Nombre de usuario o password incorrecto </p>"); return false;}
			$.each(json, function(i, item) {
				$("#preloader").html("<p> "+item.label+" iniciando..."+" </p>");	
				if (!sessionStorage.Id || sessionStorage.Id!==item.data) {
					sessionStorage.Id=item.data;
					sessionStorage.name = item.label;
					localStorage.nc     = item.label;
				}else{
					$("#spanUser").text(item.label+" iniciando...");
				}
				document.location.href = item.url;
			});
 	}, "json");

}


function openCat(event){
	
	event.preventDefault();
	
	clearVar();
			
	$(".asignaciones1").html(getPreloader());
	$("#panelRight").removeClass("asignaciones2");
	
	var op = event.currentTarget.id.split(".");
	och.index = parseInt(op[1]); //och.cat[op[1]].Catalogo);
	localStorage.opt = och.index;
	
	var ab = "php/01/com/";
	var lcad = 0;
	switch(och.index){
		case 0:
			lcad = "ClientesCat.php";
			break;
		case 1:
			lcad = "ClientesCat.php";
			break;
		case 40:
			lcad = "Denuncias.php";
			break;
		case 200:
			lcad = "sidc-panel-reports.php";
			break;
	}
	
	$.post(och.getValue(0) + ab +lcad,
     	function( json ) {
			$(".asignaciones1").html("");
			$(".asignaciones1").html(json);
      	},'html'
	);
}


function clearVar(){
	tipo          = null;
	currentItem   = null;
	index         = null;
	proc          = null;
	arrItems      = null;
	arOrderBy     = null;
	urlSearch     = null;
	folio         = null;
	idfactura     = null;
	idcli         = null;
	idcontrato    = null;
	indiceTabla   = null;
	saldoCliente  = null;
	anticiposCliente = null; 
	orderBy       = null;
	oPag          = null;
	arrDet        = null;
	objInAuto     = null;
	objInAutoId   = null;
	objInAutoTerm = null;
	saldoFactura  = null;
	fecha         = null;
	idproducto    = null;
	idcli         = null;
	query         = null;
	agregadoen    = null;
	iddenuncia    = null;
	iddep         = null;
	iduser        = null;
	rol           = null;
}