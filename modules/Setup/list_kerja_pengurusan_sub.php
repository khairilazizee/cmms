<?php

$pengurusanid = $_SESSION['puid'];
$namapengurusanutama = GetDesc("tbl_pengurusan_utama","pu_desc","pu_id",$pengurusanid);
$titleid = (int) mysql_real_escape_string($_GET['ptid']);
$_SESSION['ptid'] = $titleid;
$namapengurusantajuk = GetDesc("tbl_pengurusan_tajuk","pt_desc","pt_id",$titleid);

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];



?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_kerja_pengurusan_sub&puid=<?php echo $pengurusanid;?>&ptid=<?php echo $titleid;?>">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
	<tr>
		<td colspan="6" style="font-weight:bold;" class="formheader">Senarai Kerja Pengurusan &raquo; <?php echo $namapengurusanutama;?> &raquo; <?php echo $namapengurusantajuk;?></td>
	</tr>
	<tr>
		<th>Bil</th>
		<th>Keterangan</th>
		<th>Amaun Kontrak</th>
		<th colspan="3">Tindakan</th>
	</tr>
	<?php
		$sql = "SELECT ps_id,ps_desc, pt_id,ps_price FROM tbl_pengurusan_sub WHERE pt_id='$titleid' ORDER BY ps_id";
		$sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
		$res = mysql_query($sql,$dbi);
		$resfull = mysql_query($sqlfull,$dbi);
		$cnt=$rowstart;
		while($datapt = mysql_fetch_array($resfull)){
			$psid = $datapt['ps_id'];
			$psdesc = $datapt['ps_desc'];
			$psprice = $datapt['ps_price'];
			$psprice==0 ? $psprice = "" : @$psprice;
			$cnt++;

			echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
			echo "<td align='center'>$cnt</td>";
			echo "<td>$psdesc</td>";
			echo "<td align='center'>$psprice</td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=list_kerja_pengurusan_subitem&ptid=$titleid&psid=$psid'><img src=\"images/admin/btn_add.gif\"></a></td>";
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=setup_kerja_pengurusan_sub&psid=$psid&dir=$cnt'><img src=\"images/admin/btn_edit.gif\"/></a></td>";
			echo "<td align='center'><a href=\"mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&delete=1&iddelete=$psid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
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
<input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&puid=<?php echo $pengurusanid;?>'" class="button"/>
<input type="button" name="back" value="Utama" onclick="location.href='mainpage.php?module=Setup&task=list_kerja_pengurusan'" class="button"/>