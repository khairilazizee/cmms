<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 
 $w[0]="_top";
 $w[1]="_blank";

 $w1[0]="Window Yang Sama";
 $w1[1]="Buka Window Baru";
 
    $id=$_GET["id"];
	
	$query = "SELECT id,title,link,target,ordering FROM weblinks where id=$id ";				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	if($num_rows > 0) {
     while ($data=sql_fetch_array($result,$dbi)) {
        $id = $data["id"];
		$title = $data["title"];
		$link = $data["link"];	
		$target = $data["target"];	
		$ordering = $data["ordering"];	
	  }
	}
?>
<form name="frmrole" method="post" action="admin.php?module=adminpautan&task=simpan">
<table id="form_table_outer" width="60%">
  <tr><td class="form_table_header">Kemaskini Pautan</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%" border="0" cellpadding="2" cellspacing="0">

    <tr> 
      <td colspan="2"><strong>Kemaskini Pautan</strong></td>
    </tr>
    <tr> 
      <td width="11%">Tajuk</td>
      <td width="89%"><input name="txt_title"  type="text" value="<?php echo $title; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td width="11%">Pautan</td>
      <td width="89%"><input name="txt_link"  type="text" value="<?php echo $link ?>" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td width="11%">Paparan</td>
      <td width="89%"><select name="txt_target">
          <?php
	  for($idx=0;$idx<2;$idx++){
	    if ($w[$idx]==$target)
	       echo "<option selected value=\"$w[$idx]\">$w1[$idx]</option>";
	    else	
	       echo "<option value=\"$w[$idx]\">$w1[$idx]</option>";
	  }
	?>
        </select></td>
    </tr>
    <tr>
      <td>Susunan</td>
      <td>
	  <?php
	    $query = "SELECT ordering FROM weblinks order by ordering ";
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
	  </td>
    </tr>
    <tr> 
      <td colspan="2" > 
	    <input type="hidden" name="txt_old_ordering" value="<?php echo $ordering ?>">
	    <input name="id" type="hidden" value="<?php echo $id; ?>"> 
        <input name="dbtrans" type="hidden" value="1"> <input name="Simpan" type="submit" value="Simpan"> 
        <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=adminpautan';"> 
      </td>
    </tr>
  </table>
  </td></tr></table>
</form>
