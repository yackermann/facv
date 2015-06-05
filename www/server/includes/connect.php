<?php
    mb_internal_encoding("UTF-8");
    try{
        $pdo = new PDO(
            'mysql:host=localhost;dbname=facv', 
            'root', 
            'root',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
        );

    }catch (PDOException $e){

        echo json_encode( array( 'status' => 503, 'errorMessage' => $e ) );
        exit;   

    }
?>
