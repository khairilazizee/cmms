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
 global $dbi;

/*
//semak menu yang telah dihapus
$query="select menu_id from menu_access group by menu_id";
 $result = sql_query($query,$dbi);
 $cnt1=0;
 while($data=sql_fetch_array($result,$dbi)){ 
   $cnt++;
   $menuid=$data[0];
   $qry="select title from menu where id='$menuid'";
   $r=sql_query($qry,$dbi);
   $d=sql_result($r,0,"title");
   echo "$cnt. id:$menuid -> $d<br>";
 }
die(); 


//semak modul yang telah dihapus
$query="select module_id from module_access group by module_id";
 $result = sql_query($query,$dbi);
 $cnt1=0;
 while($data=sql_fetch_array($result,$dbi)){ 
   $cnt++;
   $module_id=$data[0];
   $qry="select name from modules where id='$module_id'";
   $r=sql_query($qry,$dbi);
   $d=sql_result($r,0,"name");
   echo "$cnt. id:$module_id -> $d<br>";
 }
die(); 
*/

 if (isset($_POST["txt_role"])){
    $role=$_POST["txt_role"];
	$_SESSION["role"]=$role;
 }	
 else if (isset($_SESSION["role"]))
    $role=$_SESSION["role"];	
 ?>
 
 
<table width="500" border="0" bgcolor="#FFFFFF">
<TR><TD colspan="3" class="list_table_pageheader">Kemaskini Akses Menu</TD></TR>
<tr height="18" bgcolor="#EEEEEE"><td><b>Mengikut Role</b>&nbsp;&nbsp;&nbsp;<a href="admin.php?module=akses_menu&task=editrole"><b>Mengikut Menu</b></a></td></tr>
<tr><td>
<form name="frmmenu" method="post" action="admin.php?module=akses_menu&task=simpan">
<?php
    echo "Role&nbsp;&nbsp;&nbsp;<select name=\"txt_role\" onchange=\"document.frmmenu.action='admin.php?module=akses_menu';document.frmmenu.submit();\">";

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
	echo '</select></td></tr>';
?>	

<tr><td>  <table width="100%" border="0" cellspacing="1" > 
<tr><td colspan="2"></td><input name="Simpan" type="submit" value="Simpan">
	  <a href="#" onClick="return setCheckBox(true);">Check All</a>&nbsp;
	  <a href="#"  onClick="return setCheckBox(false);">Uncheck All</a>
</td></tr>
   <?
     $countmenu=getmenu(0,0,$role);
  ?>
    <tr>
    <td colspan="2" >
	  <input type="hidden" name="menucount" value="<?php echo $countmenu ?>">
	  <input name="Simpan" type="submit" value="Simpan">
	  <a href="#" onClick="return setCheckBox(true);">Check All</a>&nbsp;
	  <a href="#"  onClick="return setCheckBox(false);">Uncheck All</a>	  
	</td>
  </tr></table>
  </td></tr></form>
</table>



<?php
 function checkgrant($menuid,$roleid)
 {
    global $dbi;
	$query = "SELECT role FROM menu_access where role=$roleid and menu_id=$menuid ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
    if ($num_rows > 0 )
	  $grant=1;
	else  
	  $grant=0;
  return($grant);	  
 }
 

 function getmenu($parent,$countmenu,$roleid)
 {
    global $dbi;
    global $ncolor;
    global $hlcolor;
    global $altcolor;
 	
 	$query = "SELECT menu.id,menu.parent,menu.title FROM menu where parent=$parent and admin='0' order by menu.id ";				   
    $result = sql_query($query,$dbi);
    $num_rows = sql_num_rows($result);		

	if($num_rows > 0) {
	    while ($data=sql_fetch_array($result,$dbi)) {
                

	           if ($parent==0)	
	                echo "<tr bgcolor=\"$altcolor\">";
	           else
	                echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">";
               $id = $data["id"];
			   $menu = $data["title"];
			   $parent = $data["parent"];

			   if ($parent==0){
				   echo "<td>$menu</td><td>Benarkan?</td>";
			   }
			   else   {
				   echo "<td>&nbsp;&nbsp;&nbsp;$menu</td>";
			       $countmenu = $countmenu + 1;			       
				   if (checkgrant($id,$roleid)==1)
                      echo "<td align=\"center\" width=\"10%\"><input checked value=\"1\" type=\"checkbox\" name=\"cb$countmenu\">"; 
			       else
                      echo "<td align=\"center\"><input value=\"1\" type=\"checkbox\" name=\"cb$countmenu\">"; 
				    
					echo "<input type=\"hidden\" name=\"parentid$countmenu\" value=\"$parent\">";
					echo "<input type=\"hidden\" name=\"menuid$countmenu\" value=\"$id\">";
				    echo "</td>";
		       }   
				echo "</tr>";  
				
				if($parent==0)
				  $countmenu=getmenu($id,$countmenu,$roleid);
				} //end while 
		} 
     return $countmenu;
  }
?>