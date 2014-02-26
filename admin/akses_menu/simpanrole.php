<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;

 function grantmodule($roleid,$menuid)
 {
    global $dbi;
	$query = "SELECT menu.type,modules.id FROM menu inner join modules on menu.module=modules.name where menu.id=$menuid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 ){
	  $type=sql_result($result,0,"type");
	  $module_id=sql_result($result,0,"id");
    }
	if ($type=='modul'){	   
	    if (checkmoduleaccess($roleid,$module_id)==0){
            $qry="insert into module_access(role,module_id) values('$roleid','$module_id')"; 
		    sql_query($qry,$dbi);	   
	    }	
	} //type==modul
 }

 function revokemodule($roleid,$menuid)
 {
    global $dbi;
	$query = "SELECT menu.type,modules.id FROM menu inner join modules on menu.module=modules.name where menu.id=$menuid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 ){
	  $type=sql_result($result,0,"type");
	  $module_id=sql_result($result,0,"id");
    }
	if ($type=='modul'){
        $qry="delete from module_access where role='$roleid' and  module_id='$module_id'"; 
		sql_query($qry,$dbi);	   
	}
 }
 
 function checkmoduleaccess($roleid,$moduleid)
 {
    global $dbi;
	$query = "SELECT role FROM module_access where role=$roleid and menu_id=$moduleid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 )
	  $exist=1;
	else  
	  $exist=0;
  return($exist); 
 }
 
 
 function checkmenuaccess($roleid,$menuid)
 {
    global $dbi;
	$query = "SELECT role FROM menu_access where role=$roleid and menu_id=$menuid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 )
	  $exist=1;
	else  
	  $exist=0;
  return($exist); 
 }
 
  function deleteparent($roleid,$parentid)
 {

    global $dbi;
	$query = "SELECT menu_id FROM menu_access,menu WHERE role = $roleid AND menu_id=menu.id and menu.parent = $parentid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);

    if ($num_rows == 0 ) {
	   $qry1="delete from menu_access where role=$roleid and  menu_id=$parentid";
	   sql_query($qry1,$dbi);
    }
 }

  $menucount=$_REQUEST["menucount"];  
  $menuid=$_REQUEST["txt_menu"];  
  $parentid=$_REQUEST["txt_parent"];
  for ($cnt=1;$cnt<=$menucount;$cnt++){
     $grant=$_REQUEST["cb$cnt"];
	 $roleid=$_REQUEST["roleid$cnt"]; 
	 if ($grant=="1") {
	   if (checkmenuaccess($roleid,$menuid)==0) {
           $qry="insert into menu_access(role,menu_id) values('$roleid','$menuid')"; 
           sql_query($qry,$dbi);
		   if (checkmenuaccess($roleid,$parentid)==0){
              $qry="insert into menu_access(role,menu_id) values('$roleid','$parentid')"; 
			  sql_query($qry,$dbi);
		   }
	   }	 
      grantmodule($roleid,$menuid);		   
	 }  //grant==1 	   
     else {		   
       $qry="delete from menu_access where role=$roleid and menu_id=$menuid"; 
       sql_query($qry,$dbi);
       revokemodule($roleid,$menuid);
	   deleteparent($roleid,$parentid);
	 }  
	  
  } //for
 pageredirect("admin.php?module=akses_menu&task=editrole&simpan=1");
?> 
