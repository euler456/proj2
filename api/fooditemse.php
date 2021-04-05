<?php

    class sqsfoodSession {
        // attributes will be stored in session, but always test incognito
        private $last_visit = 0;
        private $last_visits = Array();
//        private $user_id = 0;
//        private $user_Username;
//        private $user_Email;
//        private $user_Phone;
//        private $user_token;
        private $CustomerID = 0;
        private $username;
        private $email;
        private $phone;
        private $user_token;

//        private $origin;

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
            public function display() {
                global $sqsdb;
                $sqsdb->displayfood();
                return $sqsdb;
            }    
            public function addfood($foodname,$Price, $description, $imagespath,$options) {
                global $sqsdb;
                    if($sqsdb->addfooditem($foodname,$Price, $description, $imagespath,$options)) {
                        return true;
                    } else {
                        return 0;
                    }
                }

            
            // call the dbobject for SQL
        
        public function isLoggedIn() {
            if($this->CustomerID === 0) {
                return false;
            } else {
                return Array('Hash'=>$this->user_token);
            }
        }
        public function logout() {
            $this->CustomerID = 0;
//            $this->user_privilege = 0;
        }
        public function validate($type, $dirty_string) {
        }
        public function logEvent() {
        }
    }
?>
