<script type="text/javascript">
    function cari(){
        var carian=document.frmcarian.txtSystemGroup.value;
        location.href="mainpage.php?module=Setup&task=list_task&kumpcarian="+carian;
    }
</script>
<?php

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;
$userrole = $_SESSION['userrole'];

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
    
    $delete = "DELETE FROM task WHERE task_id='$iddelete'";
    sql_query($delete,$dbi);
    
    pageredirect("mainpage.php?module=Setup&task=list_task");
}

$kumpsistem=$_GET["kumpcarian"];

?>
<div style="float:left;">
    <table>
        <form name="frmcarian">
        <tr>
            <td>Sub Sistem</td>
            <td>:</td>
            <td>
                <select name="txtSystemGroup" id="txtSystemGroup" onchange="return cari();">
                    <option value="">- SEMUA -</option>
                    <?php
                        $sql = "SELECT tg_id, tg_desc FROM task_group ORDER BY tg_id";
                        $res = mysql_query($sql,$dbi);
                        while($sgdata = mysql_fetch_array($res)){
                            $sgid = $sgdata['tg_id'];
                            $sgdesc = $sgdata['tg_desc'];

                            echo "<option value='$sgid' "; 
                            if($sgid==$kumpsistem)
                                echo "selected "; 
                            echo ">$sgdesc</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        </form>
    </table>
</div>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_task">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="3" align="center" class="table">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="4">Senarai Tugasan</td>
    </tr>
    <tr>
        <th class="formheader" width="30" align="center">No</th>
        <th class="formheader">Tugasan</th>
        <th class="formheader" width="100">Sub Sistem</th>
        <th class="formheader" width="100" align="center">Tindakan</th>
    </tr>
    <?php
    
    $sql = "SELECT task_id, task_desc, tg_id from task WHERE 1 ";
    // die($sql);
    if ($kumpsistem<>"") {
        $sql.="and tg_id='$kumpsistem' ";
    }
    $sql.="ORDER BY task_id";
    // echo $sql;
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $tid = $data['task_id'];
        $tdesc = $data['task_desc'];
        // $tsgid = $data['task_sg_id'];
        $tgid = $data['tg_id'];
        $namatg = GetDesc("task_group","tg_desc","tg_id",$tgid);
        $cnt++;
        // echo "masuk";
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$tdesc</td>";
        echo "<td>$namatg</td>";
        if($userrole==13 or $userrole==15){
            echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_task&taskid=$tid\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_task&delete=1&iddelete=$tid\" onClick=\"return confirm('Adakah anda pasti?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        }
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_task", $limit, $rowstart, $numrows);
    ?>
</div>
