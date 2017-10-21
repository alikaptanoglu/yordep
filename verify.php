    <?php

require_once 'conn.php';
require_once 'functions.php';



if(isset($_GET['email']) && isset($_GET['code'])){
    
    $email= get_get($conn,'email');
    $code= get_get($conn, 'code');
    
    $activate_code= generate_email_activate_code($email);
    
    
    if($code== $activate_code){
        
        $success= activate_email($conn,$email);
        if($success){
        	echo "<br>  <center><b><font color='green'>Mail hesabınız aktive edildi.</font></b><br><br>";
                echo  "<a href='/'>ana sayfa</a></center>";
               
        }
    }
}

        

?>