<?php

$psid = $_SESSION['psid'];
$titleid = $_SESSION['ptid'];
$psiid = (int) mysql_real_escape_string($_GET['psiid']);

if($_POST['submit']){
	$psidesc = mysql_real_escape_string($_POST['txtpsidesc']);
	$psiprice = mysql_real_escape_string($_POST['txtpsiprice']);
	$flg = $_POST['flg'];

	if($flg=="add"){
		$qry = "INSERT INTO tbl_pengurusan_subitem (psi_desc,psi_price,ps_id) VALUES ('$psidesc','$psiprice','$psid')";
	} elseif($flg=="edit"){
		$qry = "UPDATE tbl_pengurusan_subitem SET psi_desc='$psidesc', psi_price='$psiprice' WHERE psi_id='$psiid' and ps_id='$psid'";
	}

	mysql_query($qry,$dbi);
	pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan_subitem&ptid=$ptid&psid=$psid");
}

$flg = "add";
$sql = "SELECT psi_id,psi_desc,psi_price,ps_id FROM tbl_pengurusan_subitem WHERE psi_id='$psiid' and ps_id='$psid'";
$res = mysql_query($sql,$dbi);
if(mysql_num_rows($res)>0){
	$flg = "edit";
	$fetchpsi = mysql_fetch_array($res);
	$psidesc = $fetchpsi['psi_desc'];
	$psiprice = $fetchpsi['psi_price'];
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
            <textarea name="txtpsidesc" rows="3" wrap="physical" cols="80"><?php echo $psidesc;?></textarea>
        </td>
    </tr>
    <tr>
    	<td class="title" valign="middle">Kos</td>
    	<td class="title">:</td>
    	<td><input type="text" value="<?php echo $psiprice;?>" name="txtpsiprice"></td>
    </tr>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan_sub&ptid=<?php echo $titleid;?>&psid=<?php echo $psid;?>'" class="button"/>
    	</td>
    </tr> 
</table>