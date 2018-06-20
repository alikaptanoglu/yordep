<html>
    <head>
        <?php require_once 'config.php'; ?>
        <title>Giriş Yap - <?php echo $SITENAME; ?></title>
        <style>@import'style.css'</style>
        
        <?php

        require_once 'header.php';
        require_once 'list.php';
        require_once 'functions.php';
        require_once 'config.php';
        ?>    
           
        
    </head>
    
    <body>
    
    <div class="content_area">    

            
        
        
        <?php require_once 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        
        
        <?php

        require_once"conn.php";


        if(     isset($_POST["email"]) &&
                isset($_POST["password"])
                ){
            
            $email= get_post($conn,"email");
            $password= get_post($conn,"password");
            
            $password= encryptPass($password);
            
            $query= "SELECT password FROM users WHERE email='$email'";
            $result= $conn->query($query);
            $result->data_seek(0);
            $real_pass= $result->fetch_assoc()['password'];
            
            
            
            if($real_pass!=$password){
                echo"<font color='red'>Email veya şifre yanlış.</font><br>";
            }
            
            
            else{
                $query= "SELECT username FROM users WHERE email='$email'";
                $result= $conn->query($query);
                $result->data_seek(0);
                $username= $result->fetch_assoc()['username'];
                
                logIn($username,$email);

            }
        }
 
        
    if(!isset($_SESSION['username'])){
        echo <<<_END
<pre>
<form method="post" action="login.php">
E-mail:
<input type="email" name="email" autocomplete='on' autofocus='autofocus' required="required">
<br>        
Şifre:
<input type="password" name="password" required="required">
<br>
<input id="button" type="submit" value="Giriş">       
</form>  
<a href='password-reset.php'>Şifremi Unuttum</a> | <a href='register.php'>Kayıt Ol</a>
</pre>  
_END;
    }
    else{
        echo "<font color='green'>Giriş Yapıldı</font><br>";
        header('Location: index.php');
        
    }
    
    $conn->close();
    
    
        ?>  
        
    </div>
    </body>
    
</html>



