<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 

 function checkmoduleaccess($roleid,$moduleid)
 {
    global $dbi;
	$query = "SELECT role FROM module_access where role=$roleid and module_id=$moduleid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 )
	  $grant=1;
	else  
	  $grant=0;
  return($grant);	  
 }
 
  $modulecount=$_REQUEST["modulecount"];  
  $role=$_REQUEST["txt_role"];  

  for ($cnt=1;$cnt<=$modulecount;$cnt++){
     $grant=$_REQUEST["cb$cnt"];
	 $moduleid=$_REQUEST["moduleid$cnt"]; 
	 if ($grant=="1") {
	   if (checkmoduleaccess($role,$moduleid)==0) {
           $qry="insert into module_access(role,module_id) values('$role','$moduleid')"; 
           sql_query($qry,$dbi);
	   }	 
	 }   	   
     else {		   
       $qry="delete from module_access where role=$role and module_id=$moduleid"; 
       sql_query($qry,$dbi);
	 }  
	  
  } //for
?>
<script type="text/javascript">
alert('Rekod berjaya disimpan.')
</script>
<?php  
 pageredirect("admin.php?module=akses_modul");
?> 
