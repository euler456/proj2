<?php

    class sqsSession {
        // attributes will be stored in session, but always test incognito
        private $last_visit = 0;
        private $last_visits = Array();
        private $customerID = 5;
        private $username;
        private $password;
        private $email;
        //private $user_privilege = 0;
        private $Lastname;
        private $phone;
        private $postcode;
        private $user_token;


        private $origin;

        public function __construct() {
            $this->origin = 'http://localhost/';
        }
        public function is_rate_limited() {
            if($this->last_visit == 0) {
                $this->last_visit = time();
                return false;
            }
            if($this->last_visit == time()) {
                return true;
            }
            return false;
        }
        public function login($username, $password) {
            global $sqsdb;

            $res = $sqsdb->checkLogin($username, $password);
            if($res === false) {
                return false;
            } elseif(count($res) > 1) {
                $this->customerID = $res['customerID'];
              //  $this->user_privilege = 1;
                $this->user_token = md5(json_encode($res));
                return Array('username'=>$res['username'],
                'email'=>$res['email'],
                'Firstname'=>$res['Firstname'],
                'Lastname'=>$res['Lastname'],
                'password'=>$res['password'],
                'phone'=>$res['phone'],
                'postcode'=>$res['postcode'],
                'Hash'=>$this->user_token);
            } elseif(count($res) == 1) {
                $this->username = $res['username'];
                $this->user_token = md5(json_encode($res));
                return Array('Hash'=>$this->user_token);
            }
        }
        public function register($username, $email, $Firstname, $Lastname, $password,$phone,$postcode) {
            global $sqsdb;
                if($sqsdb->registerUser($this->$username, $email, $Firstname, $Lastname, $password,$phone,$postcode)) {
                    return true;
                } else {
                    return 0;
                }
    
            // call the dbobject for SQL
        }
        public function isLoggedIn() {
            if($this->customerID === 0) {
                return false;
            } else {
                return Array('Hash'=>$this->user_token);
            }
        }
        public function logout() {
            $this->customerID = 0;
         
        }
        public function validate($type, $dirty_string) {
        }
        public function logEvent() {
        }
    }
?>