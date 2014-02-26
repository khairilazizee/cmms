<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 
 function susun($menupos,$parent,$type)
 {
 
  global $dbi;
  if ($type=="menu")  
     $query = "SELECT id,menupos FROM menu where admin='0' and type='$type' and menupos > $menupos order by menupos";
  else
	 $query = "SELECT id,menupos FROM menu where admin='0' and parent='$parent' and menupos > $menupos order by menupos";
	 
  //echo $query."<br>";
  $result = sql_query($query,$dbi);
  while ($data=sql_fetch_array($result,$dbi)) {
     $id=$data["id"];
	 $ord=$data["menupos"];
     $ord--;		
	 $query="update menu set menupos=". $ord ." where id=$id";

	 sql_query($query,$dbi);  
	 //echo $query."<br>";
  }
} //function susun  

 
  $id=$_GET["id"];
  $query = "SELECT menupos,parent,type FROM menu where id=$id ";
  $result = sql_query($query,$dbi);
  $data=sql_fetch_array($result,$dbi);
  $menupos=$data["menupos"];
  $parent=$data["parent"];
  $type=$data["type"];
  susun($menupos,$parent,$type); 
 sql_query("delete from menu where id='$id'",$dbi);
 sql_query("delete from menu_access where menu_id='$id'",$dbi);
  pageredirect("admin.php?module=menu");
?> 
