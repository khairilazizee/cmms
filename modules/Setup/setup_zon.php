<script type="text/javascript">
    function checkform(){
        var desc=document.frmtask.txtDescription.value;
        if(desc==""){
            alert("Sila isi penerangan zon.");
            document.frmtask.txtDescription.focus();
            return false;
        }
        else{
            return confirm("Adakah anda pasti?");
        }
        
    }
</script>

<?php

$tid = $_GET['zonid'];

if($_POST['submit']){
    $tdesc_p = mysql_real_escape_string($_POST['txtDescription']);
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        $insert = "INSERT INTO zone (zon_desc) VALUES ('$tdesc_p')";
        // die($insert)
        sql_query($insert,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE zone SET zon_desc='$tdesc_p' WHERE zon_id='$tid'";
        //die($update);
        sql_query($update,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_zon");
    
}


$flg = "add";
$check = "SELECT zon_desc FROM zone WHERE zon_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $tdesc = $a['zon_desc'];
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
        <td style="font-weight:bold;" colspan="3">Penyediaan Zon</td>
    </tr>
    <tr>
        <td width="120" valign="top">Penerangan Zon</td>
        <td width="5" valign="top">:</td>
        <td>
            <textarea name="txtDescription" id="txtDescription" rows="3" wrap="physical" cols="80"><? echo "$tdesc"; ?></textarea>
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
            <input type="hidden" name="zonid" value="<?php echo $tid;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Submit" name="submit" class="button" onClick="return checkform();">
            <input type="button" name="back" value="Back" onclick="location.href='mainpage.php?module=Setup&task=list_zon'" class="button"/>
        </td>
    </tr>
</table>
</form>
