<html>
    <head>
        <?php require_once 'config.php'; ?>
        <title>Kayıt Ol - <?php echo $SITENAME; ?></title>
        <style>        
        @import'style.css'
        </style>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php 
        require_once 'header.php';
        require_once 'list.php';
        require_once 'functions.php';
	    session_start();
	    if	(isset($_SESSION['username'])) {
		    header("Location: $SITEADDR");
	    }
        ?>   
        
        
    </head>
    
    <body>

    <div class="content_area">   

        
        <?php require_once 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        
        <?php
        require_once 'class.phpmailer.php';
       
        require_once'conn.php';

  
        
        if(
                isset($_POST["username"]) &&
                isset($_POST["email"]) &&
                isset($_POST["password"]) &&
                isset($_POST["password2"])
                ){
            
            
            $username= get_post($conn,"username");
            $email= get_post($conn,"email");
            $password= get_post($conn,"password");
            $password2= get_post($conn,"password2");
            
            
            $query= "SELECT username FROM users WHERE username='$username'";
            $result= $conn->query($query);
            $result->data_seek(0);
            $flag=0;
            if($result->num_rows>0){
                echo "<font color='red'>Bu kullanıcı adı zaten kullanılmış. Başka bir tane dene.</font><br>";
                $flag++;

            }
            
            
            if(control_username($username)){
                echo "<font color='red'>Böyle kullanıcı adı olamaz, olmamalı.</font> Lütfen başka bir tane dene.<br>";
                $flag++;
            }
            
            $query= "SELECT email FROM users WHERE email='$email'";
            $result= $conn->query($query);
            $result->data_seek(0);
            
            if($result->num_rows>0){
                echo "<font color='red'>Bu email zaten kullanılmış. Başka bir tane dene.</font><br>";
                $flag++;

            }
            
            
            if($password!= $password2){
                echo "<font color='red'>Şifreler birbirini tutmuyor!</font><br>";
                $flag++;
            }
            
            
            if($flag==0){
            	
            	
            if($GCAPTCHA_OPEN) {
            $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$captchaSecretCode."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']), true);

            	 if($response['success']){
                	$success =  addUser($conn,$username, $password, $email);
            	}
            	 else{
                	die("Spam kontrolünü geçemediniz.<br>");
            	}
            }
            else{
                $success =  addUser($conn,$username, $password, $email);
            }

            
            if($success==FALSE){
                
                echo "Üye kaydı gerçekleştirilemedi!<br>"
                . $conn->error."<br><br>";
                
            }
            else{
                echo "<font color='green'>Kaydın Başarıyla Gerçekleştirildi!</font><br>";
                //require_once 'includes/google-registration-follower.php';

            }
            
        $success = send_activate_mail($username,$email);
        
            
        if($success){
            
            echo "E-mail hesabına aktivasyon için bağlantı gönderildi.<br>"
            . "Lütfen o bağlantıya tıklayarak üyelik hesabını aktive et.<br>"
            . "E-mail, spam(gereksiz) kutusuna gitmiş olabilir lütfen kontrol et.<br>";
        }
        else{
            echo "<font color='red'>Email aktivasyon maili gönderilemedi.</font><br>"
            . "Lütfen, daha sonra giriş yapıp tekrar gönderilmesini sağla.";
        }
        
        
            }
        }


        echo <<<_END
   <form method="post" action="register.php">
        <pre>
Kullanıcı Adı:
<input type="text" name="username" pattern="[A-Za-z0-9- -]+"
title='Kullanıcı adı, ingilizce harfler ve sayılardan oluşabilir ve en fazla 40 karakter olabilir.'
required="required">
<br>
E-mail:
<input type="email" name="email" required="required">   
<br>
Şifre:
<input type="password" name="password" required="required">
<br>
Şifre (tekrar):
<input type="password" name="password2" required="required">
_END;
	if($GCAPTCHA_OPEN){
		
		echo "<div class='g-recaptcha' data-sitekey='$dataSiteKey'></div>";

	}
	echo <<<_END

<input id="button" type="submit" value="Kayıt">    
        </pre>
    </form>  
       
_END;
        $conn->close(); 
        
        
        ?>  
    
        

        
        

    </div>
    </body>
    
</html>



