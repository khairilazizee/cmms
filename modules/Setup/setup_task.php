<?php

$tid = $_GET['taskid'];

if($_POST['submit']){
    $bank_p = mysql_real_escape_string($_POST['txtBank']);
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO payment_bank (bank_name) VALUES ('$bank_p')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE payment_bank SET bank_name='$bank_p' WHERE bank_id='$bankid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_payment_bank");
    
}


$flg = "add";
$check = "SELECT task_desc, task_ag_id, task_staff_id, task_asset_id, task_sys_id, task_date FROM task WHERE task_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $tdesc = $a['task_desc'];
    $tagid = $a['task_ag_id'];
    $tstaff = $a['task_staff_id'];
    $tasset = $a['task_asset_id'];
    $tsystem = $a['task_sys_id'];
    $tdate = $a['task_date'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="0" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" colspan="3">Setup Task</td>
    </tr>
    <tr>
        <td width="120" valign="top">Task Description</td>
        <td width="5" valign="top">:</td>
        <td>
            <textarea rows="3" wrap="physical" cols="80"></textarea>
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
    <tr>
        <td colspan="3">
            <input type="hidden" name="taskid" value="<?php echo $bankid;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Submit" name="submit" class="button"/ onClick="return confirm('Do you wish to proceed?');">
            <input type="button" name="back" value="Back" onclick="location.href='mainpage.php?module=Setup&task=list_task'" class="button"/>
        </td>
    </tr> -->
</table>
</form>
