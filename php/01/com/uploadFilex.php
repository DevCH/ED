<?php
/*
$allowedExts = array("jpg", "jpeg", "gif", "png","JPG", "JPEG", "GIF", "PNG");
$extension = end(explode(".", $_FILES["file"]["name"]));
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/jpg"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("../docs/filex/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../docs/filex/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "../docs/filex/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file ". $_FILES["file"]["name"];
  }
*/

/*
$uploaddir = '../docs/filex/'; 
$uploadfile = $uploaddir . basename($_FILES['images']['name']);

if (move_uploaded_file($_FILES['images']['tmp_name'], $uploadfile)) {
  echo "success";
} else {
  echo "error".basename($_FILES['images']['name']);
}
  
*/
require_once("../oCentura.php");
$f = oCentura::getInstance();

$oculto = $_POST['oculto'];
$iduser = $_POST['idu'];
    foreach($_FILES['file']['error'] as $key => $error){
        if($error == UPLOAD_ERR_OK){
		   	$allowedExts = array("jpg", "jpeg", "gif", "png","JPG", "JPEG", "GIF", "PNG");
		   	$extension = end(explode(".", $_FILES["file"]["name"][$key]));
		   	//echo $_FILES["file"]["type"][$key];
		   	//echo $_FILES["file"]["size"][$key];
		   	//echo  $extension;

			if ((($_FILES["file"]["type"][$key] == "image/gif")
				|| ($_FILES["file"]["type"][$key] == "image/jpeg")
				|| ($_FILES["file"]["type"][$key] == "image/png")
				|| ($_FILES["file"]["type"][$key] == "image/pjpeg")
				|| ($_FILES["file"]["type"][$key] == "image/jpg"))
				&& ($_FILES["file"]["size"][$key] < 2000000)
				&& in_array($extension, $allowedExts)){
		            	$name = $_FILES['file']['name'][$key];
          		  	move_uploaded_file($_FILES['file']['tmp_name'][$key], '../docs/filex/' . $name);
    		  			echo "<h2>". $_FILES["file"]["name"][$key]." subido correctamente</h2> ";
					$f->setSaveData(40,$iduser."|".$oculto."|".$name,0,0,4);
	   		}else{
    				echo "<h2>". $_FILES["file"]["name"][$key]." no válido</h2> ";
	   
	   		}
	   
        }
    }
    
   // echo "<h2>Archivos correctamente subidos</h2>";
?>