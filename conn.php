<?php //conn.php

 require_once 'config.php';


    $conn= new mysqli($DBHOST,$DBUSER,$DBPASS,$DBNAME);
    if($conn->connect_error){
       die($conn->connect_error);
    }

$conn->query("SET NAMES 'utf8'");
$conn->query("SET CHARACTER SET utf8");

?>
