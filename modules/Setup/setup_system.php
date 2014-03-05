<script type="text/javascript">
    function checkform(){
        if (document.frmtask.txtSystemGroup.value=="") {
            alert("Sila pilih Kumpulan Sistem.");
            document.frmtask.txtSystemGroup.focus();
            return false;
        }
        else if (document.frmtask.txtAssetDesc.value==""){
            alert("Sila masukkan penerangan sistem.");
            document.frmtask.txtAssetDesc.focus();
            return false;
        }
        else{
            return confirm("Adakah anda pasti?");
        }
    }
</script>
<?php

$tid = $_GET['assetid'];

if($_POST['submit']){
    $taskdesc = mysql_real_escape_string($_POST['txtAssetDesc']);
    $sysgroup = $_POST['txtSystemGroup'];
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO system (sys_desc, sys_sg_id) VALUES ('$taskdesc','$sysgroup')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE system SET sys_desc='$taskdesc', sys_sg_id='$sysgroup' WHERE sys_id='$tid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_system");
    
}


$flg = "add";
$check = "SELECT sys_desc, sys_id FROM system WHERE sys_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $adesc = $a['sys_desc'];
    $aid = $a['sys_id'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="3" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Sistem</td>
    </tr>
    <tr>
        <td width="220" valign="middle" class="title">Kumpulan Sistem</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <select name="txtSystemGroup" id="txtSystemGroup">
                <option value="">- PILIH -</option>
                <?php
                    $sql = "SELECT sg_id, sg_desc FROM system_group ORDER BY sg_id";
                    $res = mysql_query($sql,$dbi);
                    while($sgdata = mysql_fetch_array($res)){
                        $sgid = $sgdata['sg_id'];
                        $sgdesc = $sgdata['sg_desc'];

                        echo "<option value='$sgid'>$sgdesc</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="220" valign="middle" class="title">Penerangan Sistem</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <textarea name="txtAssetDesc" rows="3" wrap="physical" cols="100%"><?php echo $adesc;?></textarea>
        </td>
    </tr>
    <!-- <tr>
        <td width="120">Asset Group</td>
        <td width="5">:</td>
        <td><input type="text" name="txtTag" size="40" value="<?php echo $tagid;?>"/></td>
    </tr>
    <tr>
        <td width="120">Asset</td>
        <td width="5">:</td>
        <td><input type="text" name="txtTasset" size="40" value="<?php echo $tasset;?>"/></td>
    </tr>
    <tr>
        <td width="120">Person In Charge</td>
        <td width="5">:</td>
        <td><input type="text" name="txtTstaff" size="40" value="<?php echo $tstaff;?>"/></td>
    </tr>
    <tr>
        <td width="120">System</td>
        <td width="5">:</td>
        <td><input type="text" name="txtTsystem" size="40" value="<?php echo $tsystem;?>"/></td>
    </tr>
    <tr>
        <td width="120">Date</td>
        <td width="5">:</td>
        <td><input type="text" name="txtTdate" size="40" value="<?php echo $tdate;?>"/></td>
    </tr> -->
    <tr>
        <td colspan="3">
            <input type="hidden" name="assetid" value="<?php echo $aid;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
            <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_system'" class="button"/>
        </td>
    </tr> 
</table>
</form>
