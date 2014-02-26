<script type="text/javascript">
function setCheckBox(flg)
{
var cnt=document.frmmodul.modulcount.value;
for(i=1;i<=cnt;i++){
 elts=document.forms['frmmodul'].elements['cb'+i];
 elts.checked=flg;
}
return false;
}
</script>
<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 
 $modulid=$_REQUEST["txt_modul"];
 if (isset($modulid))
   $_SESSION["modulid"]=$modulid;
 else {
   if (isset($_SESSION["modulid"]))
     $modulid=$_SESSION["modulid"];
 }
      
 function checkpermission($moduleid,$roleid)
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

 function getrole($m_id)
 {
    global $dbi;
    global $ncolor;
    global $hlcolor;
    global $altcolor;
 	
 	$query = "SELECT id,name FROM role where id<>1 order by name ";
    $result = sql_query($query,$dbi);
    $num_rows = sql_num_rows($result);		
    echo "<tr bgcolor=\"$altcolor\"><td>Role</td><td>Benarkan?</td></tr>";

	if($num_rows > 0) {
	    while ($data=sql_fetch_array($result,$dbi)) {
                

	           echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">";
               $id = $data["id"];
			   $role = $data["name"];

			   echo "<td>&nbsp;&nbsp;&nbsp;$role</td>";
			   $countmodul = $countmodul + 1;
				if (checkpermission($m_id,$id)==1)
                      echo "<td align=\"center\" width=\"10%\"><input checked value=\"1\" type=\"checkbox\" name=\"cb$countmodul\">"; 
			     else
                      echo "<td  align=\"center\"><input value=\"1\" type=\"checkbox\" name=\"cb$countmodul\">"; 
				    
					echo "<input type=\"hidden\" name=\"roleid$countmodul\" value=\"$id\">";
				    echo "</td>";

					  
		       }   

				echo "</tr>";  
				
		} 
     return $countmodul;
  }
 ?>
 
 

<form name="frmmodul" method="post" action="admin.php?module=akses_modul&task=simpanrole">
<TABLE id="list_table" width="55%">
<TR><TD colspan="3" class="list_table_pageheader">Kemaskini Akses Modul</TD></TR>
<tr height="18" bgcolor="#EEEEEE"><td><a href="admin.php?module=akses_modul"><b>Mengikut Role</b></a>&nbsp;&nbsp;&nbsp;<b>Mengikut Modul</b></td></tr>
<tr><td colspan="3">Modul : 
<?php
 	$query = "SELECT id,title FROM modules where admin='0'  order by ordering ";
    $result = sql_query($query,$dbi);
    $num_rows = sql_num_rows($result);
	echo "<select name=\"txt_modul\" onChange=\"document.frmmodul.action='admin.php?module=akses_modul&task=editrole';document.frmmodul.submit();\">";
	$cnt=0;		
	if($num_rows > 0) {
	    while ($data=sql_fetch_array($result,$dbi)) {
		    $cnt++;
		    $m_id=$data[0];
			$modul=$data[1];
			
			if ($cnt==1){
			  if (!isset($modulid))
			     $modulid=$m_id;
			}
			if ($modulid==$m_id)
               echo "<option selected value=\"$m_id\">$modul</option>";
            else			
               echo "<option value=\"$m_id\">$modul</option>";
			
			
        }
	}	
?>
</td></tr>
<tr><td colspan="3">
  <table width="100%" border="0" cellspacing="1" > 
  <tr><td colspan="2">	  
      <input name="Simpan" type="submit" value="Simpan">&nbsp;
	  <a href="#" onClick="return setCheckBox(true);">Check All</a>&nbsp;
	  <a href="#"  onClick="return setCheckBox(false);">Uncheck All</a>
</td></tr>
   <?
     $countmodul=getrole($modulid);
  ?>
					
 
    <tr>
    <td colspan="2" >

	  <input type="hidden" name="modulcount" value="<?php echo $countmodul ?>">
	  <input name="Simpan" type="submit" value="Simpan">&nbsp;
	  <a href="#" onClick="return setCheckBox(true);">Check All</a>&nbsp;
	  <a href="#"  onClick="return setCheckBox(false);">Uncheck All</a>
	</td>
  </tr></table>
  </td></tr></table>
</form>
