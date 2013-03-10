<!--
<h3>Choose file(s)</h3>
<p>
	<input id="file" name="file"  type="file" multiple>
</p>
<p id="drop-area">
	<span class="drop-instructions">or drag and drop files here</span>
	<span class="drop-over">Drop files here!</span>
</p>

<ul id="file-list">
	<li class="no-items">(no files uploaded yet)</li>
</ul>

-->
<?php
$idreg  = $_POST['idreg'];
$iduser = $_POST['iduser'];
?>
<style>
#lista-imagenes li{ list-style:none;}
</style>

	<div  class="ui-tabs ui-widget ui-widget-content ui-corner-all components-b-area">

            <input type="file" id="file" name="file[]"  class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" multiple><span class="ui-icon ui-icon-image"></span></input>
		  <input type="hidden" id="oculto" name="oculto" value="<?php echo $idreg; ?>" />
		  <input type="hidden" id="iduser" name="iduser" value="<?php echo $iduser; ?>" />
            <button id="btnSubmit">Subir archivo</button>
		  
            <ul id="lista-imagenes" >
                
            </ul>
            <div id="response"></div>

	</div>
	  
  

<!--
<form action="/php/01/com/uploadFilex.php" method="post" enctype="multipart/form-data" name="frmUpload" target="_self" id="frmUpload">
<input name="file" type="file" id="file" dir="ltr" lang="es" size="100">

<input name="send" type="submit" id="send" dir="ltr" lang="es" value="Subir">

</form>
<ul id="file-list">
	<li class="no-items">___</li>
</ul>

-->
<script>
/*
var file = document.getElementById("file");
var li = document.createElement("li"),
			div = document.createElement("div"),
			img,
			progressBarContainer = document.createElement("div"),
			progressBar = document.createElement("div"),
			reader,
			xhr,
			fileInfo;    
  file.addEventListener("change", function () {
	

if (typeof FileReader !== "undefined" && (/image/i).test(file.type)) {
	img = document.createElement("img");
	li.appendChild(img);
	reader = new FileReader();
	reader.onload = (function (theImg) {
		return function (evt) {
			theImg.src = evt.target.result;
		};
	}(img));
	reader.readAsDataURL(file);
}
}, false);   
*/


(function(){
    var input = document.getElementById('file'),
        formdata = false;
	var oculto =    document.getElementById('oculto').value;
    
    function mostrarImagenSubida(source){
        var list = document.getElementById('lista-imagenes'),
            li   = document.createElement('li'),
            img  = document.createElement('img');
        
        img.src = source;
        li.appendChild(img);
        list.appendChild(li);
    }
    
    //Revisamos si el navegador soporta el objeto FormData
    if(window.FormData){
        formdata = new FormData();
        document.getElementById('btnSubmit').style.display = 'none';
    }
    
    //Aplicamos la subida de imágenes al evento change del input file
    if(input.addEventListener){
        input.addEventListener('change', function(evt){
            var i = 0, len = this.files.length, img, reader, file;
            
            document.getElementById('response').innerHTML = 'Subiendo...';
            
            //Si hay varias imágenes, las obtenemos una a una
            for( ; i < len; i++){
                file = this.files[i];
                
                //Una pequeña validación para subir imágenes
                if(!!file.type.match(/image.*/)){
                    //Si el navegador soporta el objeto FileReader
                    if(window.FileReader){
                        reader = new FileReader();
                        //Llamamos a este evento cuando la lectura del archivo es completa
                        //Después agregamos la imagen en una lista
                        reader.onloadend = function(e){
                            mostrarImagenSubida(e.target.result);
                        };
                        //Comienza a leer el archivo
                        //Cuando termina el evento onloadend es llamado
                        reader.readAsDataURL(file);
                    }
                    
                    //Si existe una instancia de FormData
                    if(formdata)
                        //Usamos el método append, cuyos parámetros son:
                            //name : El nombre del campo
                            //value: El valor del campo (puede ser de tipo Blob, File e incluso string)
                        formdata.append('file[]', file);
                        formdata.append('oculto', oculto);
                }
            }
            
            //Por último hacemos uso del método proporcionado por jQuery para hacer la petición ajax
            //Como datos a enviar, el objeto FormData que contiene la información de las imágenes
            if(formdata){
                $.ajax({
                   url : '/upfile/',
                   type : 'POST',
                   data : formdata,
                   processData : false, 
                   contentType : false, 
                   success : function(res){
                       document.getElementById('response').innerHTML = res;
                   }                
                });
            }
        }, false);
    }
}());

</script>
