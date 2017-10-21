<?php

session_start();
$_SESSION= array();
setcookie(session_name(),'',time()-60*60,'/');
header("Location: ".$_SERVER['HTTP_REFERER']);
session_destroy();  


?>
