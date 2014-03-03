<?php

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_workorder">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
	<tr>
		<td style="font-weight:bold;" colspan="5">Senarai Arahan Kerja</td>
	</tr>
	<tr>
		<th width="5">Bil</th>
		<th>Tarikh</th>
		<th>Tugasan</th>
		<th width="30">Juruteknik Bertugas</th>
		<th width="15">Tindakan</td>
	</tr>
	<?php

	$sql = "SELECT task_date, task_id, staff_id FROM workorder WHERE id";
	$sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $taskdate = fmtdate($data['task_date']);
        $taskid = $data['task_id'];
        $tugasan = GetDesc("task","task_desc","task_id",$taskid);
        $staffid = $data['staff_id'];
        $namastaff = GetDesc("user","nama","id",$staffid);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$taskdate</td>";
        echo "<td>$tugasan</td>";
        echo "<td>$namastaff</td>";
        echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_sysgroup&sysid=$tid\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_sysgroup&delete=1&iddelete=$tid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        echo "</tr>";
    }
    
    ?>
</table>
