<?php

kebenaran($_SESSION['login']);
$pengurusanid = (int) mysql_real_escape_string($_GET['puid']);
$_SESSION['puid'] = $pengurusanid;
$namapengurusanutama = GetDesc("tbl_pengurusan_utama","pu_desc","pu_id",$pengurusanid);

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_kerja_pengurusan_parent&puid=<?php echo $pengurusanid;?>">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
	<tr>
		<td colspan="6" style="font-weight:bold;" class="formheader">Senarai Kerja Pengurusan &raquo; <?php echo $namapengurusanutama;?></td>
	</tr>
	<tr>
		<th>Bil</th>
		<th>Keterangan</th>
		<th>Amaun Kontrak</th>
		<th colspan="3">Tindakan</th>
	</tr>
	<?php
		$sql = "SELECT pt_id,pt_desc, pt_price FROM tbl_pengurusan_tajuk WHERE pu_id='$pengurusanid' ORDER BY pu_id";
		$sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
		$res = mysql_query($sql,$dbi);
		$resfull = mysql_query($sqlfull,$dbi);
		$cnt=$rowstart;
		while($datapt = mysql_fetch_array($resfull)){
			$ptid = $datapt['pt_id'];
			$ptdesc = $datapt['pt_desc'];
			$ptprice = $datapt['pt_price'];
			$ptprice==0 ? $ptprice = "" : @$ptprice;
			$cnt++;

			echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
			echo "<td align='center'>$cnt</td>";
			echo "<td>$ptdesc</td>";
			echo "<td align='center'>$ptprice</td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=list_kerja_pengurusan_sub&puid=$pengurusanid&ptid=$ptid'><img src=\"images/admin/btn_add.gif\"></a></td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=setup_kerja_pengurusan_parent&ptid=$ptid&dir=$cnt'><img src=\"images/admin/btn_edit.gif\"/></a></td>";
			echo "<td align='center'><a href=\"mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&delete=1&iddelete=$ptid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
			echo "</tr>";
		}
	?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_kerja_pengurusan", $limit, $rowstart, $numrows);
    ?>
</div>
<br>
<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan'" class="button"/>