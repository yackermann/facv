<?php
	include 'includes/connect.php';
	class SQLRequests{
		private $sqlr = array(
			'adverts' => 'SELECT id, title, text, startDate, endDate, categoryId, image, email, phone FROM adverts',
			'categories' => 'SELECT id, loc_ru, loc_ua, loc_en FROM categories',
			'users' => 'SELECT id, login, password, role, name, dob, email, number FROM users',
		);

		private function makeSQL($request=''){
			if($request !== ''){

				//Making PDO SQL request
				global $pdo;
				$stmt = $pdo->prepare($this -> sqlr[$request]);
				$stmt->execute();

				//Temp array
				$temp = array();

				if($stmt -> rowCount() > 0){ //check if more than 0 record found
						
						//retrieve our table contents
						//fetch() is faster than fetchAll()
						//http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
						while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
							array_push($temp, $row);
						}
						return $temp;
				}else{
					echo 'empty sql answer';
					return array();
				}

			}else{
				echo 'empty request';
				return array();
			}
		}
			
		public function getCategories(){
			$categories  = $this -> makeSQL('categories');
			return $categories;
			// foreach ($categories as $cat) {
			// 	echo var_dump($cat).'<br/>';
			// }
		}

		public function getAdverts(){
			$advert  = $this -> makeSQL('adverts');
			return $advert;
		}
	}

?>