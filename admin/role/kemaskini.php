<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 //include_once("mainfile.php");
    $id=$_GET["id"];
	$query = "SELECT name,defaultrole FROM role where id=$id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    $data=sql_fetch_array($result,$dbi); 
        $name = $data["name"];
		$def = $data["defaultrole"];
	} 
	
    
?>
<form name="frmrole" method="post" action="admin.php?module=role&task=simpan&id=<? echo $id ?>">
<table id="form_table_outer" width="70%">
  <tr><td class="form_table_header">Kemaskini Role</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
          <tr> 
            <td width="11%">Role</td>
            <td width="89%"><input name="txt_role" value="<?php echo $name ?>" type="text" size="20" maxlength="20"></td>
          </tr>
          <tr>
            <td >Default</td>
            <td><? if ($def=="1")
			         echo "<input checked type=\"checkbox\" name=\"defaultrole\" value=\"1\">";
				   else
			         echo "<input type=\"checkbox\" name=\"defaultrole\" value=\"1\">";
				?>
			</td>
          </tr>
          <tr> 
            <td colspan="2" > <input type="hidden" name="dbtrans" value="1"> <input name="Simpan" type="submit" value="Simpan"> 
              <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=role';"> 
            </td>
          </tr>
        </table>
  </td></tr></table>
</form>
