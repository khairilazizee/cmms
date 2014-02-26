<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;

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


?>
<form name="frmmodul" method="post" action="admin.php?module=akses_modul&task=simpan">

<TABLE id="list_table" width="70%">
<TR><TD class="list_table_pageheader">Kemaskini Akses Modul</TD></TR>
<tr height="18" bgcolor="#EEEEEE"><td><b>Mengikut Role</b>&nbsp;&nbsp;&nbsp;<a href="admin.php?module=akses_modul&task=editrole"><b>Mengikut Modul</b></a></td></tr>
<tr><td>
<?

 if (isset($_POST["txt_role"])){
    $role=$_POST["txt_role"];
	$_SESSION["role"]=$role;
 }	
 else if (isset($_SESSION["role"]))
    $role=$_SESSION["role"];
		
 
	echo "<tr><td>";
    echo "Role&nbsp;&nbsp;<select name=\"txt_role\" onchange=\"document.frmmodul.action='admin.php?module=akses_modul';document.frmmodul.submit();\">";

	$query = "SELECT id,name FROM role where id <> 1 order by id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) {
	    while($data=sql_fetch_array($result,$dbi)){ 
			 
		  $id = $data["id"];
		  $name = $data["name"];
	      if (!isset($role))
	       $role=$id;
		   		  
		  if ($id==$role)
	        echo "<option selected value=\"$id\">$name</option>";
		  else
	        echo "<option value=\"$id\">$name</option>";
		}
	} 
	echo '</select>';
?>
</td></tr>
<tr><td>

<TABLE cellpadding="1" cellspacing="1" border="0" width="80%">
   <?
	echo "<tr><td class=\"list_table_header\" width=\"30%\">Nama Modul</td><td class=\"list_table_header\">Tajuk</td><td width=\"15%\" class=\"list_table_header\">Benarkan?</td></tr>\n";

	$query = "SELECT id,name,title FROM modules where public=0 and admin=0 order by title ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) 
	    $countmodule=0;
	    while ($data=sql_fetch_array($result,$dbi)) {
		   $id=$data["id"];
           $name=$data["name"];
		   $title=$data["title"];
		   $countmodule=$countmodule+1;
           echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";
		   echo "<td width=\"30%\">$name</td><td>$title</td><td align=\"center\"><input type=\"checkbox\"";
		   
		   if (checkpermission($id,$role)==1)
		      echo "checked ";
		   echo "name=\"cb$countmodule\" value=\"1\">";
		   echo "<input type=\"hidden\" name=\"moduleid$countmodule\" value=\"$id\">";		   
		   echo "</td></tr>\n";
		}   
  ?>
					
 
					</table>
					</td></tr>
					<tr><td colspan="5">
					<input type="hidden" value="<?php echo $countmodule; ?>" name="modulecount">
					<input type="submit" name="Simpan" value="Simpan">
					</td></tr>
</table>
</form>