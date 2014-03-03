<?php

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];
  

if($_POST['submit']){
    $code = $_POST['txtSearchCode'];
    $desc = mysql_real_escape_string($_POST['txtSearchDescription']);
}

if($_GET['delete']=="1"){
    $iddelete = $_GET['iddelete'];
    
    $delete = "DELETE FROM zone WHERE zon_id='$iddelete'";
    sql_query($delete,$dbi);
    
    pageredirect("mainpage.php?module=Setup&task=list_zon");
}

?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_zon">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="3" align="center" class="table">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="3">Senarai Zon</td>
    </tr>
    <tr>
        <th class="formheader" width="30" align="center">No</th>
        <th class="formheader">Zon</th>
        <th class="formheader" width="100" align="center">Tin dakan</th>
    </tr>
    <?php
    
    $sql = "SELECT zon_id, zon_desc from zone ORDER BY zon_id";
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $tid = $data['zon_id'];
        $tdesc = $data['zon_desc'];
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$tdesc</td>";
        echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_zon&zonid=$tid\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_zon&delete=1&iddelete=$tid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_zon", $limit, $rowstart, $numrows);
    ?>
</div>
