<?php

kebenaran($_SESSION['login']);
$pengurusanid = (int) mysql_real_escape_string($_GET['puid']);
$_SESSION['puid'] = $pengurusanid;
$namapengurusanutama = GetDesc("tbl_pengurusan_utama","pu_desc","pu_id",$pengurusanid);
$paid = (int) mysql_real_escape_string($_GET['paid']);
$_SESSION['paid'] = $paid;

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_kerja_pengurusan_sub_apd&puid=<?php echo $pengurusanid;?>&paid=<?php echo $paid;?>">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
	<tr>
		<td colspan="6" style="font-weight:bold;" class="formheader">Senarai Kerja Pengurusan &raquo; <?php echo $namapengurusanutama;?> &raquo; Sub</td>
	</tr>
	<tr>
		<th>Bil</th>
		<th>Keterangan</th>
		<th>Parameter</th>
		<th colspan="2">Tindakan</th>
	</tr>
	<?php
		$sql = "SELECT pas_id,pas_desc, pas_para  FROM tbl_pengurusan_apd_sub WHERE pa_id='$paid' ORDER BY pas_id";
		$sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
		$res = mysql_query($sql,$dbi);
		$resfull = mysql_query($sqlfull,$dbi);
		$cnt=$rowstart;
		while($datapt = mysql_fetch_array($resfull)){
			$pasid = $datapt['pas_id'];
			$pasdesc = $datapt['pas_desc'];
			$paspara = $datapt['pas_para'];
			$cnt++;

			echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
			echo "<td align='center'>$cnt</td>";
			echo "<td>$pasdesc</td>";
			echo "<td align='center'>$paspara</td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=setup_kerja_pengurusan_sub_apd&pasid=$pasid&dir=$cnt'><img src=\"images/admin/btn_edit.gif\"/></a></td>";
			echo "<td align='center'><a href=\"mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&delete=1&iddelete=$pasid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
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