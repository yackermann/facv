<?php
    include __DIR__.'/includes/sql_requests.php';
    
    //Starts session
    session_start();

    header('Content-Type: application/json');
    if( isset( $_SESSION['logged'] ) && $_SESSION['logged']){
        if($_POST && isset($_POST['method'])){

            $SQLGet = new SQLRequests\Get();

            if($_POST['method'] === 'get'){

                if(isset($_POST['id']))
                    echo json_encode( $SQLGet -> advert($_POST['id'])[0] );

            }else if( in_array($_POST['method'], ['add', 'update']) ){

                include __DIR__.'/includes/validate.php';
                include __DIR__.'/includes/upload.php';

                $ValidatePOST = new Validate\POST();
                $upload = new \Upload\Upload();
                $ValidateRESP = $ValidatePOST -> advert();

                if( $ValidateRESP['valid'] ){
                    $SQLAdd = new SQLRequests\Add();

                    if( $_POST['method'] === 'add' ){

                        $_POST['imageURL'] = '';
                        if(isset($_POST['image']) && $_POST['image'] !== ''){
                            $_POST['imageURL'] = $upload -> upload($_POST['image']);
                        }

                        $response = $SQLAdd -> advert();

                        if($response['status'] === 200){
                            $response['advert'] = $SQLGet -> advert($response['id'])[0];
                        }

                        echo json_encode( $response );

                    }else if( $_POST['method'] === 'update' ){

                        $SQLUpdate = new SQLRequests\Update();

                        $_POST['imageURL'] = '';
                        if(isset($_POST['image']) && $_POST['image'] !== ''){
                            if( preg_match( '/^[0-9A-Fa-f]+\.[A-Za-z]{3,4}$/' , $_POST['image'] ) ){
                                $_POST['imageURL'] = $_POST['image'];
                            }else{
                                $_POST['imageURL'] = $upload -> upload($_POST['image']);
                            }
                        }

                        $response = $SQLUpdate -> advert();

                        echo json_encode( $response );
                    }

                }else{
                    echo json_encode( array( 'status' => 412, 'errorMessage' => $ValidateRESP['messages'] ) );
                }

            }else if($_POST['method'] === 'delete'){

                $SQLDelete = new SQLRequests\Delete();

                if( isset($_POST['id']) )
                    echo json_encode( $SQLDelete -> advert() );
            }

        }
    }else{
        echo json_encode( array('status' => 401, 'errorMessage' => 'Unauthorized' ) );
    }

?>
