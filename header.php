<?php
  ob_start();
  session_start();
?>
<header>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
    <meta name="content-language" content="tr-TR" >
    <meta name="language" content="Turkish" >
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="yorumları,yorumlar,yorum,nasıl,nasıldır">

    
       <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Poppins|Ubuntu+Condensed" rel="stylesheet"> 
       
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-91030816-2', 'auto');
  ga('send', 'pageview');

	</script>
        
        
        <script>
function loadCats() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("cats").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "cats-mobile.php", true);
  xhttp.send();
}


function loadDocMobile(category) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("cats").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "list-content.php?category="+category , true);
  xhttp.send();
}

</script>
        
    
    
    
    <?php
    if($_SERVER['PHP_SELF']!='/login.php'){
        $_SESSION['lastpage']= "$_SERVER[REQUEST_URI]";
    }
    ?>
  
	<div class="headerlogo">
        
        <a href='/'><img alt='logo' src="img/logo.png" height='35px' title="yorumdeposu.com"></a>
        <br>
        <a href='#top' class='desktop-hide' onclick='loadCats()'>kategori</a>
        </div>  

        <link rel="icon" href="img/icon.png">
        <div class="searcharea">
            <form action="newtitle.php" method='get'> 
                
            <input name='title' placeholder="ara beni..." type="text" id="searchbox"  autocomplete="off"
                   onkeyup="showHint(this.value);$('html, body').animate({ scrollTop: 0 }, 'fast');">
            </form>
            
        </div>
        
<?php require_once 'cats.php'; ?>

        
      <div class="membership">   
      <?php
      

      
      
      if(!isset($_SESSION['username'])){
           echo <<<_END
        <a rel='nofollow' id='general_font' href="login.php"><b>giriş</b></a>
        &nbsp;&nbsp;&nbsp;
        <a rel='nofollow' id='general_font' href="register.php"><b>kayıt</b></a>     
_END;
           
      }
      
      else{
          $current_username= $_SESSION['username'];
          echo <<< _END
          <b><a id='general_font' href='profile.php?u=$current_username'>
              <img width='20px' src='img/profile.png'>
                  <span class='mobile-hide'>$current_username</span></a></b>
                  &nbsp;&nbsp;
          <b><a id='general_font' href='logout.php'><img title='çıkış yap' width='20px' src='img/logout.png'></a></b>
_END;
      }   
      
      
      
        ?>        
        </div>
</header>

