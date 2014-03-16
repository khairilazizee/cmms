<?php

$userrole = $_SESSION['userrole'];
$staffid = $_SESSION['staffid'];

$subsistem = mysql_real_escape_string($_GET['sub']);
$idworkorder = mysql_real_escape_string($_GET['sis']);

$subsistem_desc = GetDesc("task_group","tg_desc","tg_id",$subsistem);

?>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6">
            <div style="float: left";><!-- B&nbsp;:&nbsp; -->Langkah Keselamatan</div>
        </td>
        <tr>
            <td>1</td>
            <td>:</td>
            <td>Memastikan keselamatan semua pekerja dengan mengikuti peraturan-peraturan keselamatan yang telah ditetapkan.</td>
        </tr>
        <tr>
            <td>2</td>
            <td>:</td>
            <td>Sebarang aktiviti perlu mendapat kebenaran pihak berwajib.</td>
        </tr>
        <tr>
            <td>3</td>
            <td>:</td>
            <td>Papan tanda keselamatan perlu dipaparkan semasa sebarang aktiviti baikpulih dijalankan.</td>
        </tr>
    </tr>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6">
            <div style="float: left";><!-- C&nbsp;:&nbsp; -->Senarai tugasan</div>
        </td>
    </tr>
    <tr>
        <th width="5" rowspan="2">Bil</th>
        <!-- <th width="50">Tarikh</th> -->
        <th rowspan="2">Tugasan</th>
        <!-- <th width="250">Tugasan</th> -->
        <th width="50" rowspan="2">Selesai (X)</th>
        <th width="15" colspan="2">Status</td>
        <th rowspan="2">Catatan</th>
    </tr>
    <tr>
        <th>(P)</th>
        <th>(F)</th>
    </tr>
    <tr>
        <td></td>
        <td style="font-weight:bold;"><?php echo $subsistem_desc;?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php
        $sqltask = "SELECT task_id, task_desc FROM task WHERE tg_id='$subsistem'";
        // echo $sqltask;
        // $sqlfull = $sqltask." LIMIT ".$rowstart.", ".$limit;
        $res = sql_query($sqltask,$dbi);
        // $resfull = sql_query($sqlfull,$dbi);
        $cnt=0;
        // $numrows = mysql_num_rows($res);
        while($datatask = mysql_fetch_array($res)){
            $cnt++;
            $taskid = $datatask['task_id'];
            $taskdesc = $datatask['task_desc'];
            // $taskdate = GetDesc("tbl_workorder","task_date","id",$idworkorder);

            echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
            echo "<td>$cnt</td>";
            // echo "<td>".fmtdate($taskdate)."</td>";
            echo "<td>$taskdesc</td>";
            echo "<td align='center'></td>";
            echo "<td>";
            
            echo "</td>";
            echo "<td>
                
            </td>";
            echo "<td></td>";
            echo "</tr>";
        }
    ?>
    <tr>
        <td colspan="6">
            <div style="font-weight:bold;">Catatan Keseluruhan&nbsp;:&nbsp;</div>
            <textarea name="txtCatatanKeseluruhan" rows="10" cols="120"></textarea>
        </td>
    </tr>
</table>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="6"><!-- D&nbsp;:&nbsp; -->Laporan Pemeriksaan</td>
    </tr>
    <tr>
        <td width="5"><input type="checkbox" name="inspection_status" value="1"></td>
        <td>BAGUS</td>
        <td width="5"><input type="checkbox" name="inspection_status" value="2"></td>
        <td>MEMERLUKAN PEMBETULAN</td>
        <td width="5"><input type="checkbox" name="inspection_status" value="3"></td>
        <td>MEMERLUKAN PERTUKARAN</td>
    </tr>
    <tr>
        <td class="title" colspan="6">
            <div style="font-weight:bold;">Kerja yang perlu dilalukan / Komponen yang perlu ditukar&nbsp;:&nbsp;</div>
            <textarea name="txtCatatanPemeriksaan" rows="10" cols="120"></textarea>
        </td>
    </tr>
</table>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="4"><!-- E&nbsp;:&nbsp; -->Laporan Pembetulan</td>
    </tr>
    <tr>
        <td width="5"><input type="checkbox" name="rectification_status" value="1"></td>
        <td>YA</td>
        <td width="5"><input type="checkbox" name="rectification_status" value="2"></td>
        <td>TIDAK</td>
    </tr>
</table>
<table class="table" align="center" width="100%" cellspacing="3" cellpadding="0">
    <tr>
        <td style="font-weight:bold;" colspan="4">Perkhidmatan</td>
    </tr>
    <tr>
        <td colspan="4">Semua perkhidmatan telah dilakukan mengikut cara yang telah disyorkan oleh pengeluar peralatan.</td>
    </tr>
    <tr>
        <td width="5"><input type="checkbox" name="follow_order" value="1"></td>
        <td>YA</td>
        <td width="5"><input type="checkbox" name="follow_order" value="2"></td>
        <td>TIDAK</td>
    </tr>
    <tr>
        <td colspan="2">
            Diperiksa oleh<br /><br /><br />
            __________________________<br /><br />
            Nama : <br /><br />
            Tarikh :
        </td>
        <td colspan="2">
            Disahkan oleh<br /><br /><br />
            __________________________<br /><br />
            Nama : <br /><br />
            Tarikh :
        </td>
    </tr>
</table>