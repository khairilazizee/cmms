<script type="text/javascript">
    function checkform(){
        if(document.frmtask.txtNamaBarangan.value==""){
            alert("Sila nyatakan nama barang.");
            return false;
        }
        else if(document.frmtask.txtJumlahBarangan.value==""){
            alert("Sila nyatakan kuantiti barang.");
            return false;
        }
        else{
            return confirm("Adakah anda pasti?");
        }
    }
</script>
<?php

$invid = (int) mysql_real_escape_string($_REQUEST['inv']);

if(isset($_POST['submit'])){
	$namabarangan = mysql_real_escape_string($_POST['txtNamaBarangan']);
	$jumlahbarangan = mysql_real_escape_string($_POST['txtJumlahBarangan']);
	$idbarang = $_POST['inv'];
	$flg = $_POST['flg'];

	if($flg=="add"){
		$qryinventori = "INSERT INTO tbl_inventori (nama_barangan,jum_barangan) VALUES ('$namabarangan','$jumlahbarangan')";
	} elseif($flg=="edit"){
		$qryinventori = "UPDATE tbl_inventori SET nama_barangan='$namabarangan', jum_barangan='$jumlahbarangan' WHERE id='$idbarang'";
	}

	mysql_query($qryinventori,$dbi);

	pageredirect("mainpage.php?module=Setup&task=list_inventori");
}

$flg = "add";
$sqlinventori = "SELECT id, nama_barangan, jum_barangan FROM tbl_inventori WHERE id='$invid'";
// echo $sqlinventori;
$resinventori = mysql_query($sqlinventori,$dbi);
if($datainv = mysql_fetch_array($resinventori)){
	$flg = "edit";
	$namaitem = $datainv['nama_barangan'];
	$jumlah = $datainv['jum_barangan'];
	$idbarangan = $datainv['id'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="3" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Inventori</td>
    </tr>
    <tr>
    	<td class="title" width="20%">Nama Barangan</td>
    	<td class="title" width="2%">:</td>
    	<td><input type="text" name="txtNamaBarangan" value="<?php echo $namaitem;?>" /></td>
    </tr>
    <tr>
    	<td class="title">Jumlah Barangan</td>
    	<td class="title">:</td>
    	<td><input type="text" name="txtJumlahBarangan" size="10" value="<?php echo $jumlah;?>" /></td>
    </tr>
    <tr>
        <td colspan="3">
            <input type="hidden" name="inv" value="<?php echo $idbarangan;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
            <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_inventori'" class="button"/>
        </td>
    </tr> 
</table>
</form>