<?php

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;
$userrole = $_SESSION['userrole'];

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

$tarikhsemasa = date("Y-m-d");
$subsistem = mysql_real_escape_string($_GET['sub']);
$idworkorder = mysql_real_escape_string($_GET['sis']);

?>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6">Senarai tugasan pada <?php echo fmtdate($tarikhsemasa);?></td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <th width="50">Tarikh</th>
        <th>Tugasan</th>
        <!-- <th width="250">Tugasan</th> -->
        <!-- <th width="50">Status</th> -->
        <th width="15">Status</td>
        <th>Catatan</th>
    </tr>
    <?php
        $sqltask = "SELECT task_id, task_desc WHERE tg_id='$subsistem'";
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
            echo "<td>$taskdate</td>";
            echo "<td>$taskdesc</td>";
            echo "<td>Status</td>";
            echo "<td>Catatan</td>";
            echo "</tr>";
        }
    ?>
</table>