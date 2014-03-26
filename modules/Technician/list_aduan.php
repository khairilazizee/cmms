<?php
session_start();
$staffrole = $_SESSION['userrole'];
$staffid = $_SESSION['staffid'];

kebenaran($_SESSION['login']);
include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];


?>

<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
	<tr>
		<td colspan="5" style="font-weight:bold;">Senarai Aduan</td>
	</tr>
	<tr>
		<th width="5">Bil</th>
        <th width="50">Tarikh</th>
        <th>Sub Sistem</th>
        <!-- <th width="250">Tugasan</th> -->
        <th width="50">Status</th>
        <th width="15">Tindakan</td>
	</tr>
	<?php

    $sql = "SELECT task_date, staff_id, id, ws_id, tg_id FROM tbl_workorder WHERE 1";
    if($staffid<>""){
        $sql .=" and staff_id='$staffid'";
    }
    if($staffrole==14){
        $sql .=" and ws_id='3' or ws_id='4'";
    }

    $sql.=" and js_id='1'";

    // $sql.="and task_date='$tarikhsemasa'";

    $sql .= " ORDER BY task_date desc";

    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    // var_dump($sqlfull);
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $idworkorder = $data['id'];
        $taskdate = fmtdate($data['task_date']);
        $taskid = $data['task_id'];
        $tugasan = GetDesc("task","task_desc","task_id",$taskid);
        $tgid = $data['tg_id'];
        $namatg = GetDesc("task_group","tg_desc","tg_id",$tgid);
        $staffid = $data['staff_id'];
        $stat = $data['ws_id'];
        $wstatus = GetDesc("work_status","ws_desc","ws_id",$stat);
        $namastaff = GetDesc("staff","staff_name","staff_id",$staffid);
        if($stat<=1){
			$kepastian = "onclick='return confirm(\"Menekan butang ini bermaksud kerja-kerja sudah bermula dan data akan direkod. Anda pasti?\")'";
		}
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$taskdate</td>";
        echo "<td>$namatg</td>";
        // echo "<td>$tugasan</td>";
        echo "<td>$wstatus</td>";
        if($staffrole==13 or $staffrole==15){
            echo "<td align=\"center\"><a href=\"mainpage.php?module=Technician&task=view_aduan&aduan=$idworkorder&sis=$stat\" $kepastian><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Technician&task=list_aduan&delete=1&iddelete=$idworkorder\" onClick=\"return confirm('Hapus Data?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        }
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Technician&task=list_aduan", $limit, $rowstart, $numrows);
    ?>
</div>