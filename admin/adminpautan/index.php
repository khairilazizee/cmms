<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;
?>
<TABLE id="list_table" width="80%">
<TR><TD class="list_table_pageheader">Pautan</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">

 <?

	$query = "SELECT id,title,link,ordering FROM weblinks order by ordering ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Tajuk</td><td class=\"list_table_header\">Pautan</td><td class=\"list_table_header\">Susunan</td><td class=\"list_table_header\">Tindakan</td></tr>";
	    while ($data=sql_fetch_array($result,$dbi)) {

                   echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";

                            $id = $data["id"];
							$title = $data["title"];
							$link = $data["link"];
							$ordering = $data["ordering"];
                            echo "<td >$title</td>"; 
                            echo "<td >$link</td>"; 
							echo "<td>$ordering</td>";
							echo "<td ><a href='admin.php?module=adminpautan&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=adminpautan&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
							echo "</tr>";
						$counttsk = $counttsk + 1;
					//}
					} //end while 
					} 
					?>
					</table>
					<tr><td colspan="4"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=adminpautan&task=tambah';">
					&nbsp;<input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=adminpautan&task=susun';"></td></tr>

		</td>
	</tr>
</table>

