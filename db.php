<?php
$servername = getenv('DB_SERVER');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$dbname = getenv('DB_NAME');


$con=new mysqli($servername, $username, $password, $database) or die("Unable to connect");
if(!empty($con->connect_error)){
    echo "Error :".$con->connect_error;
}else{
    echo "Connected Successfully";
}
?>