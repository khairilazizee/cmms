<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 ?>
<form name="frmrole" method="post" action="admin.php?module=adminkategori&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Tambah Kategori</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
  <tr>
    <td width="20%">Tajuk Kategori</td>
    <td width="80%"><input name="txt_title"  type="text" size="50" maxlength="50"></td>
  </tr>
     <tr>
      <td>Fakulti</td>
      <td><select name="txt_kodfak">
	      <option>-- Pilih Fakulti --</option>
          <?php
	$query = "SELECT kod_fak,nama_fak FROM fak order by nama_fak ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) {
	    while($data=sql_fetch_array($result,$dbi)){ 
		  $kodfak = $data["kod_fak"];
		  $namafak = $data["nama_fak"];
	      echo "<option value=\"$kodfak\">$namafak</option>";
		}
	} 
	?>
        </select></td>  
  <tr>
    <td colspan="2" >
	  <input name="dbtrans" type="hidden" value="0">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminkategori';">
	</td>
  </tr></table>
</td></tr></table>
</form>
