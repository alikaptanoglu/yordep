<?php session_start(); ?>

<html>
    <head>
        <title>Yorum Deposu</title>
        <style>@import'style.css'</style>
        
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
                
        <?php require_once 'footer.php'; ?>
                
        <?php
        require_once 'header.php';
        require_once 'list.php';
        ?>
        
    </div>
 
        
    </body>
    
</html>



