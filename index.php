<?php session_start(); ?>
<?php require_once 'config.php'; ?>

<html>
    <head>
        <title><?php echo $SITENAME; ?></title>
        <style>@import'style.css'</style>
       
        
        
        <meta name="description" content="Yorumlar hakkında herşey">
        <meta name="keywords" content="teknolojik ürün,telefon,bilgisayar,kafe,restoran,oyun,web sitesi,film,dizi,yorumları,kullanıcı yorumları">
                   
        
        <?php
        require_once 'header.php';
        require_once 'list.php';
        require_once 'functions.php';
        ?>
        
       
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
        <?php include_once 'main-ad.php'; ?>
        
        <?php
        
        
        require_once 'conn.php';
        
        
        display_all_entries($conn,20);
        
        
        
        
        ?>
        
        <?php require_once 'footer.php'; ?> 
        
    </div>
 
        
    </body>
    
</html>



