<?php
	include 'includes/connect.php';

	class getSQLRequests{
		//List of SQL requests
		private $sqlr = array(
			'adverts' => 'SELECT id, title, text, startDate, endDate, categoryId, image, email, phone FROM adverts WHERE endDate > CURDATE()',
			'categories' => 'SELECT id, loc_ru, loc_ua, loc_en FROM categories',
			'users' => 'SELECT id, login, password, role, name, dob, email, number FROM users'
		);

		private function makeSQL($request=''){
			if($request !== ''){

				//Connect $pdo variable from connect.php
				global $pdo;

				//Making PDO SQL request
				$stmt = $pdo -> prepare($this -> sqlr[$request]);
				$stmt -> execute();

				//Temp array
				$temp = array();

				if($stmt -> rowCount() > 0){ //check if more than 0 record found
						
						//Iterate through the SQL Answer
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							array_push($temp, $row);
						}
						return $temp;
				}else{
					// Return empty array
					return array();
				}

			}else{
				//Return empty array
				return array();
			}
		}
			
		public function getCategories(){
			return $this -> makeSQL('categories');
		}

		public function getAdverts(){
			return $this -> makeSQL('adverts');
		}
	}

	class setSQLRequests{
		//List of SQL requests

		private $sqlr = array(
			'add' => 'INSERT INTO adverts SET title = :title,  text = :text,  endDate = :endDate,  categoryId = :categoryId,  email = :email,  phone = :phone, startDate = :startDate'
		);

		public function newAdvert(){
			try{
		   		//Connect $pdo variable from connect.php
				global $pdo;

				//Making PDO SQL request
				$stmt = $pdo -> prepare($this -> sqlr['add']);
				$now = date('Y-m-d');

				/*---------- PDO BIND PARAMS ----------*/
				$stmt -> bindParam( ':startDate', $now, PDO::PARAM_STR );
				$stmt -> bindParam( ':title', $_POST['title'], PDO::PARAM_STR );
				$stmt -> bindParam( ':text', $_POST['text'], PDO::PARAM_STR );
				$stmt -> bindParam( ':endDate', $_POST['endDate'], PDO::PARAM_STR );
				$stmt -> bindParam( ':categoryId', $_POST['categoryId'], PDO::PARAM_STR );
				$stmt -> bindParam( ':email', $_POST['email'], PDO::PARAM_STR );
				$stmt -> bindParam( ':phone', $_POST['phone'], PDO::PARAM_STR );
				/*-------- PDO BIND PARAMS ENDS --------*/

				$stmt -> execute();
				return array('status' => 200);

			}catch(PDOException $exception){ //to handle error
				return array('status' => 500);
			}
		}
	}
?>