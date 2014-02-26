<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $dbi;

  $query = "SELECT id FROM blocks order by ordering "; 
  $result = sql_query($query,$dbi);
  $order=0;
  while ($data=sql_fetch_array($result,$dbi)) {
     $id=$data["id"];
	 $order++;
	 $query="update blocks set ordering=". $order ." where id=$id";
	 sql_query($query,$dbi);  
     //echo "$query<br>";
  } //parent menu


  pageredirect("admin.php?module=block");


?>


 
