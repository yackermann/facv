<?php
    include __DIR__.'/includes/sql_requests.php';
    
    //Starts session
    session_start();

    header('Content-Type: application/json');
    // if( isset( $_SESSION['logged'] ) && $_SESSION['logged']){
    //     if($_POST && isset($_POST['method'])){

    //         if($_POST['method'] === 'get'){

    //         }else if( in_array($_POST['method'], ['add', 'update']) ){

    //             if( $ValidateRESP['valid'] ){

    //                 if( $_POST['method'] === 'add' ){

    //                 }else if( $_POST['method'] === 'update' ){

    //                 }

    //             }else{
    //                 echo json_encode( array( 'status' => 412, 'errorMessage' => $ValidateRESP['messages'] ) );
    //             }

    //         }else if($_POST['method'] === 'delete'){
    //         }

    //     }
    // }else{
    //     echo json_encode( array('status' => 401, 'errorMessage' => 'Unauthorized' ) );
    // }
    echo json_encode( array('status' => 501, 'errorMessage' => 'Not Implemented' ) );

?>
