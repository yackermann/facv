<?php
	require __DIR__.'/connect.php';
	try{
		global $pdo;
		$stmt = $pdo -> prepare("DELETE FROM adverts WHERE endDate < CURDATE()");
		$stmt -> execute();
	}catch(PDOException $exception){ //to handle error
	    return array('status' => 500, 'errorMessage' => $exception);
	}
?>