<?php

    session_start();

    
    require_once 'conn.php';
    require_once 'functions.php';
    
    if(isset($_SESSION['username']) && isset($_GET['entry_id']) ){  
        $entry_id= get_get($conn, 'entry_id');
        $owner = find_owner_of_entry($conn, $entry_id);
        $current_username= $_SESSION['username'];
        $title_id= get_title_id_from_entry_id($conn, $entry_id);
        $status= find_status_of_member($conn, $current_username);
        
        if( ($current_username == $owner ) || ($status=='admin') ){
            $totalstar = find_totalstar_of_title($conn, $title_id);
            $totalentry= find_totalentry_of_title($conn, $title_id);
            $star_number_of_entry= find_star_number_of_entry($conn, $entry_id);
            subtract_stars($conn, $title_id, $star_number_of_entry,$totalentry,$totalstar);
            

            delete_entry($conn, $entry_id);
            
            echo "<font color='green'>Yorum silindi.</font>"; 

         }
         else{
             echo "<font color='red'>Yorum silme yetkiniz yok.</font><br>";
         }
        
    }
    else{
        echo "Giriş yapmalısınız.<br>";
    }
    


?>