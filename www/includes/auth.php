<?php
    namespace Auth;

    include 'includes/sql_requests.php';
    include 'includes/ip.php';

    use \PDO as PDO;

    class Crypto{
        public function salt($bytes=22){
            return bin2hex(openssl_random_pseudo_bytes($bytes)); 
        }

        public function hash($pass=''){
            crypt($pass, "$2a$12$".$this -> salt(22));
        }
    }
    class Auth{
        private $crypto = new Crypto();
        private $ip = new \IP();
        private $SQLGet = new \SQLRequests\Get();
        private $SQLAdd = new \SQLRequests\Add();

        public function login($username, $pass){
            $credentials = $this -> SQLGet -> login($username);
            if( !empty( $credentials )){
                if(crypt($pass, $credentials['hash']) === $credentials['hash']){
                    return TRUE;
                }
                return FALSE;
            }
            return FALSE;
        }
        
        public function register(){

        }
    }
?>