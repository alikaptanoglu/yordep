<?php session_start(); ?>
<?php require_once 'config.php'; ?>

<html>
    <head>
        <title>İstatistik - <?php echo $SITENAME; ?></title>
        <style>@import'style.css'</style>
        
        <?php
        require_once 'header.php';
        require_once 'list.php';
        ?>
        
        
		  <meta charset="UTF-8">
		  <meta name="description" content="Yorumlar hakkında herşey">
		  <meta name="keywords" content="telefon,bilgisayar,kafe,restoran,oyun,web sitesi">
           
        
        
    </head>
    
    <body>
    
        
        
    <div class="content_area">    
        <?php require_once 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        <?php


require_once 'conn.php';
require_once 'functions.php';

$query= "SELECT COUNT(*) FROM users";
$result= $conn->query($query);
if(!$result){
    die($conn->error);
}
$row= $result->fetch_array(MYSQLI_NUM);

echo "<p>Üye sayısı: ".$row[0]."</p>";



$query= "SELECT COUNT(*) FROM titles";
$result= $conn->query($query);
if(!$result){
    die($conn->error);
}
$row= $result->fetch_array(MYSQLI_NUM);

echo "<p>Başlık sayısı: ".$row[0]."</p>";






$query= "SELECT COUNT(*) FROM entries";
$result= $conn->query($query);
if(!$result){
    die($conn->error);
}
$row= $result->fetch_array(MYSQLI_NUM);

echo "<p>Yorum  sayısı: ".$row[0]."</p>";


$last_user= last_user($conn);
echo "<p>Son kullanıcı: <a href='profile.php?u=$last_user'>$last_user</a></p>";






$conn->close();



?>
        <?php require_once 'footer.php'; ?> 
        
    </div>
 
        
    </body>
    
</html>



