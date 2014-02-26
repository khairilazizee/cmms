<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 $pos[0]="left";
 $pos[1]="center";
 $pos[2]="right";

 $lokasi[0]="kiri";
 $lokasi[1]="tengah";
 $lokasi[2]="kanan";
 
    $id=$_GET["id"];
	$query = "SELECT title,position,name,image,public,active,ordering FROM blocks where id=$id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    $data=sql_fetch_array($result,$dbi); 
        $title = $data["title"];
        $position = $data["position"];
        $name = $data["name"];
        $image = $data["image"];
        $public = $data["public"];
        $active = $data["active"];
        $ordering = $data["ordering"];
	} 
	
?>
<form name="frmrole" method="post" action="admin.php?module=block&task=simpan">
<table id="form_table_outer" width="40%">
  <tr><td class="form_table_header">Kemaskini Blok</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
    <tr> 
      <td width="19%">Tajuk</td>
      <td><input name="txt_title" value="<?php echo $title ?>" type="text" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td width="19%">Kedudukan</td>
      <td> <select name="txt_position">
          <?php
	     for ($blockidx=0;$blockidx<3;$blockidx++){
		   if ($position==$pos[$blockidx])
		      echo "<option selected value=\"$pos[$blockidx]\">$lokasi[$blockidx]</option>";
		   else	  
		      echo "<option value=\"$pos[$blockidx]\">$lokasi[$blockidx]</option>";
		 }
		?>
        </select> </td>
    </tr>
    <tr> 
      <td width="20%">Nama Blok</td>
      <td><input name="txt_name" value="<?php echo $name ?>" type="text" size="50" maxlength="50"></td>
    </tr>
	<!--
    <tr> 
      <td>Imej</td>
      <td><input name="txt_image" value="<?php echo $image ?>" type="text" size="50" maxlength="50"></td>
    </tr>
	-->
    <tr> 
      <td>Paparan Umum</td>
      <td><input type="checkbox" 
	  <?php if ($public==1) echo "checked "; ?> name="txt_public" value="1"></td>
	 </tr>
	<tr>
      <td>Aktif</td>
      <td width="65%" ><input type="checkbox" <?php if ($active==1) echo "checked "; ?> name="txt_active" value="1"></td>
    </tr>
    <tr> 
      <td>Susunan</td>
      <td>
	  <?php
	    $query = "SELECT ordering FROM blocks order by ordering ";
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
    </tr>
    <tr> 
      <td colspan="2" > 
	    <input type="hidden" name="txt_old_ordering" value="<?php echo $ordering ?>">
	    <input type="hidden" name="id" value="<?php echo $id ?>"> <input type="hidden" name="dbtrans" value="1"> <input name="Simpan" type="submit" value="Simpan"> 
        <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=block';"> 
      </td>
    </tr>
  </table>
  </td></tr></table>
</form>
