<?php
    mb_internal_encoding("UTF-8");
    try{
        
        $pdo = new PDO(
            'mysql:host=localhost;dbname=salo', 
            'root', 
            'root',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
        );

    }catch (PDOException $e){

        echo 'Unable to connect to the database server.';
        exit;   

    }
?>
