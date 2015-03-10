<?php
<<<<<<< Updated upstream
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
	if($_FILES['filename']['type'] == "image/gif" 
		|| $_FILES['filename']['type'] == "image/jpg" 
		|| $_FILES['filename']['type'] == "image/jpeg" 
		|| $_FILES['filename']['type'] == "image/png" 
		|| $_FILES['filename']['type'] == "image/bmp" ) //need to check, maybe i missed some formats
	{
		$_FILES["filename"]["name"] = md5($_FILES["filename"]["name"]);
     		move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"].'.jpg');
	}
	else
	{
		echo("Sorry but we need image");
	}
   } 
   else 
   {
      echo("Error");
   }
=======
	if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
		$_FILES["filename"]["name"] = "1";
	  	move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"]);
	}else{
		echo("Error");
	}
>>>>>>> Stashed changes
?>