<script type="text/javascript">
    function checkform(){
        if (document.frmtask.txtSystemGroup.value=="") {
            alert("Sila pilih Kumpulan Sistem.");
            document.frmtask.txtSystemGroup.focus();
            return false;
        }
        else if (document.frmtask.txtAsetGroup.value=="") {
            alert("Sila pilih Kumpulan Aset.");
            document.frmtask.txtAsetGroup.focus();
            return false;
        }
        else if (document.frmtask.txtName.value==""){
            alert("Sila masukkan nama juruteknik.");
            document.frmtask.txtName.focus();
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
    $namastaff = mysql_real_escape_string($_POST['txtName']);
    $sysgroup = $_POST['txtSystemGroup'];
    $agroup = $_POST['txtAsetGroup'];
    
    $flg = $_POST['flg'];
    
    if($flg == "add"){
        // ID staff
        $sqlidstaf="SELECT max(staff_id) as id_staff FROM staff";
        $residstaf=mysql_query($sqlidstaf,$dbi);
        $x=mysql_fetch_array($residstaf);
        $idstaf=$x["id_staff"];

        if ($idstaf<>"") {
            $idstaf=substr($idstaf,-4);
            $idbaru=$idstaf+1;
            $idbaru=sprintf("%04d",$idbaru);
        }
        else {
            $idbaru="0001";
        }

        $idstafbaru=date(Y).$idbaru;

        $insert = "INSERT INTO staff (staff_id,staff_name, staff_ag_id, staff_sg_id) VALUES ('$idstafbaru','$namastaff','$agroup','$sysgroup')";
        // die($insert);
        sql_query($insert,$dbi);

        $tambah = "INSERT INTO user (login, password, role, nama, staff_id) VALUES ('$idstafbaru','".md5(123)."','15','$namastaff','$idstafbaru')";
        mysql_query($tambah,$dbi);
    } elseif($flg == "edit"){
        $update = "UPDATE staff SET staff_name='$namastaff', staff_ag_id='$agroup', staff_sg_id='$sysgroup' WHERE staff_id='$tid'";
        //die($update);
        sql_query($update,$dbi);

        $edit = "UPDATE user SET nama='$namastaff' WHERE id='".$_SESSION['staff_id_table_user']."'";
        mysql_query($edit,$dbi);
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_technician");
    
}


$flg = "add";
$check = "SELECT staff_name, staff_ag_id, staff_sg_id FROM staff WHERE staff_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $tname = $a['staff_name'];
    $tagid = $a['staff_ag_id'];
    $tsgid = $a['staff_sg_id'];
    
    $check_id = GetDesc("user","id","login",$tid);
    $_SESSION['staff_id_table_user'] = $check_id;
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="0" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Juruteknik</td>
    </tr>
    <tr>
        <td>ID Juruteknik</td>
        <td>:</td>
        <td><input type="text" name="txtIdStaf" id="txtIdStaf" value="<?php echo $tid; ?>" readonly onclick="alert('Dijana oleh sistem secara automatik');" /> </td>
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
        <td width="220" valign="middle" class="title">Kumpulan Aset</td>
        <td width="5" valign="middle" class="title">:</td>
        <td> 
            <select name="txtAsetGroup" id="txtAsetGroup">
                <option value="">- PILIH -</option>
                <?php
                    $sql = "SELECT ag_id, ag_desc FROM asset_group ORDER BY ag_id";
                    $res = mysql_query($sql,$dbi);
                    while($sgdata = mysql_fetch_array($res)){
                        $sgid = $sgdata['ag_id'];
                        $sgdesc = $sgdata['ag_desc'];

                        echo "<option ";
                        if($sgid==$tagid){
                            echo " SELECTED ";
                        }
                        echo" value='$sgid'>$sgdesc</option>";
                    }
                ?>
            </select>
        </td>
    </tr>
    <!-- <tr>
        <td width="120" valign="middle" class="title">Penerangan Tugasan</td>
        <td width="5" valign="middle" class="title">:</td>
        <td>
            <textarea name="txtTaskDesc" rows="3" wrap="physical" cols="80"><?php echo $tdesc;?></textarea>
        </td>
    </tr> -->
    <tr>
        <td width="120">Nama Juruteknik</td>
        <td width="5">:</td>
        <td><input type="text" name="txtName" size="80" maxlength="100" value="<?php echo $tname; ?>"/></td>
    </tr>
    <!-- <tr>
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
            <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_technician'" class="button"/>
        </td>
    </tr> 
</table>
</form>
