<?php

$tid = $_GET['assetid'];

if($_POST['submit']){
    $taskdesc = mysql_real_escape_string($_POST['txtAssetDesc']);
    $systemgroup = $_POST['txtSystemGroup'];
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO asset (asset_desc,asset_ag_id) VALUES ('$taskdesc','$systemgroup')";
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE asset SET asset_desc='$taskdesc', asset_ag_id='$systemgroup' WHERE asset_id='$tid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_asset");
    
}


$flg = "add";
$check = "SELECT asset_id, asset_desc, asset_ag_id FROM asset WHERE asset_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $adesc = $a['asset_desc'];
    $aid = $a['asset_id'];
    $agid = $a['asset_ag_id'];
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="3" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Setup Assets</td>
    </tr>
    <tr>
        <td width="220" valign="middle" class="title">Asset Group</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <select name="txtSystemGroup" id="txtSystemGroup">
                <option value="">- PILIH -</option>
                <?php
                    $sql = "SELECT ag_id, ag_desc FROM asset_group ORDER BY ag_id";
                    $res = mysql_query($sql,$dbi);
                    while($sgdata = mysql_fetch_array($res)){
                        $sgid = $sgdata['ag_id'];
                        $sgdesc = $sgdata['ag_desc'];

                        echo "<option ";
                        if($agid==$sgid){
                            echo " SELECTED ";
                        }
                        echo" value='$sgid'>$sgdesc</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="220" valign="middle" class="title">Assets Description</td>
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
            <input type="button" name="back" value="Back" onclick="location.href='mainpage.php?module=Setup&task=list_asset'" class="button"/>
        </td>
    </tr> 
</table>
</form>
