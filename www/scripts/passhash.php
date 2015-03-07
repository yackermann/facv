<?php

	$password = "id10t";
	$salt = bin2hex(openssl_random_pseudo_bytes(22)); 
	$challange = "$2a$12$";
	$hash = crypt($password, $challange.$salt);
	echo $hash;
?>