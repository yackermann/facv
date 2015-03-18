<?php
	// UNCOMMENT FOR DEBUG
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');

	//Set header to JSON
	header('Content-Type: application/json');
	$maxRequestPerDay = 5;
	//Add SQL methods
	include 'includes/sql_requests.php';

	/* Initializing new SQLGet and SQLSet objects. */
	$SQLGet = new SQLRequests\Get();
	$SQLAdd = new SQLRequests\Add();

	if (!$_POST) { //IF GET
		

		//Getting info
		$content = array(
			'status' 	 =>  '',
			'categories' =>  $SQLGet -> categories(),
			'adverts' 	 =>  $SQLGet -> adverts()
		);

		//Returning JSON
		echo json_encode($content);

	}else{ 
	//IF POST
		include 'includes/ip.php';

		$IP = new IP();

		//Set gets response
		if($SQLGet -> ip($IP -> get()) < $maxRequestPerDay){

			$SQLAdd -> ip($IP -> get());

			$responce = $SQLAdd -> advert();


			if($responce['status'] !== 418){
				$responce['advert'] = $SQLGet -> advert($responce['id'])[0];
			}

			echo json_encode($responce);
			
		}else{
			echo json_encode(array('status' => 418, 'errorMessage' => 'You have reached maximum of your advert per day'));
		}
	}
?>