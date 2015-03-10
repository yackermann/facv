<?php
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
	if($_FILES['filename']['type'] == "image/gif" 
		|| $_FILES['filename']['type'] == "image/jpg" 
		|| $_FILES['filename']['type'] == "image/jpeg" 
		|| $_FILES['filename']['type'] == "image/png" 
		|| $_FILES['filename']['type'] == "image/bmp" ) //need to check, maybe i missed some formats
	{
		$_FILES["filename"]["name"] = md5($_FILES["filename"]["name"]);
     		move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"]);
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
?>