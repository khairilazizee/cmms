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

 $name=$_REQUEST["name"];
 $flg=$_REQUEST["flg"];

 $query = "SELECT max(ordering) as maxorder FROM blocks";
 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);
 $max=sql_result($result,0,"maxorder");
 if ($max=="")
   $max=1;
 else
   $max=$max+1;
 ?>
<form name="frmmodule" method="post" action="admin.php?module=block&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Aktifkan Blok</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
    <tr> 
      <td>Nama Blok</td>
      <td ><?php echo $name; ?> <input name="txt_name"  type="hidden" size="50" maxlength="50" value="<?php echo $name ?>"></td>
    </tr>
    <tr> 
      <td>Tajuk</td>
      <td ><input name="txt_title"  type="text" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td>Kedudukan</td>
      <td> <select name="txt_position">
          <?php
	     for ($blockidx=0;$blockidx<3;$blockidx++)
		      echo "<option value=\"$pos[$blockidx]\">$lokasi[$blockidx]</option>";
		?>
        </select> </td>
    </tr>
	<!--
	  <tr> 
      <td>Imej</td>
      <td ><input name="txt_image"  type="text" id="txt_image" size="50" maxlength="50"></td>
    </tr>
	-->
    <tr> 
      <td>Paparan Umum</td>
      <td><input name="txt_public"  type="checkbox" value="1">
	</td>
    </tr>
    <tr> 
      <td>Aktif</td>
      <td><input name="txt_active"  type="checkbox" value="1">
	</td>
    </tr>

    <tr> 
      <td colspan="2" >
	    <input name="txt_ordering"  type="hidden" size="5" value="<?php echo $max ?>" maxlength="5">
	    <input name="dbtrans" type="hidden" value="0">
	    <input name="Simpan" type="submit" value="Simpan"> 
	  <?php
		echo "<input name=\"txt_admin\" type=\"hidden\" value=\"$flg\">";   
	  ?>			
        <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=block';"> 
      </td>
    </tr>
  </table>
</td></tr></table>
</form>
