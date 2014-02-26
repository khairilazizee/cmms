<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_GET["id"];
 sql_query("delete from news where id='$id'",$dbi);
 pageredirect("admin.php?module=adminnews");
?> 
