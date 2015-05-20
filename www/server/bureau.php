<?php
    require __DIR__.'/includes/session.php';
    include __DIR__.'/includes/sql_requests.php';

    header('Content-Type: application/json');
    
    if($_POST && isset($_POST['method'])){

        $SQLGet = new SQLRequests\Get();
        $SQLAdd = new SQLRequests\Add();

        if($_POST['method'] === 'get'){

            if(isset($_POST['id']))
                echo json_encode( $SQLGet -> advert($_POST['id'])[0] );

        }else if($_POST['method'] === 'add'){
            
            include __DIR__.'/includes/validate.php';
            include __DIR__.'/includes/upload.php';

            $ValidatePOST = new Validate\POST();
            $ValidateRESP = $ValidatePOST -> advert();

            if( $ValidateRESP['valid'] ){
                $image = '';

                if(isset($_POST['image']) && $_POST['image'] !== ''){
                    $image = $upload -> upload($_POST['image']);
                }

                $responce = $SQLAdd -> advert($image);

                if($responce['status'] === 200){
                    $responce['advert'] = $SQLGet -> advert($responce['id'])[0];
                }

                echo json_encode( $responce );

            }else{
                echo json_encode( array( 'status' => 412, 'errorMessage' => $ValidateRESP['messages'] ) );
            }

        }else if($_POST['method'] === 'update'){

        }

    }

?>
