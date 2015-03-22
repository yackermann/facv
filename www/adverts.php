<?php
	// // UNCOMMENT FOR DEBUG
	// error_reporting(E_ALL); 
	// ini_set( 'display_errors','1');

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
		include 'includes/validate.php';

		$IP = new IP();

		$ValidatePOST = new Validate\POST();
		$ValidateRESP = $ValidatePOST -> advert();

		if( $ValidateRESP['valid'] ){

			//Set gets response
			if($SQLGet -> ip($IP -> get()) < $maxRequestPerDay){
				
				//Add ip to DB
				$SQLAdd -> ip($IP -> get());

				//Add advert to DB
				$responce = $SQLAdd -> advert();


				if($responce['status'] !== 418){
					$responce['advert'] = $SQLGet -> advert($responce['id'])[0];
				}

				echo json_encode( $responce );
				
			}else{

				echo json_encode( array( 'status' => 418, 'errorMessage' => 'You have reached maximum of your advert per day' ) );

			}

		}else{
			echo json_encode( array( 'status' => 418, 'errorMessage' => $ValidateRESP['messages'] ) );
		}
	}
?>