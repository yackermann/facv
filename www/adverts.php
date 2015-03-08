<?php

	

	//include database connection
	include 'includes/connect.php';
	include 'includes/sql_requests.php';

	$stmt = $pdo->prepare( $sqlr["adverts"] );
	$stmt->execute();

	$num = $stmt->rowCount();


	$content = array();
	if($num>0){ //check if more than 0 record found
		
		//retrieve our table contents
		//fetch() is faster than fetchAll()
		//http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

			//extract row
			//this will make $row['firstname'] to
			//just $firstname only
			extract($row);

			$item = array(
				'id' => $id,
				'title' => $title,
				'text' => $text,
				'startDate' => $startDate,
				'endDate' => $endDate,
				'category' => $category,
				'image' => $image,
				'email' => $email,
				'phone' => $phone
			);
			array_push($content, $item);

		}
	
		header('Content-Type: application/json');
		echo json_encode($content);
	}else{ //if no records found
		echo "No records found.";
	}
	
?>