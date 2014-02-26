<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;
function checkmodule($name)
{
    global $dbi;
	
	$query = "SELECT id FROM modules where name='$name'";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);	
	if($num_rows > 0) 
	   return(1);
	else
	  return(0);
}
?>

<TABLE id="list_table" width="80%">
<TR><TD class="list_table_pageheader">Modul Pengguna</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
<tr><td colspan="6"><input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=module&task=susun';"></td></tr>
<?

	$query = "SELECT id,title,name,public,admin,active,ordering FROM modules where admin='0' order by admin,ordering";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Tajuk Modul</td>
		          <td class=\"list_table_header\">Nama Modul</td>
				  <td class=\"list_table_header\">Paparan Umum</td>
				  <td class=\"list_table_header\">Aktif?</td>
				  <td class=\"list_table_header\">Susunan</td>
				  <td class=\"list_table_header\">Tindakan</td></tr>";

	    while ($data=sql_fetch_array($result,$dbi)) {
              $id = $data["id"];
			  $title = $data["title"];
			  $name = $data["name"];
			  $public = $data["public"];
			  $admin = $data["admin"];
			  $active = $data["active"];
			  $ordering = $data["ordering"];
		      
			  if ($name=="LamanUtama" or $name=="News" or $name=="Maklumat")
			     $rowcolor="#CCCCCC";
			  else
	            $rowcolor=$ncolor;
	
	          echo "<tr bgcolor=\"$rowcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$rowcolor'\">"; 

              echo "<td >$title</td>"; 
              echo "<td >$name</td>"; 
              echo "<td >$public</td>"; 
              echo "<td >$active</td>"; 
              echo "<td >$ordering</td>"; 
			  echo "<td ><a href='admin.php?module=module&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>";
			  if (!($name=="LamanUtama" or $name=="News" or $name=="Maklumat"))
			      echo "&nbsp;&nbsp;<a href='admin.php?module=module&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a>";
			  echo "</td></tr>\n";
					//}
					} //end while 
					} 
					?>
</table></td></tr>
</table>
<br>
<TABLE id="list_table" width="70%">
<TR><TD class="list_table_pageheader">Modul Admin</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
 <?

	$query = "SELECT id,title,name,public,admin,active,ordering FROM modules where admin='1' order by admin,ordering";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
	
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Tajuk Modul</td>
		          <td class=\"list_table_header\">Nama Modul</td>
				  <td class=\"list_table_header\">Aktif?</td>
				  <td class=\"list_table_header\">Susunan</td>
				  <td class=\"list_table_header\">Tindakan</td></tr>";
	    while ($data=sql_fetch_array($result,$dbi)) {
               echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">"; 

                            $id = $data["id"];
							$title = $data["title"];
							$name = $data["name"];
							$public = $data["public"];
							$admin = $data["admin"];
							$active = $data["active"];
							$ordering = $data["ordering"];
                            echo "<td >$title</td>"; 
                            echo "<td >$name</td>"; 
                            echo "<td >$active</td>"; 
                            echo "<td >$ordering</td>"; 
							echo "<td ><a href='admin.php?module=module&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=module&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
							echo "</tr>";
						$counttsk = $counttsk + 1;
					//}
					} //end while 
					} 
					?>
<tr><td colspan="6"><input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=module&task=susun';"></td></tr>

</table></td></tr></table>
<br>
<TABLE id="list_table" width="40%">
<TR><TD class="list_table_pageheader">Modul Belum Aktif</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
 <?

	$blocksdir = dir("modules");
	    echo "<tr><td class=\"list_table_header\">Nama Modul</td>
				  <td class=\"list_table_header\">Tindakan</td></tr>\n";
		while($func=$blocksdir->read()) {
	    if($func!= ".." and $func!=".") {
		    if (checkmodule($func)==0 and file_exists("modules/$func/index.php")<>"") {
               echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">"; 
               echo "<td>$func</td>"; 
               echo "<td ><a href='admin.php?module=module&task=aktif&name=$func&flg=0'>Aktifkan</a></td>"; 
			   echo "</tr>\n";
		    }
	    }
	 }
			
	$blocksdir = dir("admin");
	while($func=$blocksdir->read()) {
	    if($func!= ".." and $func!=".") {
		    if (checkmodule($func)==0 and file_exists("admin/$func/index.php")<>"") {
               echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">"; 
               echo "<td>$func</td>"; 
               echo "<td ><a href='admin.php?module=module&task=aktif&name=$func&flg=1'>Aktifkan</a></td>"; 
			   echo "</tr>\n";
		    }
	    }
	 }
			
		

?>


</table>
</td></tr></table>

