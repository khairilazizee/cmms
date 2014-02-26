<?php
 global $dbi;
 ?>
<form name="frmrole" method="post" action="admin.php?module=role&task=simpan">
<table width="100%" border="0">
  <tr>
    <td colspan="2"><strong>Tambah Role</strong></td>
  </tr>
  <tr>
    <td width="11%">Role</td>
    <td width="89%"><input name="txt_role"  type="text" size="20" maxlength="20"></td>
  </tr>
  <tr>
    <td colspan="2" >
	  <input name="dbtrans" type="hidden" value="0">
	  <input name="Simpan" type="submit" value="Simpan">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=role';">
	</td>
  </tr></table>
</form>
