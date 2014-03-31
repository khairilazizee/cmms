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
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0" border="1">
    <tr>
        <td style="font-weight:bold;" colspan="12">Senarai Aduan</td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <th width="80">No Aduan</th>
        <th width="150">Lokasi</th>
        <th width="200">Nama Pengadu</th>
        <th width="50">Jenis Laporan</th>
        <th width="50">Jabatan</th>
        <th width="80">Melalui</th>
        <th width="80">Tarikh Aduan</th>
        <!-- <th>Tarikh Siap</th> -->
        <!-- <th>Respon Time</th> -->
        <th width="80">Work Trade</th>
        <th width="200">Keterangan Masalah</th>
        <th width="200">Tindakan Diambil</th>
        <th width="50">Status</th>

    </tr>
    <?php

    $sql = "SELECT ad_id, ad_no_aduan, ad_lokasi, ad_pengadu, ad_jabatan, ad_kaedah, ad_tarikh_adu, ad_sg_id, ad_keterangan, ad_catatan, ad_status, ad_staff_id FROM tbl_aduan WHERE 1";
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
        $sql.=" and ad_ag_id='$staffagid'";
    }
    
    $sql .= " ORDER BY ad_tarikh_adu, ad_id";
    // echo $sql;
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $idworkorder = $data['ad_id'];
        $noaduan = $data['ad_no_aduan'];
        $lokasiid = $data['ad_lokasi'];
        $pengadu = $data['ad_pengadu'];
        $jabatan = $data['ad_jabatan'];
        $kaedahid = $data['ad_kaedah'];
        $taskdate = fmtdate($data['ad_tarikh_adu']);
        $sgid = $data['ad_sg_id'];
        $keterangan = $data['ad_keterangan'];
        $catatan = $data['ad_catatan'];
        $statusid = $data['ad_status'];
        $staffid = $data['ad_staff_id'];

        $sgdesc = GetDesc("system_group","sg_desc","sg_id",$sgid);
        $namastaff = GetDesc("staff","staff_name","staff_id",$staffid);
        $kaedahdesc = GetDesc("tbl_aduan_kaedah","kad_desc","kad_id",$kaedahid);
        $statusdesc = GetDesc("work_status","ws_desc","ws_id",$statusid);
        $lokasidesc = GetDesc("zone","zon_desc","zon_id",$lokasiid);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td align=\"center\">$noaduan</td>";
        echo "<td>$lokasidesc</td>";
        echo "<td>$pengadu</td>";
        echo "<td align=\"center\">Aduan</td>";
        echo "<td align=\"center\">$jabatan</td>";
        echo "<td align=\"center\">$kaedahdesc</td>";
        echo "<td align=\"center\">$taskdate</td>";
        echo "<td align=\"center\">$sgdesc</td>";
        echo "<td>$keterangan</td>";
        echo "<td>$catatan</td>";
        echo "<td>$statusdesc</td>";
        // echo "<td></td>";
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=view_aduan&displayframework=0", $limit, $rowstart, $numrows);
    ?>
</div>

<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>   
