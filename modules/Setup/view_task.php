<?php

session_start();
$staffrole = $_SESSION['userrole'];
$staffid = $_SESSION['staffid'];
kebenaran($_SESSION['login']);
$staffagid = $_SESSION['staffagid'];
// echo "Staff ID=".$staffid;

if($staffrole<>14 && $staffrole<>15)
    $info="enabled";
else
    $info="disabled";

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

if($_GET['delete']==1){
    $iddelete = mysql_real_escape_string($_GET['iddelete']);

    $check = "SELECT ad_id FROM tbl_aduan WHERE ad_id='$iddelete'";
    $rescheck = mysql_query($check,$dbi);
    if(mysql_num_rows($rescheck)>0){
        $delete = mysql_query("DELETE FROM tbl_aduan WHERE ad_id='$iddelete'");
        pageredirect("mainpage.php?module=Setup&task=list_aduan");
    }
}

if($_POST['submitcarian']){
    $tarikhmula = mysql_real_escape_string($_POST['txtTarikhMula']);
    $tmula = mysqldate($tarikhmula);
    $tarikhakhir = mysql_real_escape_string($_POST['txtTarikhAkhir']);
    $takhir = mysqldate($tarikhakhir);
}

?>
<!-- <div style="float:left">
    <form action="" method="POST" name="ftmtarikh">
        Tarikh Mula <input type="text" name="txtTarikhMula" id="txtTarikhMula" value="<?php echo $tarikhmula;?>">
         <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.ftmtarikh.txtTarikhMula);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
         Tarikh Tamat <input type="text" name="txtTarikhAkhir" id="txtTarikhAkhir" value="<?php echo $tarikhakhir;?>">
          <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.ftmtarikh.txtTarikhAkhir);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
        <input type="submit" name="submitcarian" class="button" value="carian">
    </form>
</div>
<br> -->
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="12">Senarai Tugasan</td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <!-- <th width="80">No Aduan Kerja</th> -->
        <!-- <th width="150">Lokasi</th> -->
        <!-- <th width="200">Nama Pengadu</th> -->
        <th width="50">Jenis Laporan</th>
        <th width="50">Jabatan</th>
        <!-- <th width="80">Melalui</th> -->
        <th width="80">Tarikh Tugasan</th>
        <!-- <th>Tarikh Siap</th> -->
        <!-- <th>Respon Time</th> -->
        <th width="80">Work Trade</th>
        <th width="200">Keterangan Tugas</th>
        <th width="200">Catatan Juruteknik</th>
        <th width="50">Status</th>

    </tr>
    <?php

    $sql = "SELECT id, sg_id, sys_id, tg_id, staff_id, task_date, work_start, ag_id, asset_id, ws_id, catatan, catatan_juruteknik  FROM tbl_workorder WHERE 1";
    // if($staffid<>""){
    //     $sql .=" and staff_id='$staffid'";
    // }
    // if($staffrole==14){
    //     $sql .=" and ws_id='3' or ws_id='4'";
    // }

    // if($tarikhmula<>"" and $tarikhakhir==""){
    //     $sql.=" and task_date>='$tmula'";
    // }
    // elseif($tarikhakhir<>"" and $tarikhmula==""){
    //     $sql.=" and task_date<='$takhir'";
    // }
    // elseif($tarikhmula<>"" and $tarikhakhir<>""){
    //     $sql.=" and task_date>='$tmula' and task_date<='$takhir'";
    // }

    if($staffagid<>0){
        $sql.=" and ag_id='$staffagid'";
    }
    
    $sql .= " ORDER BY task_date, id";
    // echo $sql;
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $idworkorder = $data['id'];
        $tgid = $data['tg_id'];
        // $noaduan = $data['ad_no_aduan'];
        // $lokasiid = $data['ad_lokasi'];
        // $pengadu = $data['ad_pengadu'];
        // $jabatan = $data['ad_jabatan'];
        // $kaedahid = $data['ad_kaedah'];
        $taskdate = fmtdate($data['task_date']);
        $agid = $data['ag_id'];
        $sgid = $data['sg_id'];
        // $keterangan = $data['ad_keterangan'];
        $catatan = $data['catatan_juruteknik'];
        $statusid = $data['ws_id'];
        $staffid = $data['staff_id'];

        if($agid==1){
            $jabatan="TPM";
        }
        else{
            $jabatan="PM";
        }

        $sgdesc = GetDesc("system_group","sg_desc","sg_id",$sgid);
        $namastaff = GetDesc("staff","staff_name","staff_id",$staffid);
        $kaedahdesc = GetDesc("tbl_aduan_kaedah","kad_desc","kad_id",$kaedahid);
        $statusdesc = GetDesc("work_status","ws_desc","ws_id",$statusid);
        $lokasidesc = GetDesc("zone","zon_desc","zon_id",$lokasiid);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td valign=\"top\" align=\"center\">$cnt</td>";
        // echo "<td align=\"center\">$noaduan</task_date>";
        // echo "<td>$lokasidesc</td>";
        // echo "<td>$pengadu</td>";
        echo "<td valign=\"top\" align=\"center\">Tugasan Berjadual</td>";
        echo "<td valign=\"top\" align=\"center\">$jabatan</td>";
        // echo "<td align=\"center\">$kaedahdesc</td>";
        echo "<td valign=\"top\" align=\"center\">$taskdate</td>";
        echo "<td valign=\"top\" align=\"center\">$sgdesc</td>";
        echo "<td valign=\"top\"><ul style=\"margin-left:-15\">";

        $sqltask=mysql_query("SELECT task_id, task_desc FROM task WHERE tg_id='$tgid'",$dbi);
        while($datatask=mysql_fetch_array($sqltask)){
            $tid=$datatask['task_id'];
            $tdesc=$datatask['task_desc'];

            echo "<li>$tdesc</li>";
        }

        echo "</ul></td>";
        echo "<td valign=\"top\">$catatan</td>";
        echo "<td valign=\"top\">$statusdesc</td>";
        // echo "<td></td>";
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=view_task&displayframework=0", $limit, $rowstart, $numrows);
    ?>
</div>

<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>   
