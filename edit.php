<?php session_start(); ?>
<?php require_once 'config.php'; ?>
<html>
    <head>
        <title><?php echo $SITENAME; ?></title>
        <style>@import'style.css'</style>
        
        <?php
        session_start();
        require_once 'header.php';
        require_once 'list.php';
        require_once 'functions.php';
        ?>
        
        
		  <meta charset="UTF-8">
		  <meta name="description" content="Yorumlar hakkında herşey">
		  <meta name="keywords" content="telefon,bilgisayar,kafe,restoran,oyun,web sitesi">
           
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
        require_once 'conn.php';

        
        if(isset($_SESSION['username'])){
            
            if(     isset($_POST['entry_id']) &&  
                    isset($_POST['stars']) && 
                    isset($_POST['entry'])){
                
                
                $entry_id= get_post($conn, 'entry_id');
                $stars= get_post($conn,'stars');
                $entry= get_post($conn,'entry');
                
                $success= update_entry($conn,$entry_id,$stars,$entry);
                
                if($success){
                    echo "Yorumun güncellendi.<br>";
                }
                else{
                    echo "Yorumun <font color='red'>güncellenemedi.</font><br>"
                    . "Daha sonra tekrar  dene.<br>";
                }
                
            }
            
            
            $current_username= $_SESSION['username'];
            if(isset($_GET['id'])){
                $entry_id = get_get($conn,'id');
                $owner= find_owner_of_entry($conn, $entry_id);
                
                if($owner == $current_username){
                    display_edit_area($conn,$entry_id);
                }
                else{
                    echo "<font color='red'>Bu yorumu düzenleyemezsin.</font><br>";
                }
            
            }
            
        }
        else{
            echo "Giriş yapmalısın.";
        }
        
        
        ?>
        <?php require_once 'footer.php'; ?> 
        
    </div>
 
        
    </body>
    
</html>



