<?php
session_start();
$staffrole = $_SESSION['userrole'];
$staffid = $_SESSION['staffid'];

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

    $check = "SELECT id FROM tbl_workorder WHERE id='$iddelete'";
    $rescheck = mysql_query($check,$dbi);
    if(mysql_num_rows($rescheck)>0){
        $delete = mysql_query("DELETE FROM tbl_workorder WHERE id='$iddelete'");
        pageredirect("mainpage.php?module=Setup&task=list_workorder");
    }
}

?>
<div style="text-align:right;font-weight:bold;">
    <?php if ($staffrole<>15 && $staffrole<>14) {
        echo "<a href=\"mainpage.php?module=Setup&task=setup_workorder\">Tambah<img src=\"images/admin/btn_add.gif\"></a>";
    } ?>
</div><br>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6">Senarai Arahan Kerja</td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <th width="50">Tarikh</th>
        <th width="250">Sub Sistem</th>
        <th>Juruteknik Bertugas</th>
        <th width="50">Status</th>
        <th width="15">Tindakan</td>
    </tr>
    <?php

    $sql = "SELECT task_date, task_id, staff_id, id, ws_id FROM tbl_workorder WHERE 1";
    if($staffid<>""){
        $sql .=" and staff_id='$staffid'";
    }
    if($staffrole==14){
        $sql .=" and ws_id='3' or ws_id='4'";
    }
    $sql .= " ORDER BY task_date";
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $idworkorder = $data['id'];
        $taskdate = fmtdate($data['task_date']);
        $taskid = $data['task_id'];
        $tugasan = GetDesc("task","task_desc","task_id",$taskid);
        $staffid = $data['staff_id'];
        $stat = $data['ws_id'];
        $wstatus = GetDesc("work_status","ws_desc","ws_id",$stat);
        $namastaff = GetDesc("staff","staff_name","staff_id",$staffid);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$taskdate</td>";
        echo "<td>$tugasan</td>";
        echo "<td>$namastaff</td>";
        echo "<td>$wstatus</td>";
        echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_workorder&sysid=$idworkorder\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_workorder&delete=1&iddelete=$idworkorder\" onClick=\"return confirm('Anda pasti?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_workorder", $limit, $rowstart, $numrows);
    ?>
</div>
