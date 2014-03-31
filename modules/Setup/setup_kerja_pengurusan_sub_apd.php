<?php

$pengurusanid = $_SESSION['puid'];
$paid = $_SESSION['paid'];
$pasid = (int) mysql_real_escape_string($_GET['pasid']);

if($_POST['submit']){
	$pasdesc = mysql_real_escape_string($_POST['txtpasdesc']);
	$paspara = mysql_real_escape_string($_POST['txtpasprice']);
	$flg = $_POST['flg'];

	if($flg=="add"){
		$sql = "INSERT INTO tbl_pengurusan_apd_sub (pas_desc,pas_para,pa_id) VALUES ('$pasdesc','$paspara','$paid')";
	} elseif($flg == "edit"){
		$sql = "UPDATE tbl_pengurusan_apd_sub SET pas_desc='$pasdesc', pas_para='$paspara' WHERE pas_id='$pasid' and pa_id='$paid'";
	}

	mysql_query($sql,$dbi);
	pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan_sub_apd&puid=$pengurusanid&paid=$paid");
}

$flg = "add";
$sqlpa = "SELECT pas_id, pas_desc, pas_para FROM tbl_pengurusan_apd_sub WHERE pas_id='$pasid'";
$respa = mysql_query($sqlpa,$dbi);
if(mysql_num_rows($respa)>0){
	$flg = "edit";
	$fetchpas = mysql_fetch_array($respa);
	$pasdesc = $fetchpas['pas_desc'];
	$paspara = $fetchpas['pas_para'];
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
            <textarea name="txtpasdesc" rows="3" wrap="physical" cols="80"><?php echo $pasdesc;?></textarea>
        </td>
    </tr>
    <tr>
    	<td class="title" valign="middle">Parameter</td>
    	<td class="title">:</td>
    	<td><input type="text" value="<?php echo $paspara;?>" name="txtpasprice"></td>
    </tr>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="puid" value="<?php echo $pengurusanid;?>"/>
        	<input type="hidden" name="paid" value="<?php echo $paid;?>"/>
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan_sub_apd&puid=<?php echo $pengurusanid;?>&paid=<?php echo $paid;?>'" class="button"/>
    	</td>
    </tr> 
</table>