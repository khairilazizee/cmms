<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 


     $title=$_REQUEST["txt_tajuk"];
     $menu=$_REQUEST["txt_menu"];
	 if (!$menu){
      $query = "SELECT id FROM menu where admin='1' and type='menu' order by menupos";
      $result = sql_query($query,$dbi);
      $menu=sql_result($result,0,"id");	 
	 }
     $pautan=$_REQUEST["txt_pautan"];
     $aktif=$_REQUEST["txt_aktif"];

     $image=$_REQUEST["txt_imej"];
	 $jenis=$_REQUEST["txt_jenis"];

 if (!$jenis)
   $jenis="modul";
 
 if ($jenis=="menu")  
    $query = "SELECT max(menupos) as maxorder FROM menu where admin='1' and type='$jenis'";
 else
    $query = "SELECT max(menupos) as maxorder FROM menu where admin='1' and parent='$menu'";

 if ($jenis=="pautan")
   $targetwindow="_blank";
 else
   $targetwindow="_top";
 
 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);
 $max=sql_result($result,0,"maxorder");
 if ($max=="")
   $max=1;
 else
   $max=$max+1;
 $susunan=$max;	 
 ?>
<form name="frmmenu" method="post" action="admin.php?module=menu_admin&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Tambah Menu Admin</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%" border="0" bgcolor="#EEF3FF" cellpadding="2" cellspacing="0">
          <?php
	  $jenismenu[0]="modul";
	  $jenismenu[1]="menu";

	  $labeljenis[0]="Modul";
	  $labeljenis[1]="Menu";

	  echo "<td>Jenis</td>";
      echo "<td colspan=\"3\"><select name=\"txt_jenis\" onChange=\"document.frmmenu.action='admin.php?module=menu_admin&task=tambah';document.frmmenu.submit();\">";
	  for ($idx=0;$idx<2;$idx++){
	      if ($jenis==$jenismenu[$idx])
            echo "<option selected value=\"$jenismenu[$idx]\">$labeljenis[$idx]</option>";
		  else
            echo "<option value=\"$jenismenu[$idx]\">$labeljenis[$idx]</option>";
	  }	  
      echo "</select></td></td></tr>";
	?>
          <tr> 
            <td width="20%">Tajuk Menu</td>
            <td width="80%" ><input name="txt_tajuk"  type="text" size="50" maxlength="50" value="<?php echo $title; ?>"></td>
          </tr>
          <?php
      if (!isset($jenis))
	     $jenis="menu";
	  if ($jenis<>"menu"){
        echo "<tr><td>Kategori Menu</td><td colspan=\"3\"><select name=\"txt_menu\" onChange=\"document.frmmenu.action='admin.php?module=menu_admin&task=tambah';document.frmmenu.submit();\" >";
	    $query = "SELECT id,title FROM menu where type='menu' and admin='1' order by menupos";
        $result = sql_query($query,$dbi);
	    $num_rows = sql_num_rows($result);
		
	   if($num_rows > 0) {
	      while($data=sql_fetch_array($result,$dbi)){ 
		     $m_id = $data["id"];
		     $tajuk = $data["title"];
			 if ($m_id==$menu)
	           echo "<option selected value=\"$m_id\">$tajuk</option>";
			 else
	           echo "<option value=\"$m_id\">$tajuk</option>";
		  }
	   }
        echo "</select></td></tr>";
	 } //jenis<>"menu   
	 
	 
		 if ($jenis=="modul") { 
            echo "<tr><td>Modul</td>";
			echo "<td colspan=\"3\"><select name=\"txt_modul\" onChange=\"document.frmmenu.txt_pautan.value='admin.php?module='+document.frmmenu.txt_modul.value;\">";

	       $query = "SELECT admin,name,title FROM modules where admin='1' order by admin,title ";
           $result = sql_query($query,$dbi);
	       $num_rows = sql_num_rows($result);
		
	       if($num_rows > 0) {
		      $cnt_m=0;
	          while($data=sql_fetch_array($result,$dbi)){ 
		        $m_name = $data["name"];
		        $m_tajuk = $data["title"];
				$m_admin = $data["admin"];
                $cnt_m++;
				$lbl=$m_tajuk;  
								
				if ($cnt_m==1){
				  if(!isset($pautan))
				     $pautan="admin.php?module=$m_name";
				}
				
				if ($m_name==$module)
	              echo "<option selected value=\"$m_name\">$lbl</option>";
				else
	              echo "<option value=\"$m_name\">$lbl</option>";
		   }
	    } 
        echo "</select></td></tr>";
	    } //jenis=modul 
		
		 if ($jenis<>"menu") {
	        echo "<tr><td>Pautan</td><td colspan=\"3\"><input name=\"txt_pautan\" ";
			if ($jenis<>"pautan")
			  echo " readonly ";
		   echo " type=\"text\" size=\"50\" maxlength=\"50\" value=\"$pautan\"></td></tr>";
         }

	  ?>
          <tr> 
            <td>Imej</td>
            <td ><input type="text" name="txt_imej" size="50" maxlength="50" value="<?php echo $image; ?>"> 
              <!--<input type="button" name="Button" value="Browse" onClick="window.open('imagebrowse.php','mywin','left=20,top=20,width=400,height=200,toolbar=0,resizable=0');"></td>-->
              <input type="button" name="Button" value="Browse" onClick="showdiv();"></td>
          </tr>
          <tr>
            <td valign="top">Catatan</td>
            <td><textarea name="txt_catatan" cols="60" rows="4" id="txt_catatan"></textarea></td>
          </tr>
          <tr> 
            <td>Aktif</td>
            <td width="4%"> 
              <?php if ($aktif=="1")
	            echo "<input type=\"checkbox\" checked name=\"txt_aktif\" value=\"1\">";
	         else
	            echo "<input type=\"checkbox\" name=\"txt_aktif\" value=\"1\">";
	   ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" > <input type="hidden" name="txt_targetwindow" value="<? echo $targetwindow; ?>"> 
              <input name="txt_ordering"  type="hidden" size="5" maxlength="5" value="<?php echo $susunan; ?>"> 
              <input type="hidden" name="dbtrans" value="0"> <input type="hidden" name="id" value="<?php echo $id; ?>"> 
              <input name="Simpan" type="submit" value="Simpan"> <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=menu_admin';"> 
            </td>
          </tr>
        </table></td></tr></table>
</form>
<?php
$path="images/menu/";

 $blocksdir = dir($path);
 echo "<div id=\"imagelist\" style=\"position:absolute; left:600px; top:240px; z-index:7; width:200px; height:77px; overflow: visible; visibility: hidden; background-color: #FFFFFF;\">";
 echo "<div>";
 while($func=$blocksdir->read()) {
	    if($func!= ".." and $func!=".") 
			if(!is_dir($path.$func)){
                   echo "<a href=\"#\" onClick=\"document.frmmenu.txt_imej.value='images/$func';hidediv();\"><img border=\"0\" src=\"$path$func\"></a>";   
			}
  } //while				    
 echo "</div>";
 echo "</div>";
 ?>
 <script type="text/javascript">hidediv();</script>
