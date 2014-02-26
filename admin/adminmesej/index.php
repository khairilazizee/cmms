<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 include("FCKEditor/fckeditor.php") ;
 global $dbi;
 global $username;

    $id=$_GET["id"];
	$query = "SELECT title,createddate,content,active FROM message where id=1 ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    $data=sql_fetch_array($result,$dbi); 
        $title = $data["title"];
        $datecreated = $data["createddate"];
        $content = $data["content"];
        $active = $data["active"];
	} 
	
 ?>
<form name="frmrole" method="post" action="admin.php?module=adminmesej&task=simpan">
<table id="form_table_outer" width="90%">
  <tr><td class="form_table_header">Kemaskini Mesej</td></tr>
  <tr><td>
  <table id="form_table_inner" width="100%" border="0" bgcolor="#EEF3FF" cellpadding="2" cellspacing="0">
      <td>Tajuk</td>
      <td >
        <input name="txt_title"  type="text" size="100" maxlength="100" value="<?php echo $title; ?>"></td>
    </tr>
	    <tr> 
      <td valign="top">Kandungan</td>
      <td>
	  <?php
         $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_content') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= $content;
         $oFCKeditor->Create() ; 
	  ?>	  
	  </td>
    </tr>

    <tr> 
      <td colspan="4" > <input name="dbtrans" type="hidden" value="1"> 
	    <input name="Simpan" type="submit" value="Simpan"> 
      </td>
    </tr>
  </table>
  </td></tr></table>
</form>
