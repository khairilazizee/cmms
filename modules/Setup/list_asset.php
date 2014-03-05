<script type="text/javascript">
    function cari(){
        var carian=document.frmcarian.txtSystemGroup.value;
        location.href="mainpage.php?module=Setup&task=list_asset&kumpcarian="+carian;
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
    
    $delete = "DELETE FROM asset WHERE asset_id='$iddelete'";
    sql_query($delete,$dbi);
    
    pageredirect("mainpage.php?module=Setup&task=list_asset");
}

    $kumpsistem=$_GET["kumpcarian"];

?>
<div style="float:left;">
    <table>
        <form name="frmcarian">
        <tr>
            <td>Kump. Aset</td>
            <td>:</td>
            <td>
                <select name="txtSystemGroup" id="txtSystemGroup" onchange="return cari();">
                    <option value="">- SEMUA -</option>
                    <?php
                        $sql = "SELECT ag_id, ag_desc FROM asset_group ORDER BY ag_id";
                        $res = mysql_query($sql,$dbi);
                        while($sgdata = mysql_fetch_array($res)){
                            $sgid = $sgdata['ag_id'];
                            $sgdesc = $sgdata['ag_desc'];

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
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_assets">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="4">Senarai Aset</td>
    </tr>
    <tr>
        <th class="formheader" width="30" align="center">No</th>
        <th class="formheader">Aset</th>
        <th class="formheader" width="100">Kumpulan</th>
        <th class="formheader" width="100" align="center">Tindakan</th>
    </tr>
    <?php
    
    $sql = "SELECT asset_id, asset_desc, asset_ag_id from asset WHERE 1 ";
    if ($kumpsistem<>"")
        $sql.="and asset_ag_id='$kumpsistem' ";
    $sql.="ORDER BY asset_id";
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $aid = $data['asset_id'];
        $adesc = $data['asset_desc'];
        $agid = $data['asset_ag_id'];
        $namaag = GetDesc("asset_group","ag_desc","ag_id",$agid);
        $cnt++;
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$adesc</td>";
        echo "<td>$namaag</td>";
        echo "<td align=\"center\"><a href=\"mainpage.php?module=Setup&task=setup_assets&assetid=$aid\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_asset&delete=1&iddelete=$aid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
        echo "</tr>";
    }
    
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_asset", $limit, $rowstart, $numrows);
    ?>
</div>
