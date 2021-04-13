<?php
 class sqsorder {

    private $dbconn;

    public function __construct() {
//            $dbURI = 'mysql:host=' .$_ENV['HOST'] . ';port=3306;dbname='.$_ENV['DBASE'];
//            $this->dbconn = new PDO($dbURI, $_ENV['USER'], $_ENV['PASS']);

        $dbURI = 'mysql:host=' . 'localhost'.';port=3307;dbname=' . 'proj2';
        $this->dbconn = new PDO($dbURI, 'root', '');
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function displayorderfood(){
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
        
    public function displayshoworderform(){
                $sql = "SELECT * FROM orderitem";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute();
                $result = $stmt->fetchAll();
        exit(json_encode($result));
              
            }
            function deleteorderfood($orderitem_ID){
                $sql = "DELETE FROM orderitem where orderitem_ID = :orderitem_ID;";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->bindParam(':orderitem_ID', $orderitem_ID, PDO::PARAM_INT);
                $result = $stmt->execute();
                if($result === true) {
                    return true;
                } else {
                    return false;
                }
            }




    function orderquantityfood($F_ID,$foodname,$price,$quantity,$totalprice) {
      
        $sql = "INSERT INTO orderitem (F_ID,foodname,price,quantity,totalprice)  VALUES (:F_ID,:foodname,:price,:quantity,:totalprice);";
        $stmt = $this->dbconn->prepare($sql);
      //  $stmt->bindParam(':F_ID', $F_ID, PDO::PARAM_INT);  
      $stmt->bindParam(':F_ID', $F_ID, PDO::PARAM_INT);   
        $stmt->bindParam(':foodname', $foodname, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);   
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);   
        $stmt->bindParam(':totalprice', $totalprice, PDO::PARAM_INT);    
        $result = $stmt->execute();
        if($result === true) {
            return true;
        } else {
            return false;
        }
    }
}

  
?>
