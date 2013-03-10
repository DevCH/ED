//var oUser = new Object();
function oDevCH() {
	var doctoper = [];
	var oUser = [0,false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,
				false,false,false,false,false,false,false,false,false,false,false,false,false,false,false,0];
	var minHeight = 0;
	var pHost = ["http://ed.tabascoweb.com/",/iphone|ipad|ipod|android/i.test(navigator.userAgent), /msie\s6/i.test(navigator.userAgent)];
	
	var cat = [];
	var index = 0;
	var height = 100; 
	var sep = "_devch_";

	var getInstance = function() {
	    if (!oDevCH.singletonInstance) {
			oDevCH.singletonInstance = createInstance();
	    }
	    return oDevCH.singletonInstance;
	}

	var createInstance = function() {
		return {
			setDP : function(name) {
				doctoper.push(name);
				return this.getDP();
			},
			getDP : function() {
				return doctoper;
			},
			getValue : function(i) {
				return pHost[i];
			},
			setUser : function(i,value) {
				oUser[i]=value;
			},
			getUser : function(i) {
				return oUser[i];
			},
			setMinHeight : function(value) {
				minHeight=value;
			},
			getMinHeight : function() {
				return minHeight;
			}
			
		}
	}

	return getInstance();
}

var och = new oDevCH();
och.height = 150;
och.sep = "_devch_";
// Evalua si exsite o no una variable
function isDefined( variable) { return (typeof(window[variable]) != "undefined");}

// Carga un preloader
function getPreloader(){
	return "<span class='p-pre-loader'><img src='../../images/img-web/input-loading.gif' alt=' ' /> <span>cargando...</span></span>";
}

function sayLoaderSave(){
	return "<span class='p-pre-loader'><img src='../../images/img-web/preloader2.gif' alt=' ' /> <span>guardando..</span></span>";
}

function sayQuering(){
	return "<span class='p-pre-loader'><img src='../../images/img-web/preloader1.gif' alt=' ' /> <span>consultando..</span></span>";
}


function sayMessage(q,m,o,ext,duracion){
	
	if ( !isDefined(duracion) ) {duracion = 2000};
	switch(q){
		case "OK":
			o.removeClass("msgFontError");
			o.addClass("msgFontOk");
			o.html(ext).show("clip",500).delay(duracion).hide("clip",500);
			break;
		default:
			o.removeClass("msgFontOk");
			o.addClass("msgFontError");
			o.html(m).show("clip",500).delay(duracion).hide("clip",500);
			break;
	}
}


function sayMsgPreloading(o,t){
	o.show();
	switch(t){
		case 1:
			o.html(sayQuering());
			break;
		default:
			o.html(sayLoaderSave());
			break;
	}
}

function compare_dates(fecha, fecha2)  
  {  
   // alert(fecha+ " < - > "+ fecha2); 
    var xMonth=parseFloat(fecha.substr(5, 2));  
    var xDay=parseInt(fecha.substr(8, 2));  
    var xYear=parseInt(fecha.substr(0,4));  
    var yMonth=parseFloat(fecha2.substr(5, 2));  
    var yDay=parseInt(fecha2.substr(8, 2));  
    var yYear=parseInt(fecha2.substr(0,4));  
//    alert(xDay+"/"+xMonth+"/"+xYear+" :: "+yDay+"/"+yMonth+"/"+xYear); 
    
    if (xYear> yYear)  
    {  
        return(true)  
    }  
    else  
    {  
      if (xYear == yYear)  
      {   
        if (xMonth> yMonth)  
        {  
            return(true)  
        }  
        else  
        {   
          if (xMonth == yMonth)  
          {  
            if (xDay> yDay)  
              return(true);  
            else  
              return(false);  
          }  
          else  
            return(false);  
        }  
      }  
      else  
        return(false);  
    }  
}  

function getFecha(fecha, o)  {  
    var anio  = fecha.substr(0, 4);  
    var mes   = fecha.substr(5, 2);  
    var dia   = fecha.substr(8,2);  

    var hora  = fecha.substr(11,2);  
    var minu  = fecha.substr(14,2);  
    var segu  = fecha.substr(17,2);  
    switch(o){
	    default:
    			return anio+"-"+mes+"-"+dia;
			break;
    }
}  

Number.prototype.pad = function(size){
	if(typeof(size) !== "number"){size = 2;}
     var s = String(this);
     while (s.length < size) s = "0" + s;
	return s;
}


function zeroPadl(num, places) {
	var zero = places - num.toString().length + 1;
	return Array(+(zero > 0 && zero)).join("0") + num;
}

function obtenerMontoDeConsumoDelContrato(idcontrato,obVenta,obCortesia,obConveni,obInterno){
	$.getJSON(och.getValue(0)+"getSR/?o=0&term="+idcontrato+"&t=3&s=contratos|idcontrato|concat(total_venta,',',total_cortesia,',',total_convenio,',',total_interno)",
		function(json){
			if (json.length<=0) {return false;}
			var ar = json[0].value.split(',');
			obVenta.text(ar[0]).formatCurrency({symbol:''});
			obCortesia.text(ar[1]).formatCurrency({symbol:''});
			obConveni.text(ar[2]).formatCurrency({symbol:''});
			obInterno.text(ar[3]).formatCurrency({symbol:''});
	});
	return true;
}

function getPaginacion(id,oTable,oField, oPag){
	$.getJSON(och.getValue(0)+"getSR/?o=0&term="+id+"&t=3&s="+oTable+"|"+oField+"|count("+oField+")",
		function(json){
			if (json.length<=0) {return false;}
			//alert ("id:"+json[0].id+" value:"+json[0].value);
			     var div = parseInt(parseInt(json[0].value)/oPag.CantidadPagina,0);
				var mod = parseInt(json[0].value)%oPag.CantidadPagina
				oPag.totalPaginas = mod!=0?div+1:div;
				
				sayPintaPaginacion(oPag);
				
			//$("#totalPaginas").text(oPag.totalPaginas);
	});
	return true;
}

function getPag2(id,oTable,oField, oPag, tipo,iduser,iddep){
//	alert("iduser=>"+iduser+"; iddep=>"+iddep+"   ::: "+oTable+"|"+oField+"|count("+oField+")"+"|"+iduser+"|"+iddep );
	$.getJSON(och.getValue(0)+"getSR/?o=0&term="+id+"&t="+tipo+"&s="+oTable+"|"+oField+"|count("+oField+")"+"|"+iduser+"|"+iddep,
		function(json){
///			     alert(json[0].msg);
			if (json.length<=0) {return false;}
//			     alert(json[0].value);
			     var div = parseInt(parseInt(json[0].value)/oPag.CantidadPagina,0);
				var mod = parseInt(json[0].value)%oPag.CantidadPagina
				oPag.totalPaginas = mod!=0?div+1:div;
				sayPintaPaginacion(oPag);
				
	});
	return true;
}

function getPag3(total){
	var div = parseInt(parseInt(total)/oPag.CantidadPagina,0);
	var mod = parseInt(total)%oPag.CantidadPagina
	oPag.totalPaginas = mod!=0?div+1:div;
	sayPintaPaginacion(oPag);
}


function getItemFac(index){
	var expreg = "^\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?$";
	var s = '<tr id="tr'+index+'">\n';
		s += '<td><Select id="row.'+index+'" name="row.'+index+'" class="listaContratoDetalles" size=1 > </select></td>\n';
		s += '<td><input id="producto.'+index+'" name="producto_'+index+'" type="text" class="inw200" /> </td>\n';
		s += '<td><input id="med.'+index+'" name="med_'+index+'" type="text" class="inw100" /> </td>\n';
		s += '<td><input type="text" name="cantidad_'+index+'" id="cantidad.'+index+'" pattern="'+expreg+'" required  class="inw50 fcant money"  /></td>\n';
		s += '<td><input type="text" name="precio_unitario_'+index+'" id="precio_unitario.'+index+'" pattern="'+expreg+'" required  class="inw80 fpu money"  /></td>\n';
		s += '<td><input type="text" name="importe_'+index+'" id="importe.'+index+'" maxlength="10" pattern="\d+(\.\d{2})?" readonly  class="inw80 imp money" />';
		s += '<input type="hidden" id="idcontratodetalles.'+index+'" name="idcontratodetalles_'+index+'" value="0" />';
		s += '<input type="hidden" id="idproducto.'+index+'" name="idproducto_'+index+'" value="0" />';
		s += '<input type="hidden" id="idfactura.'+index+'" name="idfactura_'+index+'" value="0" />';
		s += '<input type="hidden" id="idfacdet.'+index+'" name="idfacdet_'+index+'" value="0" />';
		s += '</td>\n';
	s += '</tr>\n';
	//alert("hola");
return s;
}

function getCallItemFac(index,item){
	var expreg = "^\\$?(([1-9](\\d*|\\d{0,2}(,\\d{3})*))|0)(\\.\\d{1,2})?$";
	var s = '<tr id="tr'+index+'">\n';
		s += '<td><Select id="row.'+index+'" name="row.'+index+'" class="listaContratoDetalles" size=1  > </select></td>\n';
		s += '<td><input id="producto.'+index+'" name="producto_'+index+'" type="text" class="inw200" value="'+item.desc_prod+'" /> </td>\n';
		s += '<td><input id="med.'+index+'" name="med_'+index+'" type="text" class="inw100" value="'+item.desc_medida+'" /> </td>\n';
		s += '<td><input type="text" name="cantidad_'+index+'" id="cantidad.'+index+'" pattern="'+expreg+'" required  class="inw50 fcant money" value="'+item.cantidad+'" alt="'+item.cantidad+'"  /></td>\n';
		s += '<td><input type="text" name="precio_unitario_'+index+'" id="precio_unitario.'+index+'" pattern="'+expreg+'" required  class="inw80 fpu money" value="'+item.precio_venta+'" alt="'+item.precio_venta+'"/></td>\n';
		s += '<td><input type="text" name="importe_'+index+'" id="importe.'+index+'" maxlength="10" pattern="\d+(\.\d{2})?" readonly  class="inw80 imp money" value="'+item.importe+'" alt="'+item.importe+'" />';
		s += '<input type="hidden" id="idcontratodetalles.'+index+'" name="idcontratodetalles_'+index+'" value="'+item.idcontratodetalles+'" />';
		s += '<input type="hidden" id="idproducto.'+index+'" name="idproducto_'+index+'" value="'+item.idproducto+'" />';
		s += '<input type="hidden" id="idfactura.'+index+'" name="idfactura_'+index+'" value="'+item.idfactura+'"/>';
		s += '<input type="hidden" id="idfacdet.'+index+'" name="idfacdet_'+index+'" value="'+item.idfacdet+'" />';
		s += '</td>\n';
	s += '</tr>\n';
return s;
}

function PlaySound(soundObj) {
  var sound = document.getElementById(soundObj);
  sound.Play();
}

