<?php
	// //Include for DEBUG
	// error_reporting(E_ALL); 
	// ini_set( 'display_errors','1');
	
	include __DIR__.'/../includes/auth.php';

	header('Content-Type: text');

	$cryp = new Auth\Crypto();

	$creds = array(
		'username' => "test",
		'password' => "id10t",
		'challenge' => $cryp -> salt()
	);

	$response = $cryp -> blowfish( $cryp -> H( $creds['password'], $creds['challenge'] ) );

	echo 'Responce(TEST ONLY): '. $cryp ->H( $creds['password'], $creds['challenge'] )."\n";
	echo "INSERT INTO `facv`.`users` (`id`, `hash`, `username`, `challenge`) VALUES (NULL, '" . $response . "', '" . $creds['username'] . "', '" . $creds['challenge'] . "');";
?>