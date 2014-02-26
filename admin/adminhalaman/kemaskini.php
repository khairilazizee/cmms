<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 include("FCKEditor/fckeditor.php") ; 
 global $dbi;
 
 $id=$_REQUEST["id"];
 $jenis=$_REQUEST["txt_jenis"];
 if (!isset($jenis))
   $jenis="lampiran";
   
 $title=$_REQUEST["txt_title"];
 $ptj_only=$_REQUEST["txt_ptj_only"];
 if (!isset($ptj_only))
    $ptj_only=0;
 $active=$_REQUEST["txt_active"];
 if (!isset($active))
   $active=0;
   
 $j[0]="lampiran";
 $j[1]="maklumat";

$query = "SELECT content_pages.title,category,content_category.title as cat_title,content,
          ptj_only,active,author FROM content_pages,content_category where content_category.id=content_pages.category and content_pages.id='$id' ";
$result = sql_query($query,$dbi);
$num_rows = sql_num_rows($result);
		
if($num_rows > 0) {
  while($data=sql_fetch_array($result,$dbi)){ 
     $title = $data["title"];
	 $category_title = $data["cat_title"];
	 $content=$data["content"];
	 $category=$data["category"];
     $ptj_only = $data["ptj_only"];
     $active = $data["active"];
     $author = $data["author"];	 
  }
}
		  
 ?>
<form name="frmhalaman" method="post" action="admin.php?module=adminhalaman&task=simpan">
<table id="form_table_outer" width="80%">
  <tr><td class="form_table_header">Kemaskini Halaman</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
    <tr> 
      <td width="20%">Kategori</td>
      <td>
	    <input name="id" type="hidden" value="<?php echo $id; ?>"> 
	    <input name="txt_category"  type="hidden" size="20" maxlength="20" value="<?php echo $category; ?>"> 
        <?php echo $category_title; ?></td>
    </tr>
	<tr> 
      <td>Penulis</td>
      <td><input name="txt_author"  type="hidden" size="20" maxlength="20" value="<?php echo $author; ?>"> 
        <?php echo $author; ?></td>
    </tr>
    <tr> 
      <td>Tajuk Halaman</td>
      <td><input name="txt_title"  type="text" size="50" maxlength="50" value="<?php echo $title; ?>"></td>
    </tr>
    <tr> 
      <td>Staf PTj/Fakulti Sahaja</td>
 <?php
     if ($ptj_only==1)
      echo "<td><input type=\"checkbox\" checked name=\"txt_ptj_only\" value=\"1\"></td>";
	 else	  
      echo "<td><input type=\"checkbox\" name=\"txt_ptj_only\" value=\"1\"></td>";
 ?>	  </tr><tr>
      <td>Aktif</td>
 <?php
     if ($active==1)
      echo "<td><input type=\"checkbox\" checked name=\"txt_active\" value=\"1\"></td>";
	 else	  
      echo "<td><input type=\"checkbox\" name=\"txt_active\" value=\"1\"></td>";
 ?>	  
    </tr>
	<tr><td colspan="2">
	<?
		 $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_content') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= "$content" ;
		 $oFCKEditor->Height = 500;
         $oFCKeditor->Create() ;
	?>	 
	</td></tr>	
    <tr> 
      <td colspan="2" > 
	    <input name="dbtrans" type="hidden" value="1"> 
		<input name="Simpan" type="submit" value="Simpan"> 
        <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminhalaman';"> 
      </td>
    </tr>
  </table></td></tr></table>
</form>
