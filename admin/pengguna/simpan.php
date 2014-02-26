<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $login=$_REQUEST["txt_login"];
  $password=md5($_REQUEST["txt_password"]);
  $name=$_REQUEST["txt_name"];  
  $role=$_REQUEST["txt_role"];
  $bahagian=$_REQUEST["txt_bahagian"];
  $unit=$_REQUEST["txt_unit"];
  $dbtrans=$_REQUEST["dbtrans"];  
  $now = date("Y-m-d G:i:s");
  if ($dbtrans=="0") //insert
   $qry="INSERT INTO `user` (`login`,`password`,`role`,`nama`,`bahagian`,`unit`,`regdate`,`lastlogin`) 
         VALUES ('$login','$password','$role','$name','$bahagian','$unit','$now', '0000-00-00 00:00:00')";
  else {
     if ($password=="")
     	$qry="update `user` set `role`='$role',`nama`='$name',`bahagian`='$bahagian',`unit`='$unit' where login='$login'"; 
	 else
     	$qry="update `user` set `password`='$password',`role`='$role',`nama`='$name',`bahagian`='$bahagian',
			`unit`='$unit' where login='$login'"; 
  }		   
  
  sql_query($qry,$dbi);
  //die ($qry);
  pageredirect("admin.php?module=pengguna");
  
?>


 
   
