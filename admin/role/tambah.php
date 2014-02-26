<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 //include_once("mainfile.php");
 global $dbi;
 ?>
<form name="frmrole" method="post" action="admin.php?module=role&task=simpan">
<table id="form_table_outer" width="70%">
  <tr><td class="form_table_header">Tambah Role</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
          <tr> 
            <td width="11%">Role</td>
            <td width="89%"><input name="txt_role"  type="text" size="20" maxlength="20"></td>
          </tr>
          <tr>
            <td >Default</td>
            <td><input type="checkbox" name="defaultrole" value="1"></td>
          </tr>
          <tr> 
            <td colspan="2" > <input name="dbtrans" type="hidden" value="0"> <input name="Simpan" type="submit" value="Simpan"> 
              <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=role';"> 
            </td>
          </tr>
        </table>
      </td></tr></table>
</form>
