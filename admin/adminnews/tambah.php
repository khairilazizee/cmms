<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 include("FCKEditor/fckeditor.php") ; 
 global $dbi;
 global $username;
 ?>
<form name="frmrole" method="post" action="admin.php?module=adminnews&task=simpan">
<table id="form_table_outer" width="90%">
  <tr><td class="form_table_header">Tambah Berita</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%" border="0" bgcolor="#EEF3FF" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="16%">Penulis</td>
            <td  colspan="4"><?php echo $username; ?> <input name="txt_author"  type="hidden" size="20" maxlength="20" value="<?php echo $username; ?>"></td>
          </tr>
          <tr> 
            <td>Tajuk Berita</td>
            <td  colspan="4"><input name="txt_title"  type="text" size="100" maxlength="100"></td>
          </tr>
          <tr> 
            <td>Paparan Umum</td>
            <td colspan="4"><input name="txt_public"  type="checkbox" value="1"></td>
          </tr>
          <tr> 
            <td>Papar Di Muka Depan Dari</td>
            <td width="125"><input type="text" name="txt_startdate" size="10" maxlength="10">
		  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmrole.txt_startdate);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
			</td>
            <td width="57">Hingga</td>
            <td width="326"><input type="text" name="txt_enddate" size="10" maxlength="10">
		  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmrole.txt_enddate);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
			</td>
          </tr>
          <tr> 
            <td>Aktif</td>
            <td colspan="4"><input name="txt_active"  type="checkbox" value="1"></td>
          </tr>
          <tr> 
            <td  colspan="4" valign="top"><br>Ringkasan Berita
              <?php 
	     $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_header') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= "" ;
         $oFCKeditor->Create() ;
         echo "</td></tr>";
		 ?>
            </td>
          </tr>
		  <tr> 
            <td colspan="4" valign="top"><br>Berita
              <?php 
	     $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_content') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= "" ;
         $oFCKeditor->Create() ;
         echo "</td></tr>";
		 ?>
            </td>
          </tr>
          <tr> 
            <td colspan="4"> <input name="dbtrans" type="hidden" value="0"> <input name="Simpan" type="submit" value="Simpan"> 
              <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminnews';"> 
            </td>
          </tr>
        </table>
</td></tr></table>  
</form>
<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>