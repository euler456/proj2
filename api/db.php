<?php

    class sqsModel {

        private $dbconn;

        public function __construct() {
           
            $dbURI = 'mysql:host=' . 'localhost' . ';port=3307;dbname=' . 'proj2';
            $this->dbconn = new PDO($dbURI, 'root', '');
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        function checkLogin($u, $p) {
            // Return uid if user/password tendered are correct otherwise 0
            $sql = "SELECT * FROM customer WHERE username = :username";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':username', $u, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $retVal = $stmt->fetch(PDO::FETCH_ASSOC);
                if(strlen($retVal['password']) > 0) {
                    if($retVal['password'] == $p) { // encrypt & decrypt
                        return Array(
                            'username'=>$retVal['username'],
                            'password'=>$retVal['password'],
                            'customerID'=>$retVal['customerID'],
                                   'email'=>$retVal['email'],
                                  'Firstname'=>$retVal['Firstname'],
                                   'Lastname'=>$retVal['Lastname'],
                                  'phone'=>$retVal['phone'],
                                  'postcode'=>$retVal['postcode']
                                
                                );
                    } else {
                        return false;
                    }
                } else {
                    return Array('username'=>$retVal['username']);
                }
            } else {
                return false;
            }
        }
        function userExists($u) {
            $sql = "SELECT * FROM customer WHERE username = :username";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':username', $u, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        function registerUser($username, $email, $Firstname, $Lastname,$password,$phone,$postcode) {
            // Retister user into system, assume validation has happened.
            // return UID created or false if fail
            $sql = "INSERT INTO customer  (username, email, Firstname, Lastname, password, phone, postcode) VALUES (':username', ':postcode', ':phone', ':password', ':Lastname',':Firstname',  ':username')";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':Firstname', $Firstname, PDO::PARAM_STR);
            $stmt->bindParam(':Lastname', $Lastname, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone, PDO::PARAM_INT);
            $stmt->bindParam(':postcode', $postcode, PDO::PARAM_INT);
            $result = $stmt->execute();
            if($result === true) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
