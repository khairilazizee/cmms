<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );
?>
<script "text/javascript" src="jscript/semakpenggunaedit.js"></script>
<?php
 global $dbi;
 $login=$_REQUEST["login"];
 if(isset($_REQUEST["flg"]))
   $flg=$_REQUEST["flg"];
 if (!isset($flg))
   $flg=0;
 
 if ($flg<>0){
   $bahagian=$_REQUEST["txt_bahagian"];
   $unit=$_REQUEST["txt_unit"];
   $role=$_REQUEST["txt_role"];
   $login=$_REQUEST["txt_login"];
   $password=$_REQUEST["txt_password"];
   $confirmpassword=$_REQUEST["txt_confirmpassword"];
   $nama=$_REQUEST["txt_name"];
 }
 else {
   $id=$_REQUEST["login"];
   $qry="SELECT `password`,`role`,`nama`,`ag_id`,`unit` from user where login='$login'";
   //die ($qry);
   $result = sql_query($qry,$dbi);
   $num_rows = sql_num_rows($result);

    if($num_rows > 0) {
	   $data=sql_fetch_array($result,$dbi); 
       $password = $data["password"];
       $nama = $data["nama"];
       $bahagian = $data["ag_id"];
       $unit = $data["unit"];
	   $role = $data["role"];
   }
 }  
 
 ?>
 
<form name="frmpengguna" method="post" action="admin.php?module=pengguna&task=simpan">
<table id="form_table_outer" width="70%">
  <tr><td class="form_table_header">Kemaskini Pengguna</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
  <tr>
    <td width="20%">Login</td>
    <td ><input name="txt_login"  type="hidden" size="20" maxlength="20" value="<?php echo $login; ?>"><?php echo $login; ?></td>
  </tr>
  <tr>
    <td >Katalaluan</td>
    <td ><input name="txt_password"  type="password" size="20" maxlength="20" > </td>
  </tr>
  <tr>
    <td >Sahkan Katalaluan</td>
    <td ><input name="txt_confirmpassword"  type="password" size="20" maxlength="20"></td>
  </tr>
    <tr>
    <td >Nama</td>
    <td ><input name="txt_name"  type="text" size="50" maxlength="50" value="<?php echo $nama; ?>"></td>
  </tr>
     <tr>
      <td>Asset</td>
      <td><select name="txt_bahagian" onChange="document.frmpengguna.action='admin.php?module=pengguna&flg=1&task=kemaskini';document.frmpengguna.submit();" >
	      <option value="">-- Pilih Asset --</option>
          <?php
	$query = "SELECT ag_id,ag_desc FROM asset_group order by ag_desc ";
    $result = sql_query($query,$dbi);
  $num_rows = sql_num_rows($result);
    
  if($num_rows > 0) {
      while($data=sql_fetch_array($result,$dbi)){ 
      $r_id = $data["ag_id"];
      $name = $data["ag_desc"];
		  if ($bahagian==$r_id)
	        echo "<option selected value=\"$r_id\">$name</option>";
		  else
	        echo "<option value=\"$r_id\">$name</option>";
		}
	} 
	?>
        </select></td>
     </tr>
     <tr>
      <td>Role</td>
      <td><select name="txt_role" >
	      <option>-- Pilih Role --</option>
          <?php
	$query = "SELECT id,name FROM role order by id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
		
	if($num_rows > 0) {
	    while($data=sql_fetch_array($result,$dbi)){ 
		  $r_id = $data["id"];
		  $name = $data["name"];
		  if ($role==$r_id)
	        echo "<option selected value=\"$r_id\">$name</option>";
		  else
	        echo "<option value=\"$r_id\">$name</option>";
		}
	} 
	?>
        </select></td>
     </tr>
  <tr>
    <td colspan="2" >
	  <input name="dbtrans" type="hidden" value="1">
	  <input name="login" type="hidden" value="<?php echo $login; ?>">
	  <input name="Simpan" type="submit" value="Simpan"  onClick="return semakpengguna();">
	  <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=pengguna';">
	</td>
  </tr></table>
  </td></tr></table>
</form>
