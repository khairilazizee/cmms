<?php

kebenaran($_SESSION['login']);
$pengurusanid = (int) mysql_real_escape_string($_GET['puid']);
$_SESSION['puid'] = $pengurusanid;
$namapengurusanutama = GetDesc("tbl_pengurusan_utama","pu_desc","pu_id",$pengurusanid);
$kosbulanan = GetDesc("tbl_kos_bulanan_apd","kpa_kos","pu_id",$pengurusanid);

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_kerja_pengurusan_apd&puid=<?php echo $pengurusanid;?>">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
	<tr>
		<td colspan="12" style="font-weight:bold;" class="formheader">Senarai Kerja Pengurusan &raquo; <?php echo $namapengurusanutama;?></td>
	</tr>
	<tr>
		<th>Bil</th>
		<th>Keterangan</th>
		<th>Weightage</th>
		<th>Total Paramenter</th>
		<th>Indicator Value</th>
		<th>Ringgit Equivalent</th>
		<th>Demerit Points</th>
		<th>Deduction Value (RM)</th>
		<th colspan="3">Tindakan</th>
	</tr>
	<tr>
		<td colspan="12">Monthly Fee&nbsp;:&nbsp; RM <?php echo $kosbulanan;?></td>
	</tr>
	<?php
		$sql = "SELECT pa_id,pa_desc, pa_weightage  FROM tbl_pengurusan_apd WHERE pu_id='$pengurusanid' ORDER BY pu_id";
		$sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
		$res = mysql_query($sql,$dbi);
		$resfull = mysql_query($sqlfull,$dbi);
		$cnt=$rowstart;
		while($datapt = mysql_fetch_array($resfull)){
			$paid = $datapt['pa_id'];
			$padesc = $datapt['pa_desc'];
			$paweightage = $datapt['pa_weightage'];
			$cnt++;

			echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
			echo "<td align='center'>$cnt</td>";
			echo "<td>$padesc</td>";
			echo "<td align='center'>$paweightage</td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td></td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=list_kerja_pengurusan_sub_apd&puid=$pengurusanid&paid=$paid'><img src=\"images/admin/btn_add.gif\"></a></td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=setup_kerja_pengurusan_parent&paid=$paid&dir=$cnt'><img src=\"images/admin/btn_edit.gif\"/></a></td>";
			echo "<td align='center'><a href=\"mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&delete=1&iddelete=$paid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
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