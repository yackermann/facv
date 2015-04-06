<?php
    namespace Upload;
    class Upload{
        private function getImageMimeType($imagedata){

            function getBytesFromHexString($hexdata){
                for($count = 0; $count < strlen($hexdata); $count+=2)
                    $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

                return implode($bytes);
            }

            $imagemimetypes = array( 
                "jpg" => "FFD8", 
                "png" => "89504E470D0A1A0A", 
                "gif" => "474946",
                "bmp" => "424D", 
                "tiff" => "4949",
                "tiff" => "4D4D"
            );

            foreach ($imagemimetypes as $mime => $hexbytes){
                $bytes = getBytesFromHexString($hexbytes);
                if (substr($imagedata, 0, strlen($bytes)) == $bytes)
                    return $mime;
            }
            return NULL;
        }

        private function base64_to_img($base64_string) {
            $data = base64_decode(explode(',', $base64_string)[1]);
            $ext = $this -> getImageMimeType($data);
            if($ext){
                try {
                    $filename = md5($base64_string.time()).'.'.$ext;
                    $output_file = $_SERVER['DOCUMENT_ROOT'].'/server/uploads/'.$filename;

                    $ifp = fopen( $output_file, "wb" ); 
                    fwrite( $ifp, $data ); 
                    fclose( $ifp ); 
                    return $filename; 
                } catch (Exception $e) {
                    return NULL;
                }
            }
            return NULL;
        }
        
        public function upload($image){
            return $this -> base64_to_img($image);
        }
    }
    
?>