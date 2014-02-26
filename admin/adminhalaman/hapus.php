<?php
// capaian mesti melalui page umportal
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_GET["id"];
  $category=$_GET["category"];
  sql_query("delete from content_pages where id='$id'",$dbi);
  pageredirect("admin.php?module=adminhalaman");
?> 
