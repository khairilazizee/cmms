<?php
include_once("mainfile.php");
       session_start();
global $dbi;
     sql_query("DELETE FROM online WHERE login='".$_SESSION["username"]."'",$dbi);

//die("cas_enable:$cas_enable");
       unset($op);
	   unset($username);
	   unset($user_password);
	   unset($usrrole);
	   $islogin=0;
       $_SESSION["username"]="";	   
       $_SESSION["email"]="";	   
       $_SESSION["kodsek"]="";	   
       $_SESSION["password"]="";	   
       $_SESSION["login"]=0;	  	
	   session_destroy();
       pageredirect("index.php");
	  
?>