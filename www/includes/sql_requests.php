<?php
	$sqlr = [
		"adverts" => 'SELECT id, title, text, startDate, endDate, category, image, email, phone FROM adverts',
		"categories" => 'SELECT id, name FROM categories',
		"users" => 'SELECT id, login, password, role, name, dob, email, number FROM users',
	];
?>