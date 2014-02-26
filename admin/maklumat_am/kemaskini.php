<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;

 if (isset($_GET["id"])){   
	$id=$_GET["id"];
	
	$query = "SELECT id,title,link,category,pages,ordering FROM maklumat_am where id=$id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	if($num_rows > 0) {
     while ($data=sql_fetch_array($result,$dbi)) {
        $id = $data["id"];
		$title = $data["title"];
		$category = $data["category"];
		$pages= $data["pages"];	
		$ordering = $data["ordering"];	
	  }
	}
 } //isset($_GET["id...
 	
 if (isset($_POST["txt_kategori"])){   
    $category=$_POST["txt_kategori"];
    $title=$_POST["txt_title"];
	$ordering=$_POST["txt_ordering"];
	$id=$_POST["id"];
 }
  ?>
<form name="frm1" method="post" action="admin.php?module=maklumat_am&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Tambah Maklumat Am</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%" border="0" cellpadding="2" cellspacing="0">

  <tr>
    <td colspan="2"><strong>Tambah Maklumat Am Baru</strong></td>
  </tr>
  <tr>
    <td width="11%">Tajuk</td>
    <td width="89%"><input name="txt_title"  value="<?php echo $title; ?>" type="text" size="50" maxlength="50"></td>
  </tr>
  <tr>
    <td width="11%">Kategori</td>
    <td width="89%">
	<?php
    echo "<select name=\"txt_kategori\" onchange=\"document.frm1.action='admin.php?module=maklumat_am&task=kemaskini';document.frm1.submit();\">";

	$query = "SELECT id,title FROM content_category order by id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) {
	    while($data=sql_fetch_array($result,$dbi)){ 
		  $cnt_category++;	 
		  $cat_id = $data["id"];
		  $title = $data["title"];

		  if ($cat_id==$category)
	        echo "<option selected value=\"$cat_id\">$title</option>";
		  else
	        echo "<option value=\"$cat_id\">$title</option>";
		}
	} 
	echo "</select>";
	$pautan="mainpage.php?module=Maklumat&kategori=$category";
	?>	
	</td>
  </tr>
  <tr>
    <td width="11%">Halaman</td>
    <td width="89%">
	<?php
	
    echo "<select name=\"txt_halaman\" onchange=\"document.frm1.txt_link.value='mainpage.php?module=Maklumat&kategori='+document.frm1.txt_kategori.value+'&id='+document.frm1.txt_halaman.value+'&papar=1';\">";
    echo "<option value=\"\">-- Pilih Halaman --</option>";
	$query = "SELECT id,title FROM content_pages where category='$category' order by id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) {
	    while($data=sql_fetch_array($result,$dbi)){ 
			 
		  $pages_id = $data["id"];
		  $title = $data["title"];
		  
		  if ($pages_id==$pages)
	        echo "<option selected value=\"$pages_id\">$title</option>";
		  else
	        echo "<option value=\"$pages_id\">$title</option>";
		}
	} 
	echo "</select>";
	?>	
	</td>
  </tr>
    <tr>
      <td>Susunan</td>
      <td>
	  <?php
	    $query = "SELECT ordering FROM maklumat_am order by ordering ";
        $result = sql_query($query,$dbi);
	    $num_rows = sql_num_rows($result);
		echo "<select name=\"txt_ordering\">";
		if ($num_rows > 0){
			while ($data=sql_fetch_array($result,$dbi)){
				$susun=$data["ordering"];
				if ($susun==$ordering)
				  echo "<option selected value=\"$susun\">$susun</option>";
				else
				  echo "<option value=\"$susun\">$susun</option>";
		    }
		} //num_rows > 0
		echo "</select>";
		?>	  
	  </td>
    </tr>
  <tr>
    <td colspan="2" >
	  <input name="txt_link"  value="<?php echo $pautan; ?>" type="hidden" size="50" maxlength="50">
	  <input type="hidden" name="txt_old_ordering" value="<?php echo $ordering ?>">
	  <input type="hidden" name="id" value="<?php echo $id ?>">
	  <input name="dbtrans" type="hidden" value="1">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=maklumat_am';">
	</td>
  </tr></table>
  </td></tr></table>
</form>
