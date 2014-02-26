<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 
 $query = "SELECT max(ordering) as maxorder FROM maklumat_am";
 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);
 $max=sql_result($result,0,"maxorder");
 if ($max=="")
   $max=1;
 else
   $max=$max+1;
   
 $category=$_POST["txt_kategori"];
 $tajuk=$_POST["txt_title"];
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
    <td width="89%"><input name="txt_title"  value="<?php echo $tajuk; ?>" type="text" size="50" maxlength="50"></td>
  </tr>
  <tr>
    <td width="11%">Kategori</td>
    <td width="89%">
	<?php
    echo "<select name=\"txt_kategori\" onchange=\"document.frm1.action='admin.php?module=maklumat_am&task=tambah';document.frm1.submit();\">";

	$query = "SELECT id,title FROM content_category order by id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) {
	    $cnt_category=0;
	    while($data=sql_fetch_array($result,$dbi)){ 
		  $cnt_category++;	 
		  $id = $data["id"];
		  $title = $data["title"];
		  if (!isset($category)){
		    if ($cnt_category==1)
			  $category=$id;
		  }
		  if ($id==$category)
	        echo "<option selected value=\"$id\">$title</option>";
		  else
	        echo "<option value=\"$id\">$title</option>";
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
			 
		  $id = $data["id"];
		  $title = $data["title"];
		  
		  if ($id==$pages)
	        echo "<option selected value=\"$id\">$title</option>";
		  else
	        echo "<option value=\"$id\">$title</option>";
		}
	} 
	echo "</select>";
	?>	
	</td>
  </tr>

  <tr>
    <td colspan="2" >
	  <input name="txt_link"  value="<?php echo $pautan; ?>" type="hidden" size="50" maxlength="50">
	  <input type="hidden" name="txt_ordering" value="<?php echo $max ?>" size="5">
	  <input name="dbtrans" type="hidden" value="0">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=maklumat_am';">
	</td>
  </tr></table>
  </td></tr></table>
</form>
