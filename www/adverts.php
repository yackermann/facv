<?php
	// UNCOMMENT FOR DEBUG
	// error_reporting(E_ALL); 
	// ini_set( 'display_errors','1');

	//Set header to JSON
	header('Content-Type: application/json');

	//Add SQL methods
	include 'includes/sql_requests.php';

	if (!$_POST) {

		//Initialize new SQLRequests object
		$SQLReq = new getSQLRequests();

		//Getting info
		$content = array(
			'status' 	 =>  '',
			'categories' =>  $SQLReq -> getCategories(),
			'adverts' 	 =>  $SQLReq -> getAdverts()
		);

		//Returning JSON
		echo json_encode($content);
	}else{
		
		//Initialize new SQLRequests object
		$SQLReq = new setSQLRequests();
		echo json_encode($SQLReq -> newAdvert());
	}
?>