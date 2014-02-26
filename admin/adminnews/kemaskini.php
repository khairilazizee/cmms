<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 include("FCKEditor/fckeditor.php") ;
 global $dbi;
 global $username;

    $id=$_GET["id"];
	$query = "SELECT title,datecreated,header,content,public,startdate,enddate,active FROM news where id=$id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    $data=sql_fetch_array($result,$dbi); 
        $title = $data["title"];
        $datecreated = $data["datecreated"];
		$header = $data["header"];
        $content = $data["content"];
        $public = $data["public"];
		$startdate = $data["startdate"];
		if ($startdate <> "") 
		  $startdate=substr($startdate,8,2)."-".substr($startdate,5,2)."-".substr($startdate,0,4);
		$enddate = $data["enddate"];
		if ($enddate <> "") 
		  $enddate=substr($enddate,8,2)."-".substr($enddate,5,2)."-".substr($enddate,0,4);
        $active = $data["active"];
	} 
	
 ?>
<form name="frmrole" method="post" action="admin.php?module=adminnews&task=simpan">
<table id="form_table_outer" width="700">
  <tr><td class="form_table_header">Kemaskini Berita</td></tr>
  <tr><td>
  <table id="form_table_inner" width="100%" border="0" bgcolor="#EEF3FF" cellpadding="2" cellspacing="0">
          <tr> 
            <td width="168">Penulis</td>
            <td colspan="3" ><?php echo $username; ?> <input name="txt_author"  type="hidden" size="20" maxlength="20" value="<?php echo $username; ?>"></td>
          </tr>
          <tr> 
            <td>Tajuk Berita</td>
            <td colspan="3" > <input name="txt_title"  type="text" size="80" maxlength="100" value="<?php echo $title; ?>"></td>
          </tr>
          <tr> 
            <td>Papar Di Muka Depan Dari</td>
            <td width="125"><input type="text" name="txt_startdate" size="10" maxlength="10" value="<?php echo $startdate; ?>">
		  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmrole.txt_startdate);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
			</td>
            <td width="57">Hingga</td>
            <td width="326"><input type="text" name="txt_enddate" size="10" maxlength="10" value="<?php echo $enddate; ?>">
		  <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmrole.txt_enddate);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
			</td>
          </tr>
          <tr> 
            <td>Paparan Umum</td>
            <td colspan="3"> 
              <?php 
	    if ($public==1)
		  echo "<input name=\"txt_public\"  checked type=\"checkbox\" value=\"1\">";
		else
		  echo "<input name=\"txt_public\"  type=\"checkbox\" value=\"1\">";
	  ?>
            </td>
          </tr>
          <tr> 
            <td>Aktif</td> 
            <td colspan="3">   <?php 
	    if ($active==1)
		  echo "<input name=\"txt_active\"  checked type=\"checkbox\" value=\"1\">";
		else
		  echo "<input name=\"txt_active\"  type=\"checkbox\" value=\"1\">";
	  ?>
            </td>
          </tr>
          <tr> 
            <td  colspan="4" valign="top"><br>Ringkasan Berita
              <?php 
	     $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_header') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= $header ;
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
         $oFCKeditor->Value		= $content;
         $oFCKeditor->Create() ; 
	  ?>
            </td>
          </tr>
          <tr> 
            <td colspan="4"> <input name="dbtrans" type="hidden" value="1"> <input type="hidden" name="id" value="<?=$id?>"> 
              <input name="Simpan" type="submit" value="Simpan"> <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminnews';"> 
            </td>
          </tr>
        </table>
  </td></tr></table>
</form>
<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>