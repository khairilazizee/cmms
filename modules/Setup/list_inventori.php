<?php
include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

kebenaran($_SESSION['login']);

if($_POST['submit']){
    $code = $_POST['txtSearchCode'];
    $desc = mysql_real_escape_string($_POST['txtSearchDescription']);
}

if($_GET['delete']=="1"){
    $iddelete = $_GET['iddelete'];
    
    $delete = "DELETE FROM tbl_inventori WHERE id='$iddelete'";
    sql_query($delete,$dbi);
    
    pageredirect("mainpage.php?module=Setup&task=list_inventori");
}

?>
<!-- <div style="float:left;">
    <table>
        <form name="frmcariansistem">
        <tr>
            <td>Jenis Inventori</td>
            <td>:</td>
            <td>
                <input type="hidden" name="CarianSistem" id="CarianSistem" value="<?php echo $kumpsistem; ?>" />
                <select name="txtSystemGroup" id="txtSystemGroup" onchange="return carisistem();">
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
</div> -->
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_inventori">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
    <tr>
        <td style="font-weight:bold;" class="formheader" colspan="5">Senarai Inventori</td>
    </tr>
    <tr>
        <th width="5">Bil</th>
        <th>Jenis Barangan</th>
        <th width="100">Jumlah</th>
        <th width="80">Tindakan</th>
    </tr>
    <?php
        $sqlbarangan = "SELECT id, nama_barangan, jum_barangan FROM tbl_inventori ";
        $sqlbaranganfull = $sqlbarangan." LIMIT $rowstart, $limit";
        $resbarangan = mysql_query($sqlbarangan,$dbi);
        $resbaranganfull = mysql_query($sqlbaranganfull,$dbi);
        $cnt = $rowstart;
        while($data = mysql_fetch_array($resbaranganfull)){
            $cnt++;
            $namaitem = $data['nama_barangan'];
            $jumlah = $data['jum_barangan'];
            $idinv = $data['id'];

            echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
            echo "<td>$cnt</td>";
            echo "<td>$namaitem</td>";
            echo "<td>$jumlah</td>";
            echo "<td align=\"center\">
                <a href=\"mainpage.php?module=Setup&task=setup_inventori&inv=$idinv\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_inventori&delete=1&iddelete=$idinv\" onClick=\"return confirm('Hapus Data?');\"><img src=\"images/admin/btn_delete.gif\"/></a>
            </td>";
            echo "</tr>";
        }
    ?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_inventori", $limit, $rowstart, $numrows);
    ?>
</div>