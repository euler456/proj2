<?php

$dbhost = 'localhost:3307';
$dbuser = 'root';
$dbpass = '';
$db     = 'proj2';


$conn  = mysqli_connect($dbhost,$dbuser,'',$db);

$sql=mysqli_query($conn,"SELECT * FROM food");
$result=mysqli_fetch_all($sql,MYSQLI_ASSOC);

exit(json_encode($result));
      
  
?>
