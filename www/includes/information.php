<?php 
//generate a random number from 1 to 3
$random=rand(1,3);
//query the information table using the random number chosen
$information_sql="SELECT * FROM information WHERE id = ".$random;
$result = $pdo->query($information_sql);
	//if we get a result set display the heading and data
	if($result !== false) {
    
   		// Parse the result set
    	foreach($result as $row) {
      		echo '<h2>'.$row['heading'].'</h2>'.'<br />'. $row['text'];
    	}	
 	}
?>