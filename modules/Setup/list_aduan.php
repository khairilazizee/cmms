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
<div style="float:left">
    <form action="" method="POST" name="ftmtarikh">
        Tarikh Mula <input type="text" name="txtTarikhMula" id="txtTarikhMula" value="<?php echo $tarikhmula;?>">
         <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.ftmtarikh.txtTarikhMula);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
         Tarikh Tamat <input type="text" name="txtTarikhAkhir" id="txtTarikhAkhir" value="<?php echo $tarikhakhir;?>">
          <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.ftmtarikh.txtTarikhAkhir);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
        <input type="submit" name="submitcarian" class="button" value="carian">
    </form>
</div>
<div style="text-align:right;font-weight:bold;">
    <?php if ($staffrole<>15 && $staffrole<>14) {
        echo "<a href=\"mainpage.php?module=Setup&task=setup_aduan\">Tambah<img src=\"images/admin/btn_add.gif\"></a>";
    } ?>
</div><br>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6">Senarai Aduan</td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <th width="70">Tarikh Aduan</th>
        <th width="70">Kaedah Aduan</th>
        <th width="250">Pengadu</th>
        <th width="250">Juruteknik Bertugas</th>
        <!-- <th width="50">Status</th> -->
        <th width="15">Tindakan</td>
    </tr>
    <?php

    $sql = "SELECT ad_id, ad_pengadu, ad_kaedah, ad_tarikh_adu, ad_staff_id FROM tbl_aduan WHERE 1";
    // if($staffid<>""){
    //     $sql .=" and staff_id='$staffid'";
    // }
    // if($staffrole==14){
    //     $sql .=" and ws_id='3' or ws_id='4'";
    // }

    if($tarikhmula<>"" and $tarikhakhir==""){
        $sql.=" and task_date>='$tmula'";
    }
    elseif($tarikhakhir<>"" and $tarikhmula==""){
        $sql.=" and task_date<='$takhir'";
    }
    elseif($tarikhmula<>"" and $tarikhakhir<>""){
        $sql.=" and task_date>='$tmula' and task_date<='$takhir'";
    }

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
        $taskdate = fmtdate($data['ad_tarikh_adu']);
        $staffid = $data['ad_staff_id'];
        $namastaff = GetDesc("staff","staff_name","staff_id",$staffid);
        $pengadu = $data['ad_pengadu'];
        $kaedahid = $data['ad_kaedah'];
        $kaedahdesc = GetDesc("tbl_aduan_kaedah","kad_desc","kad_id",$kaedahid);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$taskdate</td>";
        echo "<td>$kaedahdesc</td>";
        echo "<td>$pengadu</td>";
        echo "<td>$namastaff</td>";
        // echo "<td>$wstatus</td>";
        if($staffrole==13 or $staffrole==15){
            echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_aduan&sysid=$idworkorder\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_aduan&delete=1&iddelete=$idworkorder\" onClick=\"return confirm('Anda pasti?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        }
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_aduan", $limit, $rowstart, $numrows);
    ?>
</div>

<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>   
