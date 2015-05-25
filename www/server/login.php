<?php
	session_start();

	header('Content-Type: application/json');
	if ($_POST){

		require __DIR__.'/includes/auth.php';

		$auth;
		
		sleep(1);

		if(isset($_POST['username'])){
			
			//Stage one, get challenge

			$auth = new \Auth\Auth($_POST['username']);

			$_SESSION['auth'] = serialize($auth);

			echo json_encode(array('challenge' => $auth -> challenge()));

		}else if( isset($_SESSION['auth']) && isset($_POST['response']) ){ 
			
			//Stage two verify the response

			$auth = unserialize($_SESSION['auth']);

			

			if($auth -> authorize($_POST['response'])){

				echo json_encode(array( 'authorized' => True));

				$_SESSION['logged'] =  True;

			}else{

				echo json_encode(array( 'authorized' => False));

			}
			unset($_SESSION['auth']);
			
		}

	}else if($_GET){

		if(isset($_GET['logout'])){

			session_unset();
			header('Location: /');

		}
		
	}else{
		if( $_SESSION['logged'] )
			echo json_encode(array( 'authorized' => True));
		else
			echo json_encode(array( 'authorized' => False));

	}
?>