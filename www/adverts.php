<?php
	// // // UNCOMMENT FOR DEBUG
	// error_reporting(E_ALL); 
	// ini_set( 'display_errors','1');

	//Set header to JSON
	header('Content-Type: application/json');

	//Add SQL methods
	include 'includes/sql_requests.php';

	$SQLGet = new SQLRequests\Get();
	$SQLAdd = new SQLRequests\Add();

	if (!$_POST) {

		//Initialize new SQLRequests object

		//Getting info
		$content = array(
			'status' 	 =>  '',
			'categories' =>  $SQLGet -> categories(),
			'adverts' 	 =>  $SQLGet -> adverts()
		);

		//Returning JSON
		echo json_encode($content);

	}else{
		
		//Set gets response
		$responce = $SQLAdd -> advert();

		if($responce['status'] !== 418){
			$responce['advert'] = $SQLGet -> advert($responce['id'])[0];
		}

		echo json_encode($responce);
	}
?>