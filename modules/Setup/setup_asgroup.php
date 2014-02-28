<?php

$tid = $_GET['sysid'];

if($_POST['submit']){
    $taskdesc = mysql_real_escape_string($_POST['txtAssetDesc']);
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO asset_group (ag_desc) VALUES ('$taskdesc')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE asset_group SET ag_desc='$taskdesc' WHERE ag_id='$tid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=setup_asset");
    
}


$flg = "add";
$check = "SELECT ag_desc, ag_id FROM asset_group WHERE ag_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $adesc = $a['ag_desc'];
    $aid = $a['ag_id'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="3" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Asset Group</td>
    </tr>
    <tr>
        <td width="220" valign="middle" class="title">Asset Group Description</td>
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
            <input type="submit" value="Submit" name="submit" class="button"/ onClick="return confirm('Do you wish to proceed?');">
            <input type="button" name="back" value="Back" onclick="location.href='mainpage.php?module=Setup&task=list_sysgroup'" class="button"/>
        </td>
    </tr> 
</table>
</form>
