<?php
    namespace SQLRequests;

    require __DIR__.'/connect.php';

    //Gets PDO class from Global namespace
    use \PDO as PDO;

    class Get{
        //List of SQL requests
        private $sqlr = array(
            'advert'  => 'SELECT id, title, text, startDate, endDate, categoryId, image, email, phone FROM adverts WHERE id = :sp LIMIT 0,1',
            'adverts' => 'SELECT id, title, text, startDate, endDate, categoryId, image, email, phone FROM adverts WHERE endDate > CURDATE()',
            'categories' => 'SELECT id, loc_ru FROM categories',
            'cred' => 'SELECT username, hash, challenge FROM users WHERE username = :sp',
            'ip' => 'SELECT COUNT(*) FROM ips WHERE ip = :sp AND timestamp > (NOW() - INTERVAL 1 DAY)'
        );

        private function execSQL($request='', $secondParam=''){
            try{

                if($request !== ''){

                    //Connect $pdo variable from connect.php
                    global $pdo;

                    //Making PDO SQL request

                    $stmt = $pdo -> prepare($this -> sqlr[$request]);

                    if($secondParam !== ''){ 
                        // $getID = intval($getID);
                        $stmt -> bindParam( ':sp', $secondParam, PDO::PARAM_STR ); 
                    }

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
                        // return array('status' => 404, 'errorMessage' => 'No `'.$request.'` were found.');
                        return array();
                    }

                }else{
                    //Return empty array
                    // return array('status' => 418, 'errorMessage' => 'No SQL were provided.');
                    return array();
                }

            }catch(PDOException $exception){ //to handle error
                return array('status' => 500, 'errorMessage' => $exception);
            }

        }
            
        public function categories(){
            return $this -> execSQL('categories');
        }

        public function adverts(){
            return $this -> execSQL('adverts');
        }

        public function advert($id){
            return $this -> execSQL('advert', $id);
        }

        public function ip($ip){
            return $this -> execSQL('ip', $ip)[0]["COUNT(*)"];
        }

        public function cred($username){
            return $this -> execSQL('cred', $username);
        }
    }
    
    class Add{

        private $sqlr = array(
            'advert' => 'INSERT INTO adverts SET title = :title,  text = :text,  endDate = :endDate,  categoryId = :categoryId,  email = :email,  phone = :phone, startDate = :startDate',
            'ip' => 'INSERT INTO ips SET ip = :ip',
            'user' => 'INSERT INTO users SET username = :username, hash = :hash, challenge = :challenge'
        );

        public function advert(){
            try{
                //Connect $pdo variable from connect.php
                global $pdo;

                //Making PDO SQL request
                $stmt = $pdo -> prepare($this -> sqlr['advert']);
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
                
                return array('status' => 200, 'id' => $pdo -> lastInsertId());

            }catch(PDOException $exception){ //to handle error
                return array('status' => 500, 'errorMessage' => $exception);
            }
        }

        public function ip($ip){
            try{

                //Connect $pdo variable from connect.php
                global $pdo;

                //Making PDO SQL request
                $stmt = $pdo -> prepare($this -> sqlr['ip']);

                $stmt -> bindParam( ':ip', $ip, PDO::PARAM_STR );

                $stmt -> execute();

            }catch(PDOException $exception){ //to handle error
                return array('status' => 500, 'errorMessage' => $exception);
            }
                
        }

        public function user($username, $hash, $challenge){
            try{
                //Connect $pdo variable from connect.php
                global $pdo;

                //Making PDO SQL request
                $stmt = $pdo -> prepare($this -> sqlr['user']);

                /*---------- PDO BIND PARAMS ----------*/
                $stmt -> bindParam( ':username', $username, PDO::PARAM_STR );
                $stmt -> bindParam( ':hash', $hash, PDO::PARAM_STR );
                $stmt -> bindParam( ':challenge', $challenge, PDO::PARAM_STR );
                /*-------- PDO BIND PARAMS ENDS --------*/

                $stmt -> execute();
                
                return array('status' => 200);

            }catch(PDOException $exception){ //to handle error
                return array('status' => 500, 'errorMessage' => $exception);
            }
        }
    }

    class Delete{
         private $sqlr = array(
            'advert' => 'DELETE FROM adverts WHERE id  = :id',
            'user' => ''
        );

        public function user($id){
        }

        public function advert($id){
        }

    }

?>