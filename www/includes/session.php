<?php
session_start(); //start a session
//Check to see if the user has logged in
//If they haven't $_Session['id'] will not exist and
//they will be directed back to the login form
if (!isset($_SESSION['id'])){
   
    sleep(2);

    header("Location:login.php");
    exit;
}
?>