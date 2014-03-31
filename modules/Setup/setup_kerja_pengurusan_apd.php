<?php

$pengurusanid = $_SESSION['puid'];
$paid = (int) mysql_real_escape_string($_GET['paid']);


if($_POST['submit']){
	$padesc = mysql_real_escape_string($_POST['txtpadesc']);
	$paweightage = mysql_real_escape_string($_POST['txtweightage']);
	$flg = $_POST['flg'];

	if($flg == "add"){
		$sql = "INSERT INTO tbl_pengurusan_apd (pa_desc, pa_weightage,pu_id) VALUES ('$padesc','$paweightage','$pengurusanid')";
	} elseif($flg == "edit"){
		$sql = "UPDATE tbl_pengurusan_apd SET pa_desc='$padesc', pa_weightage='$paweightage' WHERE pa_id='$paid'";
	}

	mysql_query($sql,$dbi);
	pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan_apd&puid=$pengurusanid");
}

$flg = "add";
$sql = "SELECT pa_id, pa_desc, pa_weightage FROM tbl_pengurusan_apd WHERE pa_id='$paid'";
$res = mysql_query($sql,$dbi);
if(mysql_num_rows($res)>0){
	$flg = "edit";
	$fetchpa = mysql_fetch_array($res);
	$padesc = $fetchpa['pa_desc'];
	$paweightage = $fetchpa['pa_weightage'];
}


?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="0" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Kerja Pengurusan</td>
    </tr>
    <tr>
        <td width="120" valign="middle" class="title">Penerangan</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <textarea name="txtpadesc" rows="3" wrap="physical" cols="80"><?php echo $padesc;?></textarea>
        </td>
    </tr>
    <tr>
    	<td>Weightage</td>
    	<td>:</td>
    	<td><input type="text" name="txtweightage" value="<?php echo $paweightage;?>"/></td>
    </tr>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="puid" value="<?php echo $pengurusanid;?>"/>
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan_apd&puid=<?php echo $pengurusanid;?>'" class="button"/>
    	</td>
    </tr> 
</table>