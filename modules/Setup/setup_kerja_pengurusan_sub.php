<?php

$pengurusanid = $_SESSION['puid'];
// echo $pengurusanid;
$titleid = $_SESSION['ptid'];
$psubid = (int) mysql_real_escape_string($_GET['psid']);

if($_POST['submit']){
	$psdesc = mysql_real_escape_string($_POST['txtpsdesc']);
	$psprice = mysql_real_escape_string($_POST['txtpsprice']);
	$flg = $_POST['flg'];

	if($flg=="add"){
		$qry = "INSERT INTO tbl_pengurusan_sub (ps_desc,ps_price,pt_id) VALUES ('$psdesc','$psprice','$titleid')";
	} elseif($flg=="edit"){
		$qry = "UPDATE tbl_pengurusan_sub SET ps_desc='$psdesc', ps_price='$psprice' WHERE ps_id='$psubid' and pt_id='$titleid'";
	}
	// die($qry);
	$result = mysql_query($qry,$dbi);
	pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan_sub&puid=$pengurusanid&ptid=$titleid");

}

$flg = "add";
$sql = "SELECT ps_id,ps_desc,ps_price FROM tbl_pengurusan_sub WHERE ps_id='$psubid' and pt_id='$titleid'";
$res = mysql_query($sql,$dbi);
if(mysql_num_rows($res)>0){
	$flg = "edit";
	$fetchps = mysql_fetch_array($res);
	$psdesc = $fetchps['ps_desc'];
	$psprice = $fetchps['ps_price'];
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
            <textarea name="txtpsdesc" rows="3" wrap="physical" cols="80"><?php echo $psdesc;?></textarea>
        </td>
    </tr>
    <tr>
    	<td class="title" valign="middle">Kos</td>
    	<td class="title">:</td>
    	<td><input type="text" value="<?php echo $psprice;?>" name="txtpsprice"></td>
    </tr>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan_sub&puid=<?php echo $pengurusanid;?>&ptid=<?php echo $titleid;?>'" class="button"/>
    	</td>
    </tr> 
</table>