<?php
    session_start();
    if( isset( $_SESSION['logged'] ) ){
        if(!$_SESSION['logged']){
            //Redirecting to the root directory.
            header('Location: /');
        }
    }else{
        //Redirecting to the root directory.
        header('Location: /');
    }
?>