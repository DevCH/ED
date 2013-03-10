// JavaScript Document

/* environment */

delete localStorage.Catalogos;
if (!localStorage.Catalogos){	
	$.post(och.getValue(0)+"getSL/", {  },
 		function(json){
		localStorage.Catalogos = JSON.stringify(json);
		och.cat = JSON.parse(localStorage.Catalogos);
 	}, "json");
}else{
	och.cat = JSON.parse(localStorage.Catalogos);
}
