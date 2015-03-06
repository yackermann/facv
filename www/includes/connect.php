<?php
	try
	{
		$pdo = new PDO('mysql:host=localhost;dbname=SALO', 'root', 'root');
	}
	catch (PDOException $e)
	{
		echo 'Unable to connect to the database server.';
		exit;	
	}


?>
