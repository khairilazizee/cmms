<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;

?>

<TABLE id="list_table" width="70%">
<TR><TD class="list_table_pageheader">Kategori</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">

 <?

	$query = "SELECT id,title,nama_fak FROM content_category left join fak on kod_fak=fakulti order by id ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Tajuk Kategori</td><td class=\"list_table_header\">Fakulti</td><td class=\"list_table_header\">Tindakan</td></tr>";
	    while ($data=sql_fetch_array($result,$dbi)) {
                   echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";
                            $id = $data["id"];
							$title = $data["title"];
							$fakulti = $data["nama_fak"];
                            echo "<td >$title</td>"; 
                            echo "<td >$fakulti</td>"; 
							echo "<td ><a href='admin.php?module=adminkategori&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=adminkategori&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
							echo "</tr>";
					//}
					} //end while 
					} 
					?>
					</table>
					<tr><td><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=adminkategori&task=tambah';"></td></tr>

		</td>
	</tr>
</table>


