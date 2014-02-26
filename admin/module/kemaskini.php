<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 $id=$_REQUEST["id"];
 
 $query = "SELECT title,name,public,image,admin,active,ordering FROM modules where id=$id";
				   
 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);

 if($num_rows > 0) {
	    while ($data=sql_fetch_array($result,$dbi)) {
		  $title=$data["title"];
		  $name=$data["name"];
		  $image=$data["image"];
		  $public=$data["public"];
		  $admin=$data["admin"];
		  $active=$data["active"];
		  $ordering=$data["ordering"];
		  //modul utama umportal - boleh tukar tajuk sahaja
		  if ($name=="LamanStaf" or $name=="News" or $name=="Maklumat")
		    $lockmodule=1;
		  else
		    $lockmodule=0;	
		 }
		  
  }		
 ?>
<form name="frmmodule" method="post" action="admin.php?module=module&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Kemaskini Modul</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
    <tr> 
      <td>Nama Modul</td>
      <td><?php echo $name; ?> <input name="txt_name"  type="hidden" size="50" maxlength="50" value="<?php echo $name ?>"></td>
    </tr>
    <tr> 
      <td>Tajuk</td>
      <td><input name="txt_title"  type="text" size="50" maxlength="50" value="<?php echo $title; ?>"></td>
    </tr>

	<?php if ($admin==0 and $lockmodule==0) { 
         echo "<tr><td>Paparan Umum</td><td>
		       <input name=\"txt_public\"  type=\"checkbox\" "; 
	     if ($public==1) echo "checked ";
		 echo "value=\"1\"></td></tr>";
       } ?>
	<?php if ($lockmodule==0){ ?>   
    <tr> 
      <td>Aktif</td>
      <td><input name="txt_active"  type="checkbox" <?php if ($active==1) echo "checked "?>  value="1"></td>
    </tr>
    <tr> 
	<?php } ?>
      <td colspan="2" >
	    <?php if ($lockmodule==1){
		         echo "<input name=\"txt_public\" type=\"hidden\" value=\"$public\">\n";
		         echo "<input name=\"txt_active\" type=\"hidden\" value=\"$active\">\n";
		       }
		?>	   
	    <input name="txt_ordering"  type="hidden" size="5" maxlength="5" value="<?php echo $ordering; ?>"> 
		<input name="dbtrans" type="hidden" value="1"> <input name="id" type="hidden" value="<?php echo $id; ?>"> 
        <input name="Simpan" type="submit" value="Simpan"> <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=module';"> 
      </td>
    </tr>
  </table>
  </td></tr></table>
</form>
