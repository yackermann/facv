<?php
	$allowed_types = array("image/gif", "image/jpg", "image/jpeg", "image/png", "image/bmp");

	if(is_uploaded_file($_FILES["filename"]["tmp_name"])){

		if(in_array($_FILES['filename']['type'], $allowed_types)){ //need to check, maybe i missed some formats

			$_FILES["filename"]["name"] = md5($_FILES["filename"]["name"].time());
		  	move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"].'.jpg');
	
		}else{
			echo("Sorry but we need image");
		}
	}else{
		echo("Error");
	}
?>