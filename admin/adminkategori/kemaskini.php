<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
    $id=$_GET["id"];
	$query = "SELECT title,fakulti FROM content_category where id=$id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    $data=sql_fetch_array($result,$dbi); 
        $title = $data["title"];
		$fak = $data["fakulti"];
	} 
	
?>
<form name="frmrole" method="post" action="admin.php?module=adminkategori&task=simpan&id=<? echo $id ?>">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Kemaskini Kategori</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
  <tr>
    <td width="20%">Tajuk Kategori</td>
    <td width="80%"><input name="txt_title" value="<?php echo $title ?>" type="text" size="50" maxlength="50"></td>
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
		  if ($fak==$kodfak)
	        echo "<option selected value=\"$kodfak\">$namafak</option>";
		  else
	        echo "<option value=\"$kodfak\">$namafak</option>";
		}
	} 
	?>
        </select></td>  
  <tr>  
    <td colspan="2" >
	    <input type="hidden" name="dbtrans" value="1">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminkategori';">
	</td>
  </tr>
  </table>
</td></tr></table>
</form>
