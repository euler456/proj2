<?php
 class sqsfood {

    private $dbconn;

    public function __construct() {
//            $dbURI = 'mysql:host=' .$_ENV['HOST'] . ';port=3306;dbname='.$_ENV['DBASE'];
//            $this->dbconn = new PDO($dbURI, $_ENV['USER'], $_ENV['PASS']);

        $dbURI = 'mysql:host=' . 'localhost'.';port=3307;dbname=' . 'proj2';
        $this->dbconn = new PDO($dbURI, 'root', '');
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function displayfood(){
        /*$dbhost = 'localhost:3307';
        $dbuser = 'root';
        $dbpass = '';
        $db     = 'proj2';*/

        $sql = "SELECT * FROM food";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        //$conn  = mysqli_connect($dbhost,$dbuser,'',$db);
        $result = $stmt->fetchAll();
        //$sql=mysqli_query($conn,"SELECT * FROM food");
        //$result=mysqli_fetch_all($sql,MYSQLI_ASSOC);

exit(json_encode($result));
      
    }
    function addfooditem($foodname, $Price, $description, $imagespath, $options) {
        // Retister user into system, assume validation has happened.
        // return UID created or false if fail
//            $sql = "UPDATE customer SET Username = :Username, Pass = :Pass, Email = :Email, Phone = :Phone=1 WHERE CustomerID = :CustomerID";

//            $lastCustID = $this->dbconn->lastInsertID();

//            $sql = "INSERT INTO customer(CustomerID,Username,Pass,Email,Phone)  VALUES (:CustomerID,:Username,:Pass,:Email, :Phone)";
        $sql = "INSERT INTO food (name,Price,description, imagespath,options)  VALUES (:foodname,:Price,:description, :imagespath,:options);";
        $stmt = $this->dbconn->prepare($sql);
//            $stmt->bindParam(':CustomerID', $lastCustID, PDO::PARAM_INT);
        $stmt->bindParam(':foodname', $foodname, PDO::PARAM_STR);
        $stmt->bindParam(':Price', $Price, PDO::PARAM_INT);    
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':imagespath', $imagespath, PDO::PARAM_STR);      
        $stmt->bindParam(':options', $options, PDO::PARAM_STR);  
        $result = $stmt->execute();
        if($result === true) {
            return true;
        } else {
            return false;
        }
    }


}

  
?>
