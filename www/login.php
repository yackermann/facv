<?php
	session_start();

	header('Content-Type: application/json');

	if ($_POST){

		require __DIR__.'/includes/auth.php';

		$auth;

		if(isset($_POST['username'])){

			$auth = new \Auth\Auth($_POST['username']);

			$_SESSION['auth'] = serialize($auth);

			echo json_encode(array('challenge' => $auth -> challenge()));

		}else if( isset($_SESSION['auth']) && isset($_POST['response']) ){

			$auth = unserialize($_SESSION['auth']);

			if($auth -> authorize($_POST['response'])){

				echo json_encode(array( 'authorized' => True));

			}else{

				echo json_encode(array( 'authorized' => False));

			}
			
		}
	}
?>