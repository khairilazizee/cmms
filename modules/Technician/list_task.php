<?php

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;
$userrole = $_SESSION['userrole'];
$staffid = $_SESSION['staffid'];

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

!isset($_SESSION['tarikhsemasa']) ? $tarikhsemasa = date("d/m/Y") : $tarikhsemasa = $_SESSION['tarikhsemasa'];

$subsistem = mysql_real_escape_string($_GET['sub']);
$idworkorder = mysql_real_escape_string($_GET['sis']);
$tarikhbermula = date("Y-m-d");

$statuskerja = GetDesc("tbl_workorder","ws_id","id",$idworkorder);

if($statuskerja=="1"){
    $update = "UPDATE tbl_workorder SET ws_id='2', work_start='$tarikhbermula' WHERE id='$idworkorder'";
    $resupdate = mysql_query($update,$dbi);
}


if($_POST['workorder']){
    $catatankeseluruhan = mysql_real_escape_string($_POST['txtCatatanKeseluruhan']);
    $tarikhselesai = date("Y-m-d");
    $total = $_POST['total'];
    $start = 1;
    while($total <= $total){
        $idtugasan = $_POST['id'.$start];
        $catatantugasan = mysql_real_escape_string($_POST['txtCatatan'.$start]);
        $statustugasan = $_POST['txtStatus'.$start];
        $selesaitugasan = $_POST['chkSelesai'.$start];

        if($selesaitugasan==1){
            $updatetugasan = "UPDATE task SET date_work_done='$tarikhselesai', catatan='$catatantugasan', status='$statustugasan', selesai='$selesaitugasan', ModifiedBy='$staffid', ModifiedDate='$tarikhselesai' WHERE task_id='$idtugasan'";
            mysql_query($updatetugasan,$dbi);
        }
    }

    $catatanjuruteknik = "UPDATE tbl_workorder SET catatan_juruteknik='$catatankeseluruhan' WHERE id='$idworkorder'";
    mysql_query($catatanjuruteknik,$dbi);

    pageredirect("mainpage.php?module=Technician&task=workorder");
}


?>
<form action="" method="POST">
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6">
            <div style="float: left";>Senarai tugasan pada <?php echo $tarikhsemasa;?></div>
            <div style="float: right";><input type="button" name="back" class="button" value="Kembali" onclick="location.href='mainpage.php?module=Technician&task=workorder';" /></div>
        </td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <th width="50">Tarikh</th>
        <th>Tugasan</th>
        <!-- <th width="250">Tugasan</th> -->
        <th width="50">Selesai</th>
        <th width="15">Status</td>
        <th>Catatan</th>
    </tr>
    <?php
        $sqltask = "SELECT task_id, task_desc FROM task WHERE tg_id='$subsistem'";
        // echo $sqltask;
        $sqlfull = $sqltask." LIMIT ".$rowstart.", ".$limit;
        $res = sql_query($sqltask,$dbi);
        $resfull = sql_query($sqlfull,$dbi);
        $cnt=$rowstart;
        $numrows = mysql_num_rows($res);
        while($datatask = mysql_fetch_array($resfull)){
            $cnt++;
            $taskid = $datatask['task_id'];
            $taskdesc = $datatask['task_desc'];
            $taskdate = GetDesc("tbl_workorder","task_date","id",$idworkorder);

            echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
            echo "<td>$cnt</td>";
            echo "<td>".fmtdate($taskdate)."</td>";
            echo "<td>$taskdesc</td>";
            echo "<td align='center'><input type='checkbox' name='chkSelesai$cnt' value='1'/></td>";
            echo "<td>";
            ?>
                <select name="txtStatus<?php echo $cnt;?>" id="txtStatus">
                    <option value="">- PILIH -</option>
                    <option value="1">Berjaya</option>
                    <option value="2">Gagal</option>
                </select>
            <?php
            echo "</td>";
            echo "<td>
                <textarea name='txtCatatan$cnt' rows='5' cols='20'></textarea>
                <input type='hidden' name='id$cnt' value='$taskid'/>
            </td>";
            echo "</tr>";
        }
    ?>
    <tr>
        <td colspan="6">
            <div style="font-weight:bold;">Catatan Keseluruhan&nbsp;:&nbsp;</div>
            <textarea name="txtCatatanKeseluruhan" rows="10" cols="150"></textarea>
        </td>
    </tr>
    <tr>
        <td colspan="6">
            <input type="hidden" name="total" value="<?php echo $cnt;?>"/>
            <input type="submit" class="button" value="Hantar" name="workorder"/>
            <input type="button" class="button" value="Kembali" name="kembali" onclick="location.href='mainpage.php?module=Technician&task=workorder'"/>
        </td>
    </tr>
</table>
</form>

<?php

if($_POST['inspection']){
    $inspection_status = $_POST['inspection_status'];
    $catatanpemeriksaan = mysql_real_escape_string($_POST['txtCatatanPemeriksaan']);

    $updatepemeriksaan = "UPDATE tbl_workorder SET inspection_status='$inspection_status' , inspection_remarks='$catatanpemeriksaan' WHERE id='$idworkorder'";
    mysql_query($updatepemeriksaan,$dbi);

    pageredirect("mainpage.php?module=Technician&task=workorder");
}

?>

<form action="" method="POST">
    <table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
        <tr>
            <td style="font-weight:bold;" colspan="6">Laporan Pemeriksaan</td>
        </tr>
        <tr>
            <td width="5"><input type="radio" name="inspection_status" value="1"></td>
            <td>BAGUS</td>
            <td width="5"><input type="radio" name="inspection_status" value="2"></td>
            <td>MEMERLUKAN PEMBETULAN</td>
            <td width="5"><input type="radio" name="inspection_status" value="3"></td>
            <td>MEMERLUKAN PERTUKARAN</td>
        </tr>
        <tr>
            <td class="title" colspan="6">
                <div style="font-weight:bold;">Kerja yang perlu dilalukan / Komponen yang perlu ditukar&nbsp;:&nbsp;</div>
                <textarea name="txtCatatanPemeriksaan" rows="10" cols="150"></textarea>
            </td>
        </tr>
        <tr>
        <td colspan="6">
            <input type="submit" class="button" value="Hantar" name="inspection"/>
            <input type="button" class="button" value="Kembali" name="kembali" onclick="location.href='mainpage.php?module=Technician&task=workorder'"/>
        </td>
    </tr>
    </table>
</form>

<?php

if($_POST['rectification']){
    $rectification_status = $_POST['rectification_status'];

    $updaterectification = "UPDATE tbl_workorder SET rectification_status='$rectification_status' WHERE id='$idworkorder'";
    mysql_query($updaterectification,$dbi);

    pageredirect("mainpage.php?module=Technician&task=workorder");
}

?>

<form action="" method="POST">
    <table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
        <tr>
            <td style="font-weight:bold;" colspan="4">Laporan Pembetulan</td>
        </tr>
        <tr>
            <td width="5"><input type="radio" name="rectification_status" value="1"></td>
            <td>YA</td>
            <td width="5"><input type="radio" name="rectification_status" value="2"></td>
            <td>TIDAK</td>
        </tr>
        <tr>
        <td colspan="4">
            <input type="submit" class="button" value="Hantar" name="rectification"/>
            <input type="button" class="button" value="Kembali" name="kembali" onclick="location.href='mainpage.php?module=Technician&task=workorder'"/>
        </td>
    </tr>
    </table>
</form>

<?php

if($_POST['servicing']){
    $follow_order = $_POST['follow_order'];
    $tarikhdeclare = date("Y-m-d");

    $updateservicing = "UPDATE task SET date_declare='$tarikhdeclare', serv_follow_order='$follow_order', serv_by='$staffid' WHERE tg_id='$subsistem'";
    mysql_query($updateservicing,$dbi);

    pageredirect("mainpage.php?module=Technician&task=workorder");
}

?>

<form action="" method="POST">
    <table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
        <tr>
            <td style="font-weight:bold;" colspan="4">Perkhidmatan</td>
        </tr>
        <tr>
            <td colspan="4">Semua perkhidmatan telah dilakukan mengikut cara yang telah disyorkan oleh pengeluar peralatan.</td>
        </tr>
        <tr>
            <td width="5"><input type="radio" name="follow_order" value="1"></td>
            <td>YA</td>
            <td width="5"><input type="radio" name="follow_order" value="2"></td>
            <td>TIDAK</td>
        </tr>
        <tr>
        <td colspan="4">
            <input type="submit" class="button" value="Hantar" name="servicing"/>
            <input type="button" class="button" value="Kembali" name="kembali" onclick="location.href='mainpage.php?module=Technician&task=workorder'"/>
        </td>
    </tr>
    </table>
</form>