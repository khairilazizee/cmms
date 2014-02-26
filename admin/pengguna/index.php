<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;
global $modname;
$login=$_REQUEST["login"];
$nama=$_REQUEST["nama"];

?>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
<form name="frmcarian" method="post" action="admin.php?module=pengguna">
<tr><td colspan="6"><b>Carian Pengguna</b></td></tr>
<tr><td colspan="2">Mengikut LoginID</td><td width="1%">:</td><td width="77%"><input type="text" name="login" size="40" /></td></tr>
<tr><td colspan="2">Mengikut Nama Pengguna</td><td>:</td><td><input type="text" name="nama" size="40" /></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="Mula Carian" /></td>
      <td colspan="4"><font size="1"><strong>Kosongkan kedua-dua kotak jika ingin 
        memaparkan semua pengguna</strong></font></td>
    </tr>
</form>
</table>
<hr>
<TABLE id="list_table" width="90%">
<TR><TD class="list_table_pageheader">Pengguna</TD></TR>
<tr>
	<td><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=pengguna&task=tambah';"></td>
</tr>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
 <?php
if($login=="" && $nama==""){
	$query = "SELECT login,nama,role.name FROM user left join role on user.role=role.id 
		where user.id<>1 order by nama";
	} elseif($login!="") {
	$query = "SELECT login,nama,role.name FROM user left join role on user.role=role.id 
		where user.id<>1 and login like '%$login%' order by nama";

	} elseif($nama!="") {
	$query = "SELECT login,nama,role.name,fak.NAMA_FAK,jab.NAMA_JAB FROM user left join role on user.role=role.id 
		 where user.id<>1 and nama like '%$nama%' order by nama";

} else {
	$query = "SELECT login,nama,role.name FROM user left join role on user.role=role.id 
		where user.id<>1 
		and login like '%$login%' and nama like '%$nama%' order by nama";

}

	//echo $query;			   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\" width='5'>Bil</td><td class=\"list_table_header\" width='20%'>Login</td><td  class=\"list_table_header\" width='40%'>Nama</td><td class=\"list_table_header\" >Bahagian</td>
		     <td class=\"list_table_header\" >Unit</td><td class=\"list_table_header\" >Role</td><td class=\"list_table_header\" >Tindakan</td></tr>\n";
		$count=0;
	    while ($data=sql_fetch_array($result,$dbi)) {
						$userlogin = $data["login"];
						$username = $data["nama"];
						$bahagian = $data["NAMA_FAK"];
						$unit = $data["NAMA_JAB"];
						$rolename = $data["name"];
						$count++;
                        echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";
			            echo "<td>$count</td>";
                        echo "<td >$userlogin</td>"; 
                        echo "<td >$username</td>"; 
                        echo "<td >$bahagian</td>"; 
                        echo "<td >$unit</td>"; 
                        echo "<td >$rolename</td>"; 
						echo "<td ><a href='admin.php?module=pengguna&task=kemaskini&login=$userlogin'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=pengguna&task=hapus&login=$userlogin' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
						echo "</tr>\n";
					
					} //end while 
					} 
					?>
					

</table>
					<tr><td><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=pengguna&task=tambah';"></td></tr>
</table>

