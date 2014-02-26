<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_GET["login"];
 sql_query("delete from user where login='$id'",$dbi);
 pageredirect("admin.php?module=pengguna");
?> 
