<script type="text/javascript">
    function checkform(){
        if (document.frmtask.txtSystemGroup.value=="") {
            alert("Sila pilih Kumpulan Sistem.");
            document.frmtask.txtSystemGroup.focus();
            return false;
        }
        else if (document.frmtask.txtTaskDesc.value==""){
            alert("Sila masukkan penerangan tugasan.");
            document.frmtask.txtTaskDesc.focus();
            return false;
        }
        else{
            return confirm("Adakah anda pasti?");
        }
    }
</script>
<?php

$tid = $_GET['taskid'];

if($_POST['submit']){
    $taskdesc = mysql_real_escape_string($_POST['txtTaskDesc']);
    $sysgroup = $_POST['txtSystemGroup'];
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO task (task_desc, task_sg_id) VALUES ('$taskdesc','$sysgroup')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE task SET task_desc='$taskdesc', task_sg_id='$sysgroup' WHERE task_id='$tid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_task");
    
}


$flg = "add";
$check = "SELECT task_desc, task_sg_id FROM task WHERE task_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $tdesc = $a['task_desc'];
    $tsgid = $a['task_sg_id'];
    // $tagid = $a['task_ag_id'];
    // $tstaff = $a['task_staff_id'];
    // $tasset = $a['task_asset_id'];
    // $tsystem = $a['task_sys_id'];
    // $tdate = $a['task_date'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="0" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Tugasan</td>
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

                        echo "<option value='$sgid' "; 
                        if($sgid==$tsgid)
                            echo "selected "; 
                        echo ">$sgdesc</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="120" valign="middle" class="title">Penerangan Tugasan</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <textarea name="txtTaskDesc" rows="3" wrap="physical" cols="80"><?php echo $tdesc;?></textarea>
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
    </tr>
    <tr> -->
        <td colspan="3">
            <input type="hidden" name="taskid" value="<?php echo $bankid;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
            <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_task'" class="button"/>
        </td>
    </tr> 
</table>
</form>
