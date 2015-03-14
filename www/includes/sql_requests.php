<?php
	include 'includes/connect.php';

	class SQLRequests{
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
					return array();
				}

			}else{
				return array();
			}
		}
			
		public function getCategories(){
			$categories = $this -> makeSQL('categories');
			return $categories;
		}

		public function getAdverts(){
			$advert = $this -> makeSQL('adverts');
			return $advert;
		}
	}
?>