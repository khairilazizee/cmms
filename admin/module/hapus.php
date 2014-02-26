<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_GET["id"];
 sql_query("delete from modules where id='$id'",$dbi);
 sql_query("delete from module_access where module_id='$id'",$dbi);
 pageredirect("admin.php?module=module");
?> 
