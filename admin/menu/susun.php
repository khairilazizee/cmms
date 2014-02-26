<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $dbi;

  $query = "SELECT id FROM menu where admin='0' and type='menu' order by menupos "; 
  $result = sql_query($query,$dbi);
  $parent_order=0;
  while ($data=sql_fetch_array($result,$dbi)) {
     $parent_id=$data["id"];
	 $parent_order++;
	 $query="update menu set menupos=". $parent_order ." where id=$parent_id";
	 sql_query($query,$dbi);  

      $query2 = "SELECT id FROM menu where admin='0' and parent='$parent_id' order by menupos "; 
      $result2 = sql_query($query2,$dbi);
      $child_order=0;
      while ($data=sql_fetch_array($result2,$dbi)) {
         $child_id=$data["id"];
	     $child_order++;
	     $query2="update menu set menupos=". $child_order ." where id=$child_id";
	     sql_query($query2,$dbi);  
     } //child menu		 
  } //parent menu


  pageredirect("admin.php?module=menu");


?>


 
