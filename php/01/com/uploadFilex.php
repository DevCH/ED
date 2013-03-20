<?php
require_once("../oCentura.php");
$f = oCentura::getInstance();

$oculto   = $_POST['oculto'];
$iduser   = $_POST['idu'];
$typeFoto = $_POST['tfoto'];

    foreach($_FILES['file']['error'] as $key => $error){
        if($error == UPLOAD_ERR_OK){
		   	$allowedExts = array("jpg", "jpeg", "gif", "png","JPG", "JPEG", "GIF", "PNG");
		   	$extension = end(explode(".", $_FILES["file"]["name"][$key]));

			if ((($_FILES["file"]["type"][$key] == "image/gif")
				|| ($_FILES["file"]["type"][$key] == "image/jpeg")
				|| ($_FILES["file"]["type"][$key] == "image/png")
				|| ($_FILES["file"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["file"]["type"][$key] == "image/jpg"))
				&& ($_FILES["file"]["size"][$key] < 2000000)
				&& in_array($extension, $allowedExts)){
		            	$name      = $_FILES['file']['name'][$key];
		            	$filename  = $_FILES['file']['name'][$key];
					$ext       = explode(".", $_FILES["file"]["name"][$key]);
		            	$namer     = $ext[0]."_r_.".$ext[1];
					
          		  	move_uploaded_file($_FILES['file']['tmp_name'][$key], '../docs/filex/' . $name);

                      	$filename  ='http://ed.tabascoweb.com/php/01/docs/filex/'. $name;
			   	  	$gds = imagecreatefromjpeg($filename);
			   	  	$gdd = imagecreatetruecolor(71, 80);
			   	  	$dest = '../docs/filex/'.$namer; 
				  	$arImg = array();//GetImageSize($img);
				  
					list($width, $height) = getimagesize($filename);
					$arImg[0] = $width ;
					$arImg[1] = $height ;
				  
			   	  	imagecopyresampled($gdd, $gds, 0, 0, 0, 0, 71, 80, $arImg[0], $arImg[1]); 
			   	  	imagejpeg($gdd, $dest);
			   	  	imagedestroy($gds);
			   	  	imagedestroy($gdd);
					
    		  			echo "<h2>". $_FILES["file"]["name"][$key]." subido correctamente</h2> ";
					$f->setSaveData(40,$iduser."|".$oculto."|".$namer,0,intval($typeFoto),4);
	   		}else{
    				echo "<h2>". $_FILES["file"]["name"][$key]." no válido</h2> ";
	   
	   		}
	   
        }
    }
    
   // echo "<h2>Archivos correctamente subidos</h2>";
?>