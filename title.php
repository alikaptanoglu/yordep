<html>
    <head>
        
        <?php
        session_start();
        
        require_once 'class.phpmailer.php';
        require_once 'config.php';
        require_once 'conn.php';
        require_once 'functions.php';
        
        if(isset($_GET['title_id'])){
            $title_id= get_get($conn, 'title_id');
            $title= get_title($conn, $title_id);
            echo "<title>$title - $SITENAME</title>";
            
        }
        else if(isset($_GET['id'])){
            $title_id= get_get($conn,'id');
            $title= get_title($conn, $title_id);
            echo "<title>$title - $SITENAME</title>";
        }
        
	        
        ?>
 
        <style>@import'style.css'</style>
        
        <?php 
        require_once 'header.php';
        require_once 'list.php';
        //require_once 'footer.php';
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
        $num_pages = 1;
    
        if(isset($_SESSION['username'])){
            $username= $_SESSION['username'];
            $email= $_SESSION['email'];
             
            if(isset($_POST['mailactivate'])){
		$success = send_activate_mail($username,$email);       	
                if($success){
                    echo "E-mail doğrulama bağlantısı <font color='green'>gönderildi.</font><br>"
                    . "Lütfen mail kutunu kontrol et.<br>"
                    . "Maili görmemen durumunda spam(gereksiz) kutusuna bakmayı unutma.<br>";
                }
                else{
                    echo "Email doğrulama bağlantısı <font color='red'>gönderilemedi.</font><br>"
                    . "Lütfen daha sonra tekrar dene.";
                }
                
                
            }

}



if(isset($_GET['title_id']) || isset($_GET['id'])){
    
    if(isset($_GET['fromlist'])){
        $fromlist= "yes";
    }
    else{
        $fromlist = "no";
    }
    //$title_id= get_get($conn,'title_id');
    $query= "SELECT title,category FROM titles WHERE title_id='$title_id'";
    $result= $conn->query($query);
    if(!$result){
        die($conn->error);
    }
    
    $result->data_seek(0);
        

    $row= $result->fetch_array(MYSQLI_NUM);
    $title= $row[0];
    $category= $row[1];
    
    
    
        if(isset($_SESSION['username'])){
            $current_username= $_SESSION['username'];
                      if(isset($_POST['stars']) && isset($_POST['entry'])){
            
            $stars= get_post($conn, 'stars');
            $entry= get_post($conn,'entry');
            
            
            add_entry($conn,$title_id,$entry,$stars,$category,$current_username);
            $num_pages= find_num_pages($conn, $title_id, $fromlist);
            $num_pages/=10;
            $num_pages= ceil($num_pages);
            
            header("Location: title.php?id=$title_id&page=$num_pages");
            
            
            $query= "SELECT totalstar,totalentry FROM titles WHERE title_id='$title_id'";
            $result= $conn->query($query);
            
            if(!$result){
                die($conn->error);
            }
            
            $result->data_seek(0);
            $row= $result->fetch_array(MYSQLI_NUM);
            
            
            $totalstar= $row[0];
            $totalentry= $row[1];
            
            $lastupdate = new DateTime();
            $lastupdate=  $lastupdate->format('Y-m-d H:i:s');
            
            
            $totalstar+= $stars;
            $totalentry++;
            
            
            $query= "UPDATE titles SET lastupdate='$lastupdate' , totalstar='$totalstar', totalentry='$totalentry' WHERE title_id='$title_id' ";
            $result= $conn->query($query);
            if(!$result){
                die($conn->error);
            }
        }
            
            
        }

    if(isset($_GET['page'])){
        $page= get_get($conn,'page');
        $page_last= $page*10;
        $page_first= $page_last-10;
    } 
    else{
        $page=1;
        $page_last= $page*10;
        $page_first= $page_last-10;
    }
    
    
        
    if(isset($_GET['fromlist']) && $fromlist == "yes"){
        
        /*$query= "SELECT entry,stars,time,username,id FROM entries WHERE title_id='$title_id'"
        . " AND DATE(`time`) = CURDATE() ORDER BY time ASC LIMIT $page_first,$page_last"; 
         */
        $total_entry_of_title = find_totalentry_of_title($conn, $title_id);
        $target_page = ceil($total_entry_of_title/10);
        header("Location: title.php?id=$title_id&page=$target_page");
        
    }
    else{

        $query= "SELECT entry,stars,time,username,id FROM entries WHERE title_id='$title_id'"
        . " ORDER BY time ASC LIMIT $page_first,$page_last";       
    }
    
    $result= $conn->query($query);
    
    if(!$result){
        die($conn->error);
    }
    
    $num_rows= $result->num_rows;
        
        require_once 'main-ad.php';
    
        echo "<span itemscope itemtype='http://www.schema.org/AggregateRating'><a id='title' href='title.php?id=$title_id'><span itemprop='itemReviewed'>".$title."</span></a>";
        $average_star= find_average_star($conn,$title_id);
        $reviewCount= find_reviewCount($conn,$title_id);
        
        echo "<span itemprop='reviewCount' hidden>$reviewCount</span>";
        echo "<span itemprop='bestRating' hidden>5</span>";
        for($i=0;$i<$average_star;$i++){
            echo "<img alt='yıldız' width='20px' src='img/star.png'>";
        } 
        printf("<b>(<span itemprop='ratingValue'>%.2f</span>)</b></span>",$average_star);
        
        
        page_nav($conn,$fromlist,$num_pages,$title_id,$page);
        
        if($num_rows==0){
        	        echo "<font color='red'>bugün yeni birşey yok. öncekileri görmek için başlığa tıkla.</font>";
        }        
                
    for($i=0;$i<$num_rows;$i++){
        
        $result->data_seek($i);
        $row= $result->fetch_array(MYSQLI_NUM);
        $entry= $row[0];
        $stars= $row[1];
        $time= $row[2];
        $time= new DateTime($time);       
        $time = $time->format('d-m-Y H:i:s');
        $username= $row[3];
        $entry_id= $row[4];
        for($j=0;$j<$stars;$j++){
            echo "<img title='$stars yıldız' width='20px' src='img/star.png'>";
        }
        echo "<span itemscope itemtype='http://www.schema.org/Review'> ";
        echo "<span itemprop='itemReviewed' hidden>$title</span>";
        echo nl2br("<p itemprop='reviewBody'>$entry</p>");
        display_edit_delete_area($conn,$entry_id,$username);
        
        echo "<p id='entry_info' align='right'><span itemprop='datePublished'>$time</span> - <a id='general_font' itemprop='author' href='profile.php?u=$username'>$username<hr></a></p></span>";
        
        
    }
    

        page_nav($conn,$fromlist,$num_pages,$title_id,$page);
      


    if(isset($_SESSION['username'])){
        
        $email= $_SESSION['email'];
        $username= $_SESSION['username'];
        $email_check = email_check($conn,$email);
        $isBanned = isBanned($conn, $username);
        if($email_check && !$isBanned){
            echo <<<_END
            <form method="post" action="title.php?id=$title_id">

            Kaç yıldız?:
            <select required='required' name="stars" size='1'>
            <option value='1'>1 (Berbat)</option>
            <option value='2'>2 (Kötünün iyisi)</option>
            <option value='3'>3 (İdare eder)</option>
            <option value='4'>4 (Şön)</option>
            <option selected='selected' value='5'>5 (Dehşet'ül Vahşet)</option>  
            </select>
            <br>
                        
            <textarea name="entry" rows='10' spellcheck='false' required='required'></textarea>
            <br>
            <input type="submit" value="Gönder">

            </form>    
_END;
                
        }
        
        else if($isBanned){
            echo "Hesabınız engellenmiştir.<br>";
        }
        
        else{
            
            echo "<font color='red'>E-mail hesabınızı doğrulamadığınız için yorum gönderemezsiniz.</font><br>"
            . "Lütfen Email hesabınızı doğrulayın.<br>";
            
            echo <<<_END
            <form action='title.php' method='post'>
            <input type='hidden' name='mailactivate' value='yes'>
            <input type='submit' value='Doğrulama maili gönder'>
            </form>
            
_END;
        }
        
    }
    else{
        echo "Yorum yazabilmek için "
        . "<a href='login.php'>giriş yapmalısın.</a>";
    }
}
        
        
 
    ?>
        
        <?php require_once 'footer.php'; ?>
        
        
    </div>
    
    </body>
    
</html>



