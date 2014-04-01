<script type="text/javascript">
    // function carisistem(){
    //     var carian=document.frmcariansistem.txtSystemGroup.value;
    //     var cariaset=document.frmcarianaset.CarianAset.value;

    //     if(cariaset=="")
    //         location.href="mainpage.php?module=Setup&task=list_asset&kumpcariansistem="+carian;
    //     else
    //         location.href="mainpage.php?module=Setup&task=list_asset&kumpcariansistem="+carian+"&kumpcarianaset="+cariaset;
    // }

    function cariaset(){
        var carianaset=document.frmcarianaset.txtAsetGroup.value;
        // var carisistem=document.frmcariansistem.CarianSistem.value;

        // if(carisistem=="")
        location.href="mainpage.php?module=Setup&task=list_zon&kumpcarianaset="+carianaset;
        // else
        //     location.hre f="mainpage.php?module=Setup&task=list_asset&kumpcarianaset="+carianaset+"&kumpcariansistem="+carisistem;
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

$staffagid = $_SESSION['staffagid'];

if($_GET['delete']=="1"){
    $iddelete = $_GET['iddelete'];
    
    $delete = "DELETE FROM zone WHERE zon_id='$iddelete'";
    sql_query($delete,$dbi);
    
    pageredirect("mainpage.php?module=Setup&task=list_zon");
}

$kumpaset=$_GET["kumpcarianaset"];
?>
<?php if($staffagid==0){ ?>
<div style="float:left;">
    <table>
        <form name="frmcarianaset">
        <tr>
            <td>Kump. Aset</td>
            <td>:</td>
            <td>
                <input type="hidden" name="CarianAset" id="CarianAset" value="<?php echo $kumpaset; ?>" />
                <select name="txtAsetGroup" id="txtAsetGroup" onchange="return cariaset();">
                    <option value="">- SEMUA -</option>
                    <?php
                        $sql = "SELECT ag_id, ag_desc FROM asset_group ORDER BY ag_id";
                        $res = mysql_query($sql,$dbi);
                        while($sgdata = mysql_fetch_array($res)){
                            $sgid = $sgdata['ag_id'];
                            $sgdesc = $sgdata['ag_desc'];

                            echo "<option value='$sgid' "; 
                            if($sgid==$kumpaset)
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
<?php } ?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_zon">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="3" align="center" class="table">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="4">Senarai Zon</td>
    </tr>
    <tr>
        <th class="formheader" width="30" align="center">No</th>
        <th class="formheader">Zon</th>
        <th class="formheader" width="100">Kump. Aset</th>
        <th class="formheader" width="100" align="center">Tindakan</th>
    </tr>
    <?php
    
    $sql = "SELECT zon_id, zon_desc, ag_id from zone where 1 ";
    if ($staffagid<>0)
        $sql.="and ag_id='$staffagid' ";
    if ($kumpaset<>"")
        $sql.="and ag_id='$kumpaset' ";
    $sql.="ORDER BY zon_id";
    $sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
    $res = sql_query($sql,$dbi);
    $resfull = sql_query($sqlfull,$dbi);
    $cnt=$rowstart;
    $numrows = mysql_num_rows($res);
    while($data = mysql_fetch_array($resfull)){
        $tid = $data['zon_id'];
        $tdesc = $data['zon_desc'];
        $tagid = $data['ag_id'];
        $cnt++;

        $namaag=GetDesc("asset_group","ag_desc","ag_id",$tagid);
        
        echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
        echo "<td align=\"center\">$cnt</td>";
        echo "<td>$tdesc</td>";
        echo "<td>$namaag</td>";
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
