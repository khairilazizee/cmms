<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 //include_once("mainfile.php");
  $id=$_GET["id"];
 sql_query("delete from role where id='$id'",$dbi);
 sql_query("delete from fak_role where role='$id'",$dbi);
 sql_query("delete from module_access where role='$id'",$dbi);
 pageredirect("admin.php?module=role");
?> 
