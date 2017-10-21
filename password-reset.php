<html>
    <head>
        <title>Yorum Deposu</title>
        <style>@import'style.css'</style>
        
        <?php 
        require_once 'header.php';
        require_once 'list.php';
        require_once 'functions.php';
        ?>    
           
        
    </head>
    
    <body>
        
        
    <div class="content_area">    
        <?php require_once 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        
        
        
        <?php

	require_once 'conn.php'; 
	require_once 'class.phpmailer.php';




if(isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email']) ){
    $password= get_post($conn, 'password');
    $password2= get_post($conn,'password2');
    $email= get_post($conn, 'email');
    if($password == $password2){
        
        $result= change_password($conn,$email,$password);
        
        if(result){
            echo "<font color='green'>Parolanız Başarıyla Güncellendi!</font>";
        }
        else{
            echo "<font color='red'>Parola Güncelleme Başarısız :(</font>";
        }
       
    }
    
    else{
        echo "<font color='red'>Parolalar eşleşmiyor</font><br>";
    }
    
}

else if(isset($_GET['email']) && isset($_GET['u']) && isset($_GET['code'])){
    $email= get_get($conn,'email');
    $username= get_get($conn, 'u');
    $code= get_get($conn, 'code');
    
    $reset_code= generate_password_reset_code($conn,$username, $email);
    
    
    if($code == $reset_code){
        
        echo <<<_END
        
<form action='password-reset.php' method='post'>
<pre>
Yeni Şifre:
<input type='password' name='password' required='required'>
Yeni Şifre (doğrulama):
<input type='password' name='password2' required='required'>
<input type='hidden' name='email' value='$email'>
<input type='submit' value='Sıfırla'>
</pre>
</form>
                
_END;
           
        
    }
    
    
}



else if(isset($_POST['email'])){
    
    $email= get_post($conn, 'email');
    $username=get_username($conn,$email);
    
    $check_email= check_email($conn,$email);
    
    if($check_email){
        $success = send_reset_pass_mail($conn,$username,$email);
        
    }
    else{
        echo "Eğer doğru girdiyseniz, email hesabınıza parola sıfırlama bağlantısı gönderilmiştir.<br>"
        . "Email spam(gereksiz) kutusuna gitmiş olabilir lütfen kontrol ediniz.<br>";
    }
    
    if($success){
        echo "Eğer doğru girdiyseniz, email hesabınıza parola sıfırlama bağlantısı gönderilmiştir.<br>"
        . "Email, spam(gereksiz) kutusuna gitmiş olabilir lütfen kontrol ediniz.<br>";
    }
    else{
        echo "Parola sıfırlama bağlantısı mail hesabınıza <font color='red'> gönderilemedi</font>.<br>"
        . "Lütfen daha sonra tekrar deneyin.";
    }
}



else{
    
    echo <<<_END
<form method='post' action='password-reset.php'>
<pre>

E-mail adresi:
<input type='email' name='email'>
<br>
<input type='submit' value='Gönder'>
</pre>
</form>
    
_END;
    
}




 
        
        
        $conn->close();

?>
        
        
        
        
        
        
        <?php require_once 'footer.php'; ?>
    </div>
 
        
    </body>
    
</html>



