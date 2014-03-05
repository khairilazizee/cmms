<script type="text/javascript">
    function cari(){
        var carian=document.frmcarian.txtSystemGroup.value;
        location.href="mainpage.php?module=Setup&task=list_system&kumpcarian="+carian;
    }
</script>
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
    
    $delete = "DELETE FROM system WHERE sys_id='$iddelete'";
    sql_query($delete,$dbi);
    
    pageredirect("mainpage.php?module=Setup&task=list_system");
}

$kumpsistem=$_GET["kumpcarian"];

?>
<div style="float:left;">
    <table>
        <form name="frmcarian">
        <tr>
            <td>Kump. Sistem</td>
            <td>:</td>
            <td>
                <select name="txtSystemGroup" id="txtSystemGroup" onchange="return cari();">
                    <option value="">- SEMUA -</option>
                    <?php
                        $sql = "SELECT sg_id, sg_desc FROM system_group ORDER BY sg_id";
                        $res = mysql_query($sql,$dbi);
                        while($sgdata = mysql_fetch_array($res)){
                            $sgid = $sgdata['sg_id'];
                            $sgdesc = $sgdata['sg_desc'];

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
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_system">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="4">Senarai Sistem</td>
    </tr>
    <tr>
        <th class="formheader" width="30" align="center">No</th>
        <th class="formheader">Sistem</th>
        <th class="formheader">Kumpulan</th>
        <th class="formheader" width="100" align="center">Tindakan</th>
    </tr>
    <?php
    
    $sql = "SELECT sys_id, sys_desc , sys_sg_id from system WHERE 1 ";
    if ($kumpsistem<>"")
        $sql.="and sys_sg_id='$kumpsistem' ";
    $sql.="ORDER BY sys_id";
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $tid = $data['sys_id'];
        $tdesc = $data['sys_desc'];
        $sgroup = $data['sys_sg_id'];
        $namasysgroup = GetDesc("system_group","sg_desc","sg_id",$sgroup);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$tdesc</td>";
        echo "<td>$namasysgroup</td>";
        echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_system&taskid=$tid\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_system&delete=1&iddelete=$tid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_system", $limit, $rowstart, $numrows);
    ?>
</div>
