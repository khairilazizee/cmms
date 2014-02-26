<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 include("FCKEditor/fckeditor.php") ; 
 global $dbi;

 $query = "SELECT max(ordering) as maxorder FROM announcement";
 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);
 $max=sql_result($result,0,"maxorder");
 $startdate= date("d/m/Y");
 $y=(int) substr($startdate,6,4);
 $y+=1;
 $enddate=substr($startdate,0,6).$y;
 if ($max=="")
   $max=1;
 else
   $max=$max+1;

 ?>
<form name="frmrole" method="post" action="admin.php?module=pengumuman&task=simpan">
<table id="form_table_outer" width="80%">
  <tr><td class="form_table_header">Tambah Pengumuman</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">

  <tr>
    <td>Tajuk</td>
    <td><input name="txt_title"  type="text" size="50" maxlength="50"></td>
  </tr>
    <tr> 
      <td width="20%" valign="top">Pengumuman</td>
      <td width="80%">              <?php 
	     $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_aktiviti') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= "" ;
         $oFCKeditor->Create() ;
         echo "</td></tr>";
		 ?></td>
    </tr>
	<tr>
	 <td>Tarikh Mula</td>
	 <td><input type="textbox" name="txt_trkhmula" value="<?php echo $startdate; ?>" size="12" maxlength="10">
              (DD/MM/YYYY )</td>
	</tr>
	<tr>
	 <td>Tarikh Akhir</td>
	 <td><input type="textbox" name="txt_trkhakhir" value="<?php echo $enddate; ?>" size="12" maxlength="10">
              (DD/MM/YYYY )</td>
	</tr>	
  <tr>
    <td colspan="2" >
	  <input type="hidden" name="txt_ordering"  value="<?php echo $max; ?>"size="5">
	  <input name="dbtrans" type="hidden" value="0">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=pengumuman';">
	</td>
  </tr></table></td></tr></table>
</form>
