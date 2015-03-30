<?php
    namespace Auth;

    include __DIR__.'/sql_requests.php';
    include __DIR__.'/ip.php';

    use \PDO as PDO;

    class Crypto{
        public function salt($bytes=22){
            return bin2hex(openssl_random_pseudo_bytes($bytes)); 
        }

        public function blowfish($pass=''){
            return crypt($pass, "$2a$12$".$this -> salt(22));
        }

        public function H(){
            $acc = '';
            foreach (func_get_args() as $n) {
                $acc = $acc . (string)$n;
            }
            return hash('sha512', $acc);
        }
    }

    class Auth{
        private $crypto;
        private $ip;
        private $SQLGet;
        private $SQLAdd;
        private $username;
        private $u;

        public function __construct($username){
            $this -> crypto    =    new Crypto();
            $this -> ip        =    new \IP();
            $this -> SQLGet    =    new \SQLRequests\Get();
            $this -> SQLAdd    =    new \SQLRequests\Add();
            $this -> username  =    $username;

            $this -> u = $this -> SQLGet -> cred($username);
            if( !empty( $this -> u ) ){
                $this -> u = $this -> u[0];
            }
        }

        public function authorize($response){
            if( !empty( $this -> u ) ){
                if(crypt($response, $this -> u['hash']) === $this -> u['hash']){
                    return TRUE;
                }
                return FALSE;
            }
            return FALSE;
        }

        public function exist(){
            if( !empty( $this -> u )) return true;
        }

        public function challenge(){
            if( !empty( $this -> u )){
                return $this -> u['challenge'];
            }else{
                return $this -> genFake();
            }
        }

        public function genFake(){
            return substr($this -> crypto -> H(date('Y'), $this -> username, 'fake'), 0, 44);
        }

        public function register(){

        }
    }
?>