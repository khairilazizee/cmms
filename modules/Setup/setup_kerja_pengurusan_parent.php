<?php

$pengurusanid = $_SESSION['puid'];
$titleid = (int) mysql_real_escape_string($_GET['ptid']);

if($_POST['submit']){
    $ptdesc = mysql_real_escape_string($_POST['txtptdesc']);
    $ptprice = mysql_real_escape_string($_POST['txtptprice']);
    $puid = mysql_real_escape_string($_POST['puid']);
    $ptid = mysql_real_escape_string($_POST['ptid']);
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO tbl_pengurusan_tajuk (pt_desc,pt_price,pu_id) VALUES ('$ptdesc','$ptprice','$puid')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE tbl_pengurusan_tajuk SET pt_desc='$ptdesc', pt_price='$ptprice' WHERE pu_id='$puid' and pt_id='$ptid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&puid=$pengurusanid");
    
}

$flg = "add";
$sqlpt = "SELECT pt_id,pt_desc,pu_id,pt_price FROM tbl_pengurusan_tajuk WHERE pu_id='$pengurusanid' and pt_id='$titleid'";
$respt = mysql_query($sqlpt);
if(mysql_num_rows($respt)>0){
	$fetchpt = mysql_fetch_array($respt);
	$flg="edit";
	$ptdesc = $fetchpt['pt_desc'];
	$puid = $fetchpt['pu_id'];
	$ptid = $fetchpt['pt_id'];
	$ptprice = $fetchpt['pt_price'];
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
            <textarea name="txtptdesc" rows="3" wrap="physical" cols="80"><?php echo $ptdesc;?></textarea>
        </td>
    </tr>
    <tr>
    	<td class="title" valign="middle">Kos</td>
    	<td class="title">:</td>
    	<td><input type="text" value="<?php echo $ptprice;?>" name="txtptprice"></td>
    </tr>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="puid" value="<?php echo $pengurusanid;?>"/>
        	<input type="hidden" name="ptid" value="<?php echo $titleid;?>"/>
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&puid=<?php echo $pengurusanid;?>'" class="button"/>
    	</td>
    </tr> 
</table>