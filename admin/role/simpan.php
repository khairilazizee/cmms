<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;


  $id=$_REQUEST["id"];  
  $name=$_REQUEST["txt_role"];  
  $def=$_REQUEST["defaultrole"];
  $dbtrans=$_REQUEST["dbtrans"];  
  if(!isset($def))
    $def=0;

  if ($dbtrans=="0")  //insert
     $qry="insert into role(name,defaultrole)
	       values('$name','$def')";
  else		   
     $qry="update role set name='$name',defaultrole='$def' where id=$id";
  sql_query($qry,$dbi);

  echo $qry."<br>";
  if ($dbtrans=="0"){ //insert
     //grant module LamanUtama
     $res2=sql_query("select id from modules where name='LamanUtama'",$dbi);
	 $moduleid=sql_result($res2,0,"id");
	 
	 $roleid=getroleid($name);
     $qry="insert into module_access(role,module_id) values($roleid,'$moduleid')";
    sql_query($qry,$dbi);
	 
  }		    
 
  pageredirect("admin.php?module=role");


function getroleid($name)
{
global $dbi;
     $res2=sql_query("select id from role where name='$name'",$dbi);
	 $roleid=sql_result($res2,0,"id");
return($roleid);	 
}

?>


 
