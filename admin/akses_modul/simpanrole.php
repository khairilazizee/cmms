<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 
 function checkmodulaccess($roleid,$modulid)
 {
    global $dbi;
	$query = "SELECT role FROM modul_access where role=$roleid and modul_id=$modulid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 )
	  $exist=1;
	else  
	  $exist=0;
  return($exist); 
 }
 

  $modulcount=$_REQUEST["modulcount"];  
  $modulid=$_REQUEST["txt_modul"];  
  for ($cnt=1;$cnt<=$modulcount;$cnt++){
     $grant=$_REQUEST["cb$cnt"];
	 $roleid=$_REQUEST["roleid$cnt"]; 
	 if ($grant=="1") {
	   if (checkmodulaccess($roleid,$modulid)==0) {
           $qry="insert into module_access(role,module_id) values('$roleid','$modulid')"; 
           sql_query($qry,$dbi);
		   //echo "$qry<br>";
	   }	 
	 }   	   
     else {		   
       $qry="delete from module_access where role=$roleid and module_id=$modulid"; 
       sql_query($qry,$dbi);
	   //echo "$qry<br>";
	 }  
	  
  } //for

?>
<script type="text/javascript">
alert('Rekod berjaya disimpan.')
</script>
<?php
 pageredirect("admin.php?module=akses_modul&task=editrole");
?> 
