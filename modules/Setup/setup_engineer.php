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
        else if(document.frmtask.check.checked==false){
            var counter=document.frmtask.prgcount.value;
            var prgcount=0;
            for(var count=1;count<=counter;count++){
                // if(document.frmadddrop.prg[count].checked==true)
                if(document.getElementById("prg"+count).checked==true)
                    prgcount++;
            }
            if(prgcount==0){
                alert('Sila pilih sub sistem');
                return false;
            }
            else{
                return confirm('Adakah anda pasti?');
            }
        }
        else{
            return confirm("Adakah anda pasti?");
        }
    }

    function checkall(){
        var counter=document.frmtask.prgcount.value;
        
        if(document.frmtask.check.checked==true){
            for(var count=1;count<=counter;count++){
                document.getElementById("prg"+count).checked=true;
            }
        } else {
            for(var count=1;count<=counter;count++){
                document.getElementById("prg"+count).checked=false;
            }
        }
    }
</script>
<?php

$tid = $_GET['taskid'];

if($_POST['submit']){
    $namastaff = mysql_real_escape_string($_POST['txtName']);
    $sysgroup = $_POST['txtSystemGroup'];
    $agroup = $_POST['txtAsetGroup'];
    $cvcount = $_POST["prgcount"];

    $flg = $_POST['flg'];
    
    if($flg == "add"){
        // ID staff
        $sqlidstaf="SELECT max(eng_id) as id_staff FROM tbl_engineer";
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

        $idstafbaru="E".$idbaru;

        $insert = "INSERT INTO tbl_engineer (eng_id, eng_name, eng_ag_id, eng_sg_id) VALUES ('$idstafbaru','$namastaff','$agroup','$sysgroup')";
        // die($insert);
        sql_query($insert,$dbi);

        $tambah = "INSERT INTO user (login, password, role, nama, staff_id) VALUES ('$idstafbaru','".md5(123)."','15','$namastaff','$idstafbaru')";
        mysql_query($tambah,$dbi);

        for($i=1;$i<=$cvcount;$i++){
            $cvprg=$_POST["prg".$i];
            // die($cvprg." "."prg".$i." ".$cvcount);
            if($cvprg<>""){
                $insertprg = "INSERT INTO tbl_engineer_tg (eng_id,tg_id) VALUES ('$idstafbaru','$cvprg')";
                sql_query($insertprg,$dbi);
            }
        }

    } elseif($flg == "edit"){
        $update = "UPDATE tbl_engineer SET eng_name='$namastaff', eng_ag_id='$agroup', eng_sg_id='$sysgroup' WHERE eng_id='$tid'";
        //die($update);
        sql_query($update,$dbi);

        $edit = "UPDATE user SET nama='$namastaff' WHERE id='".$_SESSION['staff_id_table_user']."'";
        mysql_query($edit,$dbi);

        for($i=1;$i<=$cvcount;$i++){
            $cvprg=$_POST["prg".$i];
            if($cvprg==""){
                $cvprog=$_POST["prog".$i];
                // die("azizi");
                $sqlcheck ="select tg_id from tbl_engineer_tg where eng_id='$tid' and tg_id='$cvprog'";
                //die($sqlcheck);
                $checkres = mysql_query($sqlcheck,$dbi);
                if(mysql_num_rows($checkres)>0){
                    $deleteprg = "DELETE FROM tbl_engineer_tg where eng_id='$tid' and tg_id='$cvprog'";
                    sql_query($deleteprg,$dbi);
                }
            }
            else{
                $sqlcheck ="select tg_id from tbl_engineer_tg where eng_id='$tid' and tg_id='$cvprg'";
                $checkres = mysql_query($sqlcheck,$dbi);
                if(!mysql_num_rows($checkres)>0){
                    $updateprg = "INSERT INTO tbl_engineer_tg (eng_id,tg_id) VALUES ('$tid','$cvprg')";
                    sql_query($updateprg,$dbi);
                }
            }
        }
    }
    
    pageredirect("mainpage.php?module=Setup&task=list_engineer");
    
}


$flg = "add";
$check = "SELECT eng_name, eng_ag_id, eng_sg_id FROM tbl_engineer WHERE eng_id='$tid'";
//echo $check;
$result = sql_query($check,$dbi);
if($a = mysql_fetch_array($result)){
    $flg = "edit";
    $tname = $a['eng_name'];
    $tagid = $a['eng_ag_id'];
    $tsgid = $a['eng_sg_id'];
    // $ttgid = $a['eng_tg_id'];

    $check_id = GetDesc("user","id","login",$tid);
    $_SESSION['staff_id_table_user'] = $check_id;
}

?>
<form name="frmtask" method="POST" action="">
<table width="100%" cellspacing="3" cellpadding="0" align="center" class="outerform">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Jurutera</td>
    </tr>
    <tr>
        <td>ID Jurutera</td>
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
    <tr>
        <td width="120">Nama Jurutera</td>
        <td width="5">:</td>
        <td><input type="text" name="txtName" size="80" maxlength="100" value="<?php echo $tname; ?>"/></td>
    </tr>
    <tr>
        <td colspan="6">
            <table width="100%" cellspacing="0" cellpadding="3" align="center" class="outerform" border="0">
                <tr>
                    <td colspan="6"><strong>Sub Sistem</strong></td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" name="check" id="check" onclick="return checkall();" />
                        <strong><font color="crimson">Pilih Semua</font></strong>
                    </td>
                    <?php if($itemid!=''){ ?>
                    <td align="center">
                        <input type="button" name="studlist" id="studlist" value="View Student List" class="button" onclick="location.href='mainpage.php?module=Convocation&task=list_student_attendance&id=<?php echo $itemid; ?>';" />
                    </td>
                    <?php } ?>
                </tr>
                <?php
                    $counter=0;
                    $count=0;
                    
                    $resprog=sql_query("select tg_id, tg_desc from task_group order by tg_id",$dbi);
                    while($dataprog=sql_fetch_array($resprog)){
                        $tgid=$dataprog["tg_id"];
                        $tgdesc=$dataprog["tg_desc"]; 

                        $count++;
                        
                        $resprg=sql_query("select tg_id from tbl_engineer_tg where eng_id='$tid' and tg_id='$tgid' ",$dbi);
                        $dataprg=sql_fetch_array($resprg);
                        $codeprg=$dataprg["tg_id"];
                        if($tgid==$codeprg)
                            $checked="checked";
                        else
                            $checked = "";
                        
                        if($counter<2)
                            $counter++;
                        else
                            $counter=1;
                        
                        if($counter==1)
                            echo "<tr><td width=\"50%\"><input type=\"checkbox\" name=\"prg$count\" id=\"prg$count\" value=\"$tgid\" $checked />$tgdesc<input type=\"hidden\" name=\"prog$count\" id=\"prog$count\" value=\"$tgid\" /></td>";
                        // elseif($counter==2)
                        //     echo "<td width=\"30%\"><input type=\"checkbox\" name=\"prg$count\" id=\"prg$count\" value=\"$tgid\" $checked />$tgdesc<input type=\"hidden\" name=\"prog$count\" id=\"prog$count\" value=\"$tgid\" /></td>";
                        else
                            echo "<td width=\"50%\"><input type=\"checkbox\" name=\"prg$count\" id=\"prg$count\" value=\"$tgid\" $checked />$tgdesc<input type=\"hidden\" name=\"prog$count\" id=\"prog$count\" value=\"$tgid\" /></td></tr>";           
                    }
                ?>
                <tr>
                    <td colspan="3">
                        <input type="hidden" name="prgcount" id="prgcount" value="<?php echo $count; ?>" />
                        
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <input type="hidden" name="taskid" value="<?php echo $bankid;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Hantar" name="submit" class="button"/ onClick="return checkform();">
            <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_engineer'" class="button"/>
        </td>
    </tr> 
</table>
</form>
