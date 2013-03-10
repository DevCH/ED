
/* 

* Para detener el envio del formulario = Return False

* Para localizar:
- GPS
- Triangulación GSM
- Wifi
- IP


*/

//var socket = io.connect('http://localhost'); 

//var stream = io.connect('http://192.168.254.64:2671');
var url="http://187.157.37.204"
var stream = io.connect('187.157.37.204:8080');


function saludoGlobal(datosServer)
{
	$("h1").html("Chat Genesis 3.0");
		
	var cs1 = datosServer.mensaje.split(":");
	var cs2 = cs1[0].split(" ");
	
	$("ul").append("<li>"+datosServer.mensaje+"</li>");
	//alert(cs2[0]);
	
	if (parseInt(cs2[0])>0){
		 PlaySound("sound0");
	}else{
		 if (cs2[0].substring(0,1)=="p"){
		 	PlaySound("sound0");
		 }else{
		 	PlaySound("sound1");
		 }
	}
	
}

$(document).ready(
	function ()
	{
		//delete localStorage.nombre;
		$("#formulario").bind("submit", guardar);
		//transicion();
		stream.on("servidor", saludoGlobal);   
		    
		
	}
);

function guardar()
{
	var n = $("#nombre").val();
	if (n != ""){
	   localStorage.mensajeChat = n;
	   transicion();
	}else{
		alert("Por favor, escriba algo...");
	}
	return false;
}

function transicion(){
    if(localStorage.mensajeChat){

var n = $("#nombre").val();
		stream.emit("cliente", {mensaje: IdUser+" : "+localStorage.mensajeChat});
		$("#nombre").val("");

		//clicksound.playclip();

    	//var n = $("#nombre").val();
    	//localStorage.nombre = n;
		
		
	//alert("enviado");	
		
   }else{
	//alert("no se enviaron los datos");	
   }
}

var html5_audiotypes={ //define list of audio file extensions and their associated audio types. Add to it if your specified audio file isn't on this list:
	"mp3": "audio/mpeg",
	"mp4": "audio/mp4",
	"ogg": "audio/ogg",
	"wav": "audio/wav"
}

function createsoundbite(sound){
	var html5audio=document.createElement('audio')
	if (html5audio.canPlayType){ //check support for HTML5 audio
		for (var i=0; i<arguments.length; i++){
			var sourceel=document.createElement('source')
			sourceel.setAttribute('src', arguments[i])
			if (arguments[i].match(/\.(\w+)$/i))
				sourceel.setAttribute('type', html5_audiotypes[RegExp.$1])
			html5audio.appendChild(sourceel)
		}
		html5audio.load()
		html5audio.playclip=function(){
			html5audio.pause()
			html5audio.currentTime=0
			html5audio.play()
		}
		return html5audio
	}
	else{
		return {playclip:function(){throw new Error("Your browser doesn't support HTML5 audio unfortunately")}}
	}
}

//Initialize two sound clips with 1 fallback file each:

var mouseoversound=createsoundbite(url+"whistle.ogg", url+"whistle.mp3")
var clicksound=createsoundbite(url+"click.ogg", url+"click.mp3")

function PlaySound(soundObj) {
  var sound = document.getElementById(soundObj);
  sound.Play();
}
