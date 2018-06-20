<html>
    <head>
        <?php
        
        require_once 'config.php';
	session_start();		
        require_once"conn.php";
        require_once 'functions.php';

        
        
        if(isset($_GET['u'])){
            $username = get_get($conn,'u');        
        
        }
        
        echo "<title>kullanıcı: $username - $SITENAME</title>";
        
        ?>
        <style>@import'style.css'</style>
        
        <?php 
        require_once 'header.php';
        require_once 'list.php';
        ?>    
           
        
    </head>
    
    <body>
    
    <div class="content_area">    

        <?php require_once 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        
        
<?php


if(isset($_GET['u'])){
    
    $username= get_get($conn, 'u');
    
    
    if(isset($_POST['willBannedUser'])){
        $willBannedUser = get_post($conn, 'willBannedUser');
        ban($conn,$willBannedUser);
        
        echo $willBannedUser." adlı kullanıcı engellendi.<br>";
    }
    
    if(isset($_POST['willUnBannedUser'])){
        $willUnBannedUser = get_post($conn, 'willUnBannedUser');
        unBan($conn,$willUnBannedUser);
        
        echo $willUnBannedUser." adlı kullanıcının engeli kaldırıldı.<br>";
    }    
    
    
    if(check_username($conn,$username)){
        $number_of_titles= number_of_titles($conn, $username);
        $number_of_entries = number_of_entries($conn, $username);
        echo "<h1>$username</h1>";
        echo "<span style='color: gray' title='yorum sayısı'>$number_of_entries - </span>";
        echo "<span style='color: gray' title='açtığı başlık sayısı'>$number_of_titles </span>";
        echo "<br>";

            if(isset($_SESSION['username'])){
        $current_username = $_SESSION['username'];
        $status= find_status_of_member($conn, $current_username);
        $status_of_the_member= find_status_of_member($conn, $username);
        if(($status == 'admin') && ($status_of_the_member!='admin')){
            if(!isBanned($conn,$username)){
                echo <<<_END
                <form action= 'profile.php?u=$username' method='post'>

                <input type='hidden' name='willBannedUser' value='$username'>
                <input id='banButton' type='submit' value='Engelle'>
                </form>
_END;
            }
            else{
                echo "Bu kullanıcı engellenmiştir.<br>";
                echo <<<_END
                <form action='profile.php?u=$username' method='post'>

                <input type='hidden' name='willUnBannedUser' value='$username'>
                <input id='banButton' type='submit' value='Engeli Kaldır'>
                </form>
_END;
                
            }
        }
    }
        
        display_last_entries_of_user($conn,$username,20);   

    }
    
    
    
    require_once 'footer.php';
    
    
}



?>
    </div>
    
    </body>
    
</html>



