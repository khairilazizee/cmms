<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
global $username;
global $dbi;

function displayrecord($data,$submenu)
{
global $ncolor;
global $hlcolor;
global $altcolor;
global $dbi;
  if ($submenu==1)
    echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">"; 
  else
    echo "<tr bgcolor='$altcolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$altcolor'\">"; 

  $parentid = $data["id"];
  $menu = $data["title"];
  $jenis = $data["type"]; 
  $aktif = $data["active"];
  $admin = $data["admin"];
  $menupos = $data["menupos"];
  
  echo "<td>";
  if ($submenu==1)
    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  else {
     $resmenu=sql_query("select * from menu where parent='$parentid'",$dbi);
	 $cntsubmenu=sql_num_rows($resmenu);
  }	 
  echo "$menu</td>";
  echo "<td>$jenis</td>"; 
  echo "<td>$menupos</td>";
  echo "<td>$aktif</td>";
  echo "<td><a href='admin.php?module=menu&task=kemaskini&id=$parentid'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>";
  if ($submenu==1 or ($submenu==0 and $cntsubmenu==0)) //papar butang hapus jika menu tiada submenu
     echo "&nbsp;&nbsp;<a href='admin.php?module=menu&task=hapus&id=$parentid' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";

  echo "</tr>";
}

?>
<TABLE id="list_table" width="80%">
<TR><TD class="list_table_pageheader">Menu Pengguna</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
<tr><td colspan="4"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=menu&task=tambah';">&nbsp;<input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=menu&task=susun';"></td></tr>

 <?

	$query = "SELECT id,title,type,active,menupos,admin FROM menu where type='menu' and admin='0' order by menupos ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr bgcolor='#6699CC''><td>Tajuk</td><td>Jenis</td><td>Susunan<td>Aktif ?</td><td>Tindakan</td></tr>";
	    while ($data=sql_fetch_array($result,$dbi)) {
             $parentid=$data["id"];
			 displayrecord($data,0);
			 
	         $qrysubmenu = "SELECT id,title,type,active,menupos,admin FROM menu where parent='$parentid' order by menupos ";
			 $result_submenu = sql_query($qrysubmenu,$dbi);
	         $num_rows_submenu = sql_num_rows($result_submenu);
	
	         if($num_rows_submenu > 0) {
	            while ($data_submenu=sql_fetch_array($result_submenu,$dbi)) 
			       displayrecord($data_submenu,1);
			 } //if $num_rows_submenu	

	} //end while 
   } //if $num_rows > 0 
		?>
   </table>					
		<tr><td colspan="4"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=menu&task=tambah';">&nbsp;<input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=menu&task=susun';"></td></tr>

		</td>
	</tr>
</table>

