<?php
    // // UNCOMMENT FOR DEBUG
    // error_reporting(E_ALL); 
    // ini_set( 'display_errors','1');

    //Starts session
    session_start();

    //Set header to JSON
    header('Content-Type: application/json');
    
    $maxRequestPerDay = 5;

    //Add SQL methods
    include __DIR__.'/includes/sql_requests.php';

    /* Initializing new SQLGet and SQLSet objects. */
    $SQLGet = new SQLRequests\Get();
    $SQLAdd = new SQLRequests\Add();
    
    if (!$_POST) { //IF GET
        echo json_encode(array( 'status' => 200,'adverts' => $SQLGet -> adverts() ));

    }else{ 
    //IF POST
        include __DIR__.'/includes/ip.php';
        include __DIR__.'/includes/validate.php';
        include __DIR__.'/includes/upload.php';
        
        $upload = new \Upload\Upload();
        $IP = new IP();

        $ValidatePOST = new Validate\POST();
        $ValidateRESP = $ValidatePOST -> advert();

        if( $ValidateRESP['valid'] ){

            //Set gets response
            if($SQLGet -> ip($IP -> get()) < $maxRequestPerDay || ( isset( $_SESSION['logged'] ) && $_SESSION['logged'] ) ){
                
                //Add ip to DB
                $SQLAdd -> ip($IP -> get());

                if(isset($_POST['image']) && $_POST['image'] !== ''){
                    $_POST['imageURL'] = $upload -> upload($_POST['image']);
                }

                $response = $SQLAdd -> advert();

                if($response['status'] === 200){
                    $response['advert'] = $SQLGet -> advert($response['id'])[0];
                }

                echo json_encode( $response );
                
            }else{

                echo json_encode( array( 'status' => 429, 'errorMessage' => 'You have reached maximum of your advert per day' ) );

            }

        }else{
            echo json_encode( array( 'status' => 412, 'errorMessage' => $ValidateRESP['messages'] ) );
        }
    }
?>