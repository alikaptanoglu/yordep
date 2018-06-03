 <?php
 ob_start();
 session_start();
 require_once 'conn.php';
 require_once 'functions.php';


$q = get_request($conn,'q');
    if($q[0]=='@'){
        $isUserSearch = TRUE;
        $q= substr($q,1);
        $query= "SELECT username FROM users "
                . "WHERE username LIKE '$q%' LIMIT 10";
        $result= $conn->query($query);
    
        if(!$result){
            die($result->error);
        }
        $num_rows= $result->num_rows;

    }
    else
    {
        $isUserSearch = FALSE;
        $query= "SELECT title,title_id FROM titles "
                . "WHERE MATCH(title) AGAINST('$q') OR title LIKE '%$q%' LIMIT 10";
        $result= $conn->query($query);
    
        if(!$result){
            die($result->error);
        }
        $num_rows= $result->num_rows;
        
        }
    echo "<h2>Arama Sonuçları:</h2> ";
    
    if($num_rows==0){
        if(!isset($_SESSION['username'])){
    $newtitle_text= "<a href='newtitle.php?title=$q'> <İstersen sen açabilirsin></a>";
            }
    else{
    $newtitle_text='';
            }
    echo "<p>Böyle bir başlık bulunamadı. </p>$newtitle_text";
    }
if($isUserSearch){
    for($i=0;$i<$num_rows;$i++){
        $result->data_seek($i);
        $row= $result->fetch_array(MYSQLI_NUM);
        $username_in_query= $row[0];
        echo '<b>'.($i+1).'</b>: ';   
        echo "<a href='profile.php?u=$username_in_query'>@$username_in_query</a><br>";
    }
    
}
else{
    
    for($i=0;$i<$num_rows;$i++){
    
        $result->data_seek($i);
        $row= $result->fetch_array(MYSQLI_NUM);
        $string= $row[0];
        $id= $row[1];
    
        echo "<p><a id='searchresult' href='title.php?title_id=$id'>"
                . "<b>".($i+1).'</b>'.": $string</a></p>"; 
}


}
?> 