<script type="text/javascript">
    function checkform(){
        if (document.frmtask.txtPudesc.value==""){
            alert("Sila masukkan penerangan.");
            document.frmtask.txtPudesc.focus();
            return false;
        }
        else{
            return confirm("Adakah anda pasti?");
        }
    }
</script>
<?php

$pengurusanid = (int) mysql_real_escape_string($_GET['puid']);

if($_POST['submit']){
    $pudesc = mysql_real_escape_string($_POST['txtPudesc']);
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO tbl_pengurusan_utama (pu_desc) VALUES ('$pudesc')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE tbl_pengurusan_utama SET pu_desc='$pudesc' WHERE pu_id='$pengurusanid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan");
    
}

$flg = "add";
$sqlpu = "SELECT pu_id,pu_desc FROM tbl_pengurusan_utama WHERE pu_id='$pengurusanid'";
$respu = mysql_query($sqlpu);
if(mysql_num_rows($respu)>0){
	$fetchpu = mysql_fetch_array($respu);
	$flg="edit";
	$pudesc = $fetchpu['pu_desc'];
	$puid = $fetchpu['pu_id'];
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
            <textarea name="txtPudesc" rows="3" wrap="physical" cols="80"><?php echo $pudesc;?></textarea>
        </td>
    </tr>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="puid" value="<?php echo $puid;?>"/>
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan'" class="button"/>
    	</td>
    </tr> 
</table>