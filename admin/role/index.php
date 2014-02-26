<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;
?>
<TABLE id="list_table" width="70%">
<TR><TD class="list_table_pageheader">Role</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
<tr><td colspan="5"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=role&task=tambah';"></td></tr>

 <?php

	$query = "SELECT id,name,defaultrole FROM role order by id ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Nama Role</td><td class=\"list_table_header\">Default</td><td class=\"list_table_header\">Tindakan</td></tr>\n";
	    while ($data=sql_fetch_array($result,$dbi)) {

                        echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">\n"; 
                            $id = $data["id"];
							$name = $data["name"];
							$def = $data["defaultrole"];
 							
                            echo "<td>$name</td>"; 
							echo "<td>$def</td>";
							if ($id==1)
							  echo "<td>&nbsp;</td>";
							else
							  echo "<td ><a href='admin.php?module=role&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=role&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
							echo "</tr>\n";
					//}
					} //end while 
					} 
					?>

</table>
					<tr><td colspan="5"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=role&task=tambah';"></td></tr>
</td></tr></table>

