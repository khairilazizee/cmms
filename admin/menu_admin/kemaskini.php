<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 
    $id=$_REQUEST["id"];
    $jenis=$_REQUEST["txt_jenis"];

	if (!isset($jenis)) {
	   $query = "SELECT parent,title,link,type,category,active,menupos,admin,module,picture,description FROM menu where id=$id ";
       $result = sql_query($query,$dbi);
	   $num_rows = sql_num_rows($result);
		
	  if($num_rows > 0) {
	    $data=sql_fetch_array($result,$dbi); 
        $menu = $data["parent"];
		$title = $data["title"];
        $jenis = $data["type"]; 
        $aktif = $data["active"];
        $susunan = $data["menupos"];
		$pautan = $data["link"];
		$parent = $data["parent"];
		$admin = $data["admin"];
		$module = $data["module"];
		$category = $data["category"];
		$image = $data["picture"];
		$catatan = $data["description"];
	  } 
    } //!isset($jenis)
	else {
     $title=$_REQUEST["txt_tajuk"];
     $menu=$_REQUEST["txt_menu"];
     $pautan=$_REQUEST["txt_pautan"];
     $aktif=$_REQUEST["txt_aktif"];
     $susunan=$_REQUEST["txt_susunan"];
	 $image=$_REQUEST["txt_imej"];
	 $catatan=$_REQUEST["description"];
   } 
 if ($jenis=="pautan")
   $targetwindow="_blank";
 else
   $targetwindow="_top";   
 ?>
<form name="frmmenu" method="post" action="admin.php?module=menu_admin&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Kemaskini Menu Admin</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%" border="0" bgcolor="#EEF3FF" cellpadding="2" cellspacing="0">
    <?php
	  $jenismenu[0]="modul";
	  $jenismenu[1]="menu";


	  $labeljenis[0]="Modul";
	  $labeljenis[1]="Menu";

	  
	  echo "<td>Jenis</td>";
      echo "<td colspan=\"3\"><select name=\"txt_jenis\" onChange=\"document.frmmenu.action='admin.php?module=menu&task=kemaskini';document.frmmenu.submit();\">\n";
	  for ($idx=0;$idx<2;$idx++){
	      if ($jenis==$jenismenu[$idx])
            echo "<option selected value=\"$jenismenu[$idx]\">$labeljenis[$idx]</option>\n";
		  else
            echo "<option value=\"$jenismenu[$idx]\">$labeljenis[$idx]</option>\n";
	  }	  
      echo "</select></td></td></tr>";
	?>
    <tr> 
      <td width="20%">Tajuk Menu</td>
      <td width="80%" ><input name="txt_tajuk"  type="text" size="50" maxlength="50" value="<?php echo $title; ?>"></td>
    </tr>
      <?php

	  if ($jenis<>"menu"){
        echo "<tr><td>Kategori Menu</td><td colspan=\"3\"><select name=\"txt_menu\" >\n";
	    $query = "SELECT id,title FROM menu where type='menu' and admin='1' ";
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
			echo "<td colspan=\"3\"><select name=\"txt_modul\"  onChange=\"document.frmmenu.txt_pautan.value='admin.php?module='+document.frmmenu.txt_modul.value;\">";

	       $query = "SELECT admin,name,title FROM modules where admin='1' order by admin,title ";
           $result = sql_query($query,$dbi);
	       $num_rows = sql_num_rows($result);
		
	       if($num_rows > 0) {
		      $cnt_m=0;
	          while($data=sql_fetch_array($result,$dbi)){ 
		        $m_name = $data["name"];
		        $tajuk = $data["title"];
				$admin = $data["admin"];
                $cnt_m++;
				$lbl=$tajuk;
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
		
		 if ($jenis<>"menu") 
	        echo "<tr><td>Pautan</td><td colspan=\"3\"><input name=\"txt_pautan\"  type=\"text\" size=\"50\" maxlength=\"50\" value=\"$pautan\"></td></tr>";
    

	  ?>
	<tr>
	<td>Imej</td>
	<td ><input type="text" name="txt_imej" size="50" maxlength="50" value="<?php echo $image; ?>">
	<input type="button" name="Button" value="Browse" onClick="showdiv();"></td>
	</tr>	  
	<tr>
	<td>Catatan</td>
	<td ><textarea name="txt_catatan" cols="60" rows="4" id="txt_catatan"><?php echo $catatan; ?></textarea>
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
	  </td>
    </tr>
    <tr> 
      <td>Susunan</td>
      <td >
	  <?php

        if ($jenis=="menu")  
           $query = "SELECT menupos FROM menu where admin='1' and type='$jenis' order by menupos";
        else
	       $query = "SELECT menupos FROM menu where admin='1' and parent='$menu' order by menupos";
        $result = sql_query($query,$dbi);
	    $num_rows = sql_num_rows($result);
		echo "<select name=\"txt_ordering\">";
		if ($num_rows > 0){
			while ($data=sql_fetch_array($result,$dbi)){
				$susun=$data["menupos"];
				if ($susun==$susunan)
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
	    <input type="hidden" name="txt_targetwindow" value="<? echo $targetwindow; ?>">
	    <input type="hidden" name="txt_old_ordering" value="<?php echo $susunan ?>">
	    <input type="hidden" name="dbtrans" value="1"> <input type="hidden" name="id" value="<?php echo $id; ?>"> 
	    <input name="Simpan" type="submit" value="Simpan"> 
		<input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=menu_admin';"> 
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
