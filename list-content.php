<?php


require_once 'conn.php';
require_once 'functions.php';
session_start();

$query_string= '';

if(isset($_GET['category'])){
    $category= get_get($conn, 'category');
    $_SESSION['precat']= $category;
    if($category != 'bugün'){
        $query_string= "WHERE category='$category'";
    }

}
else if(isset($_SESSION['precat'])){
    $category =$_SESSION['precat'];
    $query_string= "WHERE category='$category'";
}




$query= "SELECT title,title_id FROM titles $query_string ORDER BY lastupdate DESC LIMIT 40";
$result= $conn->query($query);

if(!$result){
    die($conn->error);
}

$num_rows= $result->num_rows;

echo "<h3 style='color: gray'>$category</h3>";


for($i=0;$i<$num_rows;$i++){
    $result->data_seek($i);
    $row= $result->fetch_array(MYSQLI_NUM);
    $title= $row[0];
    $title_id= $row[1];
    echo "<a id='general_font' rel='nofollow' href='title.php?fromlist=yes&id=$title_id'>$title</a><br><hr>";
    
}
echo "<br><br><br>";



$conn->close();




?>
