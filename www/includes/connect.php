<?php
try
{
  $pdo = new PDO('mysql:host=localhost;dbname=dev', 'root', '');
}
catch (PDOException $e)
{
  echo 'Unable to connect to the database server.';
  exit;	
}


?>
