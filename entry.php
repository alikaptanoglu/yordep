
<html>
    <head>
        <?php
        session_start();
        
        require_once 'conn.php';
        require_once 'functions.php';
        require_once 'config.php';
        
        
        if(isset($_GET['id'])){
            $entry_id= get_get($conn, 'id');
            $title= get_title_from_entry($conn, $entry_id);
            echo "<title>yorum: $title - $SITENAME</title>";
            
        }
        
	        
        ?>
        <style>@import'style.css'</style>
        
        <?php 
        session_start();
        require_once 'header.php';
        require_once 'list.php';
        ?>   


        <script>
        function deleteFunc(entry_id) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("delete_area_"+entry_id).innerHTML = this.responseText;
        }
        };
        xhttp.open("POST", "delete.php?entry_id="+entry_id , true);
        xhttp.send();
        }
        </script>
        
    </head>
    
    <body>
    
        
        
    <div class="content_area">    
        <?php require_once 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        <?php

if(isset($_GET['id'])){
    $entry_id= get_get($conn, 'id');
    $title= get_title_from_entry($conn, $entry_id);
    $title_id= get_title_id($conn, $title); 
    
    $query= "SELECT entry,stars,time,username,id FROM entries WHERE id='$entry_id'";
    $result= $conn->query($query);
    
    if(!$result){
        die($conn->connect_error);
    }
     
   $row= $result->fetch_array(MYSQLI_NUM);

        $result->data_seek(0);
        $row= $result->fetch_array(MYSQLI_NUM);
        $entry= $row[0];
        $stars= $row[1];
        $time= $row[2];
        $time= new DateTime($time);       
        $time = $time->format('d-m-Y H:i:s');
        $username= $row[3];
        $entry_id= $row[4];
        
        
        
        require_once 'main-ad.php';
        
        echo "<span itemscope itemtype='http://www.schema.org/Review'> "
        . "<a id='title' href='title.php?title_id=$title_id'>"
                . "<span itemprop='itemReviewed'>".$title."</span></a>";
        
        $average_star= find_average_star($conn,$title_id);
        
        for($i=0;$i<$average_star;$i++){
            echo "<img alt='puan' width='20px' src='img/star.png'>";
        } 
        printf("<b>(%.2f)</b><br><br>",$average_star);

        
        echo "<span itemscope itemtype='http://www.schema.org/Rating'><span itemprop='ratingValue' hidden>$stars</span>";
        echo "<span itemprop='bestRating' hidden>5</span></span>";
        
        for($j=0;$j<$stars;$j++){
            echo "<img title='$stars yıldız' width='20px' src='img/star.png'>";
        }
        echo "<span itemprop='reviewRating' value='$stars'></span>";
        echo nl2br("<p itemprop='reviewBody'>$entry</p>");
        display_edit_delete_area($conn, $entry_id, $username);
        echo "<p id='entry_info' align='right'><span itemprop='datePublished'>$time</span> - "
                . "<a id='general_font' itemprop='author' href='profile.php?u=$username'>$username<hr></a>"
                . "</p></span>";
    
}

        
        
        
        


?>

        
        
        <?php require_once 'footer.php'; ?> 
        
    </div>
 
        
    </body>
    
</html>



