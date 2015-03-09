<?php
   if(is_uploaded_file($_FILES["filename"]["tmp_name"]))
   {
	$_FILES["filename"]["name"] = "1";
     	move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"]);
   } 
   else 
   {
      echo("Error");
   }
?>