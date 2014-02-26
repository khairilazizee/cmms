<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_GET["id"];
 sql_query("delete from content_category where id='$id'",$dbi);
 pageredirect("admin.php?module=adminkategori");
?> 
