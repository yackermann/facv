<?php
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
	$_FILES["filename"]["name"] = md5($_FILES["filename"]["name"]);
     	move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"]);
   } 
   else 
   {
      echo("Error");
   }
?>