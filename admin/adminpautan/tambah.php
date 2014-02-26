<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
 global $dbi;
 
 $query = "SELECT max(ordering) as maxorder FROM weblinks";
 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);
 $max=sql_result($result,0,"maxorder");
 if ($max=="")
   $max=1;
 else
   $max=$max+1;

 $w[0]="_top";
 $w[1]="_blank";

 $w1[0]="Window Yang Sama";
 $w1[1]="Buka Window Baru";
 ?>
<form name="frmrole" method="post" action="admin.php?module=adminpautan&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Tambah Pautan</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%" border="0" cellpadding="2" cellspacing="0">

  <tr>
    <td colspan="2"><strong>Tambah Pautan Baru</strong></td>
  </tr>
  <tr>
    <td width="11%">Tajuk</td>
    <td width="89%"><input name="txt_title"  type="text" size="50" maxlength="50"></td>
  </tr>
  <tr>
    <td width="11%">Pautan</td>
    <td width="89%"><input name="txt_link"  type="text" size="50" maxlength="50"></td>
  </tr>
  <tr>
    <td width="11%">Paparan</td>
    <td width="89%"><select name="txt_target">
          <?php
	  for($idx=0;$idx<2;$idx++){	
	       echo "<option value=\"$w[$idx]\">$w1[$idx]</option>";
	  }
	?>
	</select></td>
  </tr>
    <td colspan="2" >
	  <input type="hidden" name="txt_ordering" value="<?php echo $max ?>" size="5">
	  <input name="dbtrans" type="hidden" value="0">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminpautan';">
	</td>
  </tr></table>
  </td></tr></table>
</form>
