<?php

kebenaran($_SESSION['login']);
include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

?>

<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_kerja_pengurusan">Tambah<img src="images/admin/btn_add.gif"></a></div><br>
<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
	<tr>
		<td colspan="5" style="font-weight:bold;" class="formheader">Senarai Pengurusan</td>
	</tr>
	<tr>
		<th>Bil</th>
		<th>Keterangan</th>
		<th colspan="3">Tindakan</th>
	</tr>
	<?php
		$sql = "SELECT pu_id,pu_desc, pu_type FROM tbl_pengurusan_utama ORDER BY pu_id";
		$sqlfull = $sql." LIMIT ".$rowstart.", ".$limit;
		$res = mysql_query($sql,$dbi);
		$resfull = mysql_query($sqlfull,$dbi);
		$cnt=$rowstart;
		while($datapu = mysql_fetch_array($resfull)){
			$puid = $datapu['pu_id'];
			$pudesc = $datapu['pu_desc'];
			$putype = $datapu['pu_type'];
			$cnt++;

			echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
			echo "<td align='center'>$cnt</td>";
			echo "<td>$pudesc</td>";
			if($putype<>5){
				echo "<td align='center'><a href='mainpage.php?module=Setup&task=list_kerja_pengurusan_parent&puid=$puid'><img src=\"images/admin/btn_add.gif\"></a></td>";
			} else {
				echo "<td align='center'><a href='mainpage.php?module=Setup&task=list_kerja_pengurusan_apd&puid=$puid'><img src=\"images/admin/btn_add.gif\"></a></td>";
			}
			echo "<td align='center'><a href='mainpage.php?module=Setup&task=setup_kerja_pengurusan&puid=$puid&dir=$cnt'><img src=\"images/admin/btn_edit.gif\"/></a></td>";
			echo "<td align='center'><a href=\"mainpage.php?module=Setup&task=list_kerja_pengurusan&delete=1&iddelete=$puid\" onClick=\"return confirm('Do you wish to proceed?');\"><img src=\"images/admin/btn_delete.gif\"/></a></td>";
			echo "</tr>";
		}
	?>
</table>
<div style="text-align:center;">
    <?php
    print $Mfunction->page("?module=Setup&task=list_kerja_pengurusan", $limit, $rowstart, $numrows);
    ?>
</div>