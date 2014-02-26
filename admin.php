<?php 
session_start();
include_once("adminfile.php");

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT"); // Date in the past
head();

define( '_UMPORTAL_ADMIN', 1 );
$hlcolor= "#AACCF2";
$ncolor="#C0E1FA";	
$altcolor="#57C9DD";

  if (isset($_REQUEST["txtop"]))
    $op=$_REQUEST["txtop"];
  else
    $op="";

   $errmsg="";
  if ($op=="login"){
    $username=$_REQUEST["txtlogin"];
    $user_password=$_REQUEST["txtpassword"];
  }
  else {
    if (isset($_SESSION["adminusr"]))
      $username= $_SESSION["adminusr"];
	if (isset($_SESSION["adminpwd"]))  
      $user_password=$_SESSION["adminpwd"];  
  }
  	
  $usrrole=check_user_login($username,$user_password);
  if ($usrrole == "1"){ //role admin
           $islogin=1;
           $_SESSION["adminusr"]=$username;	   
           $_SESSION["adminpwd"]=$user_password;	   
           $_SESSION["adminrole"]=$usrrole;
		   $_SESSION["adminlogin"]=1;
		   if (!isset($module))
		     $module="adminpanel";
  }
  else {
           $islogin=0;
           $_SESSION["adminusr"]="";	   
           $_SESSION["adminpwd"]="";	   
           $_SESSION["adminrole"]="";
		   $_SESSION["adminlogin"]=0;

  }

if ($op=="login" and $islogin==0)
   $errmsg="Pengguna tidak sah !";

if ($op=="logout") {
    $islogin=0;
    $_SESSION["adminusr"]="";	   
    $_SESSION["adminpwd"]="";	   
    $_SESSION["adminrole"]="";
	$_SESSION["adminlogin"]=0;
}  
	
if (!isset($op))
  $op="";
  
if (!isset($usrrole))
   $usrrole="";  

?>
<center>
<table width="100%" border="0"  cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include("header.php"); ?></td>
  </tr>
<tr><td align="center" background="images/bg_merah.gif"><strong><font color="#FFFFFF">Halaman Admin EmisPortal</font></strong></td></tr>  
  <tr>
    <td>
	
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
 	<?php
     if ($islogin==0){ ?>
  <td>	
   <br>
	<form name="frmlogin" action="admin.php" method="post">
	<table align="center" width="300"  border="0" cellspacing="0" cellpadding="1" bgcolor="#797979">
	<tr><td>
	<table align="center" width="300"  border="0" cellspacing="0" cellpadding="2" bgcolor="#6699CC">
	<tr><td class="form_table_header" colspan="2">Administrator Login</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td width="30%">&nbsp;&nbsp;Pengguna</td><td><input type="text" size="20" name="txtlogin"></td></tr>
	<tr><td>&nbsp;&nbsp;Katalaluan</td><td><input type="password" size="20" name="txtpassword"><input type="hidden" size="10" name="txtop" value="login"></td></tr>
	<tr><td colspan="2">&nbsp;&nbsp;<input type="submit" value="Login"></td></tr>
	<tr><td align="center" colspan="2">
	<?
	    echo '<font color="#FF0000"><b>'.$errmsg.'</b></font>';
	?>
	</td></tr>
	<tr bgcolor="#ffffff"><td colspan="2">&nbsp;</td></tr>
	<tr bgcolor="#ffffff"><td align="center" colspan="2"><a href="index.php">KE LAMAN UTAMA</a><br></td></tr>	
	</table>
	</td></tr></table>
	</form>
	<br>
	</td>
    <?php 
	 }
	 else {
	 	echo "<td valign=\"top\" align=\"left\" width=\"170\">\n";
        adminmenu();
	    echo "</td>";
	    echo "<td valign=\"top\">\n";
		echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\"><tr><td>\n";

		if (isset($_REQUEST["module"]))
		  $module=$_REQUEST["module"];
		if (isset($_REQUEST["task"]))
	      $task=$_REQUEST["task"];
		if (!isset($task)) { $task="index"; }
	     adminmodule($module,$task);
		 
	     echo '</td></tr></table>';
	  }	 
	echo "</td></tr></table>";
include("footer.php");	
?> 



