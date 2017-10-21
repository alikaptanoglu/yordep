<html>
    <head>
        <?php require_once 'config.php'; ?>
        <title><?php echo $SITENAME; ?></title>
        <style>@import'style.css'</style>
        
        <?php
        
        session_start();
        require_once 'header.php';
        require_once 'list.php';
        require_once 'functions.php';
        ?>    
           
        
    </head>
    
    <body>
    
    <div class="content_area">    
        
    <?php require 'search-results.php'; ?>
        <div class='desktop-hide'><span id='cats'></span></div>
        
    <?php
    
    
    require_once 'conn.php';
    require_once 'class.phpmailer.php';

        if(isset($_GET['title'])){
            $title= get_get($conn, 'title');
            if($title[0]=='@'){
                $username_in_query = substr($title,1);
                if(isThereUser($conn,$username_in_query)){
                    goUserPage($username_in_query);
                }
                else{
                    echo "Böyle bir kullanıcı yoktur.\n";
                    die();
                }
            }
            
            
            $title= alt_replace($title);
            $title_id= get_title_id($conn,$title);
            
        if(control_title($conn,$title)==1){
                header("Location: title.php?title_id=$title_id");
            }
        else if(control_title($conn,$title)==2){
            die("Böyle bir başlık olamaz, olmamalı.");
        }
        else if(!isset($_SESSION['username'])){
            echo "böyle bir şey yok ama sen oluşturabilirsin.<br><br>";
            echo "yeni başlık açabilmek için <a href='login.php'>giriş yapmalısın.</a><br>";
        }
        
        }

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
       
    if(     isset($_POST['title-next']) &&
            isset($_POST['stars']) &&
            isset($_POST['entry']) &&
            isset($_POST['category'])
            ){
        
        $title= get_post($conn,'title-next');
        $stars= get_post($conn,"stars");
        $entry= get_post($conn,"entry");
        $category= get_post($conn,"category");
        $title_id= send_title_and_entry($conn,$title,$stars,$entry,$category);
            
        header("Location: title.php?title_id=$title_id");

        
    }
    
    else{       
        
        $email= $_SESSION['email'];
        $username =$_SESSION['username'];
        $email_check =  email_check($conn, $email);
        $isBanned= isBanned($conn, $username);
        $title_check= title_check($title);
        
        if($email_check){
            
            if($title_check && !$isBanned){
            echo <<<_END
            böyle bir şey yok ama sen başlatabilirsin.
            <form method="post" action="newtitle.php">
            <h1>$title</h1>
            <input type='hidden' name='title-next' value='$title'>
            Kaç yıldız?:
            <select name="stars" size='1'>
            <option value='1'>1 (Berbat)</option>
            <option value='2'>2 (Kötünün iyisi)</option>
            <option value='3'>3 (İdare eder)</option>
            <option value='4'>4 (Şön)</option>
            <option selected='selected' value='5'>5 (Dehşet'ül Vahşet)</option>  
            </select>
            <br><br>
      
            Kategori:
            <select name="category" size='1'>
            <option value='film/dizi'>film/dizi</option>
            <option value='kitap'>kitap</option>
            <option value='teknolojik ürün'>teknolojik ürün</option>
            <option value='otomobil'>otomobil</option>
            <option value='web sitesi'>web sitesi</option>
            <option value='kafe/restoran'>kafe/restoran</option>
            <option value='otel'>otel</option>
            <option value='organizasyon'>organizasyon</option>
            <option value='oyun'>oyun</option>
            <option value='üniversite'>üniversite</option>
            </select>
            <br><br>    
        
            <textarea name="entry" rows='10' spellcheck='false'  required="required"></textarea>
            <br><br>       
            <input type="submit" value="Gönder">
            </form>  
_END;
            
            }
            else if($isBanned){
                echo "Hesabınız engellenmiştir.<br>";
            }
            else{
                echo "Başlık en fazla 64 karakterden oluşabilir.<br>";
            }
        }
        

        else{
            echo "<font color='red'>E-mail hesabınızı doğrulamadığınız için yorum gönderemezsiniz.</font><br>"
            . "Lütfen Email hesabınızı doğrulayın.<br>";
            
            echo <<<_END
            <form action='newtitle.php' method='post'>
            <input type='hidden' name='mailactivate' value='yes'>
            <input type='submit' value='Doğrulama maili gönder'>
            </form>
            
_END;
                    }
        
        }
    }
    
    
    
    ?>
        
 
    
    </div>
    
    </body>
    
</html>




