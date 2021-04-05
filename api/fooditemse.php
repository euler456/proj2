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
            public function addfood($foodname,$price, $description,$options,$image) {
                global $sqsdb;
                    if($sqsdb->addfooditem($foodname,$price,$description,$options,$image)) {
                        return true;
                    } else {
                        return false;
                    }
                }

            
            // call the dbobject for SQL
        
       
        public function validate($type, $dirty_string) {
        }
        public function logEvent() {
        }
    }
?>
