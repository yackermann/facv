<?php
    //Starts session
    session_start();

    header('Content-Type: application/json');

    if( isset( $_SESSION['logged'] ) && $_SESSION['logged']){
        if($_POST && isset($_POST['method'])){
            if( $_POST['method'] === 'exist' ){

                if( isset($_POST['username']) ){
                    include __DIR__.'/includes/auth.php';
                    $e = new \Auth\Exist($_POST['username']);
                    echo json_encode( array( 'exist' => $e -> exist() ) );
                }
                    
            }else if( $_POST['method'] === 'delete' ){
                include __DIR__.'/includes/sql_requests.php';
                $SQLDelete = new SQLRequests\Delete();

                if( isset($_POST['id']) )
                    echo json_encode( $SQLDelete -> user() );

            }else if( $_POST['method'] === 'register' ){

                include __DIR__.'/includes/auth.php';
                $reg;

                if( isset( $_POST['username'] ) ){
                    //Stage one, get challenge
                    //
                    $reg = new \Auth\Reg($_POST['username']);

                    if( $reg -> exist() ){
                        echo json_encode( array('status' => 409, 'errorMessage' => 'User exists.') );
                    }else{

                        echo json_encode( array( 'challenge' => $reg -> challenge() ) );
                        $_SESSION['reg'] = serialize( $reg );
                    }
                    

                }else if( isset($_SESSION['reg']) && isset($_POST['response']) ){ 
                    
                    //Stage two verify the response

                    $reg = unserialize($_SESSION['reg']);

                    $reg -> hash($_POST['response']);
                    echo json_encode( $reg -> register() );
                    
                    unset($_SESSION['reg']);
                    
                }
                
            }

        }

    }else{
        echo json_encode( array('status' => 401, 'errorMessage' => 'Unauthorized' ) );
    }
?>
