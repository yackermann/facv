<?php
	namespace Upload;
	class Upload{
		private $allowed_types = array("image/gif", "image/jpg", "image/jpeg", "image/png", "image/bmp");
		public function upload($value='')
		{
			if(is_uploaded_file($_FILES["filename"]["tmp_name"])){

				if(in_array($_FILES['filename']['type'], $this -> allowed_types)){ //need to check, maybe i missed some formats
					$_FILES["filename"]["name"] = md5($_FILES["filename"]["name"].time());
					move_uploaded_file($_FILES["filename"]["tmp_name"], ".\\uploads".$_FILES["filename"]["name"].'.jpg');
				}else{
					echo("Sorry but we need image");
				}

			}else{
				echo("Error");
			}
		}
		
	}
	
?>