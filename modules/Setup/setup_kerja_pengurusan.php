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
    $putype = mysql_real_escape_string($_POST['txtjenispengurusan']);
    $pumonfee = mysql_real_escape_string($_POST['txtkosbulanan']);
    $currmon = date("m");
    $curryear = date("Y");
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO tbl_pengurusan_utama (pu_desc,pu_type,pu_monfee) VALUES ('$pudesc','$putype','$pumonfee')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE tbl_pengurusan_utama SET pu_desc='$pudesc', pu_type='$putype', pu_monfee='$pumonfee' WHERE pu_id='$pengurusanid'";
        //die($update);
        sql_query($update,$dbi);
    }

    if($putype==5){
        $check = "SELECT kpa_bulan FROM tbl_kos_bulanan_apd WHERE kpa_bulan='$currmon' and kpa_tahun='$curryear'";
        $rescheck = mysql_query($check,$dbi);
        if(!mysql_num_rows($recheck)>0)
            $qryapd = "INSERT INTO tbl_kos_bulanan_apd (kpa_kos,kpa_bulan,kpa_tahun,pu_id) VALUES ('$pumonfee','$currmon','$curryear','$pengurusanid')";
            // die ($qryapd);
            mysql_query($qryapd);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_kerja_pengurusan");
    
}

$flg = "add";
$sqlpu = "SELECT pu_id,pu_desc, pu_type, pu_monfee FROM tbl_pengurusan_utama WHERE pu_id='$pengurusanid'";
$respu = mysql_query($sqlpu);
if(mysql_num_rows($respu)>0){
	$fetchpu = mysql_fetch_array($respu);
	$flg="edit";
	$pudesc = $fetchpu['pu_desc'];
	$puid = $fetchpu['pu_id'];
    $putype = $fetchpu['pu_type'];
    $pumonfee = $fetchpu['pu_monfee'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="0" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Kerja Pengurusan</td>
    </tr>
    <tr>
        <td>Jenis Pengurusan</td>
        <td>:</td>
        <td>
            <select name="txtjenispengurusan" id="txtjenispengurusan">
                <option value="">- PILIH -</option>
                <?php
                    $sqljp = "SELECT jp_id, jp_desc FROM tbl_jenis_pengurusan ORDER BY jp_id";
                    $resjp = mysql_query($sqljp,$dbi);
                    while($datajp = mysql_fetch_array($resjp)){
                        $jpid = $datajp['jp_id'];
                        $jpdesc = $datajp['jp_desc'];

                        echo "<option ";
                        if($putype==$jpid){
                            echo " SELECTED ";
                        }
                        echo " value='$jpid'>$jpdesc</option>";
                    } 
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="120" valign="middle" class="title">Penerangan</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <textarea name="txtPudesc" rows="3" wrap="physical" cols="80"><?php echo $pudesc;?></textarea>
        </td>
    </tr>
    <div id="kosbulanan">
        <tr>
            <td>Kos Bulanan</td>
            <td>:</td>
            <td><input type="text" name="txtkosbulanan" id="txtkosbulanan" value="<?php echo $pumonfee;?>"/></td>
        </tr>
    </div>
    <tr>
	   <td colspan="3">
        	<input type="hidden" name="puid" value="<?php echo $puid;?>"/>
        	<input type="hidden" name="flg" value="<?php echo $flg;?>"/>
        	<input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
        	<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan'" class="button"/>
    	</td>
    </tr> 
</table>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#txtjenispengurusan").on('change',function(){
            if($(this).val()=="5"){
                $("#txtkosbulanan").removeAttr('disabled')
            } else {
                $("#txtkosbulanan").attr('disabled','disabled'); 
            }
        });
    });
</script>