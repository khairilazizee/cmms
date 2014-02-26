<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 include("FCKEditor/fckeditor.php") ; 
 global $dbi;
 $jenis=$_REQUEST["txt_jenis"];
 if (!isset($jenis))
   $jenis="lampiran";
   
 $category=$_REQUEST["txt_kategori"];
 $title=$_REQUEST["txt_title"];
 $ptj_only=$_REQUEST["txt_ptj_only"];
 if (!isset($ptj_only))
    $ptj_only=0;
 $active=$_REQUEST["txt_active"];
 if (!isset($active))
   $active=0;
   
 $j[0]="lampiran";
 $j[1]="maklumat";

$query = "SELECT title FROM content_category where id='$category' ";
$result = sql_query($query,$dbi);
$num_rows = sql_num_rows($result);
		
if($num_rows > 0) {
  while($data=sql_fetch_array($result,$dbi)){ 
	 $category_title = $data["title"];
  }
}
		  
 ?>
<form name="frmkandungan" method="post" action="admin.php?module=adminhalaman&task=simpan">
<table id="form_table_outer" width="80%">
  <tr><td class="form_table_header">Tambah Halaman</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
    <tr> 
      <td width="20%">Kategori</td>
      <td ><input name="txt_category"  type="hidden" size="20" maxlength="20" value="<?php echo $category; ?>"> 
        <?php echo $category_title; ?></td>
    </tr>
    <tr> 
      <td>Penulis</td>
      <td ><input name="txt_author"  type="hidden" size="20" maxlength="20" value="<?php echo $username; ?>"> 
        <?php echo $username; ?></td>
    </tr>
    <tr> 
      <td>Tajuk Halaman</td>
      <td ><input name="txt_title"  type="text" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td>Staf PTj/Fakulti Sahaja</td>
      <?php	  
      echo "<td><input type=\"checkbox\" name=\"txt_ptj_only\" value=\"1\"></td>";
      ?>
	  </tr><tr>
      <td>Aktif</td>
      <?php  
      echo "<td><input type=\"checkbox\" name=\"txt_active\" value=\"1\"></td>";
 ?>
    </tr>
	<tr><td colspan="2">
	<?
		 $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_content') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= "" ;
         $oFCKeditor->Create() ;
	?>	 
	</td>
	</tr>
    <tr> 
      <td colspan="2" > <input name="dbtrans" type="hidden" value="0"> 
	    <input name="Simpan" type="submit" value="Simpan"> 
        <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminhalaman';"> 
      </td>
    </tr>
  </table></td></tr></table>
</form>
