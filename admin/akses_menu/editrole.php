<script type="text/javascript">
function setCheckBox(flg)
{
var cnt=document.frmmenu.menucount.value;
for(i=1;i<=cnt;i++){
 elts=document.forms['frmmenu'].elements['cb'+i];
 elts.checked=flg;
}
return false;
}
</script>
<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

if ($_GET["simpan"]==1){
?>
<script type="text/javascript">
alert('Rekod berjaya disimpan.')
</script>
<?php
}
 global $dbi;
 
 $parentid=$_REQUEST["txt_parent"];
 $menuid=$_REQUEST["txt_menu"];
 if (isset($parentid))
   $_SESSION["parent"]=$parentid;
 else {
   if (isset($_SESSION["parent"]))
     $parentid=$_SESSION["parent"];
 }

 if (isset($menuid))
   $_SESSION["menu"]=$menuid;
 else {
   if (isset($_SESSION["menu"]))
     $menuid=$_SESSION["menu"];
 }
      
 function checkgrant($m_id,$roleid)
 {
    global $dbi;
	$query = "SELECT role FROM menu_access where role=$roleid and menu_id=$m_id ";
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
 	
 	$query = "SELECT id,name FROM role where id <> 1 order by name ";
    $result = sql_query($query,$dbi);
    $num_rows = sql_num_rows($result);		
    echo "<tr bgcolor=\"$altcolor\"><td>Role</td><td>Benarkan?</td></tr>";

	if($num_rows > 0) {
	    while ($data=sql_fetch_array($result,$dbi)) {
                

	           echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">";
               $id = $data["id"];
			   $role = $data["name"];

			   echo "<td>&nbsp;&nbsp;&nbsp;$role</td>";
			   $countmenu = $countmenu + 1;
				if (checkgrant($m_id,$id)==1)
                      echo "<td align=\"center\" width=\"10%\"><input checked value=\"1\" type=\"checkbox\" name=\"cb$countmenu\">"; 
			     else
                      echo "<td align=\"center\"><input value=\"1\" type=\"checkbox\" name=\"cb$countmenu\">"; 
				    
					echo "<input type=\"hidden\" name=\"roleid$countmenu\" value=\"$id\">";
				    echo "</td>";

					  
		       }   

				echo "</tr>";  
				
		} 
     return $countmenu;
  }
 ?>
 
 

<form name="frmmenu" method="post" action="admin.php?module=akses_menu&task=simpanrole">
<TABLE id="list_table" width="55%">
<TR><TD colspan="3" class="list_table_pageheader">Kemaskini Akses Menu</TD></TR>
<tr height="18" bgcolor="#EEEEEE"><td colspan="3"><a href="admin.php?module=akses_menu"><b>Mengikut Role</b></a>&nbsp;&nbsp;&nbsp;<b>Mengikut Menu</b></td></tr>
<tr><td>Kategori</td><td>:</td><td>
<?php
 	$query = "SELECT id,title FROM menu where admin='0' and parent='0' order by menupos ";
    $result = sql_query($query,$dbi);
    $num_rows = sql_num_rows($result);
	echo "<select name=\"txt_parent\" onChange=\"document.frmmenu.action='admin.php?module=akses_menu&task=editrole';document.frmmenu.submit();\">";		
	if($num_rows > 0) {
	    $cnt=0;
	    while ($data=sql_fetch_array($result,$dbi)) {
		    $cnt++;
		    $p_id=$data[0];
			$parent=$data[1];
			if ($cnt==1){
			  if (!isset($parentid))
			     $parentid=$p_id;
			}
			if ($parentid==$p_id)
               echo "<option selected value=\"$p_id\">$parent</option>";
			else
               echo "<option value=\"$p_id\">$parent</option>";
        }
	}	
?>
</td></tr>
<tr><td>Menu</td><td>:</td><td>
<?php
 	$query = "SELECT id,title FROM menu where admin='0' and parent=$parentid order by menupos ";
    $result = sql_query($query,$dbi);
    $num_rows = sql_num_rows($result);
	echo "<select name=\"txt_menu\" onChange=\"document.frmmenu.action='admin.php?module=akses_menu&task=editrole';document.frmmenu.submit();\">";
	$cnt=0;		
	if($num_rows > 0) {
	    while ($data=sql_fetch_array($result,$dbi)) {
		    $cnt++;
		    $m_id=$data[0];
			$menu=$data[1];
			
			if ($cnt==1){
			  if (!isset($menuid))
			     $menuid=$m_id;
			}
			if ($menuid==$m_id)
               echo "<option selected value=\"$m_id\">$menu</option>";
            else			
               echo "<option value=\"$m_id\">$menu</option>";
			
			
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
     $countmenu=getrole($menuid);
  ?>
					
 
    <tr>
    <td colspan="2" >

	  <input type="hidden" name="menucount" value="<?php echo $countmenu ?>">
	  <input name="Simpan" type="submit" value="Simpan">&nbsp;
	  <a href="#" onClick="return setCheckBox(true);">Check All</a>&nbsp;
	  <a href="#"  onClick="return setCheckBox(false);">Uncheck All</a>
	</td>
  </tr></table>
  </td></tr></table>
</form>
