<?php

include('include/function_pengurusan.php');

?>
<table class="table" width="100%" cellspacing="3" cellpadding="1">
	<tr>
		<th width="10">Item</th>
		<th>Description</th>
		<th>Contract Sum</th>
	</tr>
	<tr>
		<td></td>
		<td style="font-weight:bold;">RUMUSAN</td>
		<td></td>
	</tr>
	<?php
		$bil=0;
		$sqlrumusan = "SELECT pu_id, pu_desc FROM tbl_pengurusan_utama WHERE 1 ORDER BY pu_id";
		$resrumusan = mysql_query($sqlrumusan,$dbi);
		while($datarumusan = mysql_fetch_array($resrumusan)){
			$bil++;
			$pudesc = $datarumusan['pu_desc'];
			$puid = $datarumusan['pu_id'];
			$tajuk = "SELECT pt_desc, pt_id FROM tbl_pengurusan_tajuk WHERE pu_id='$puid'";
			$restajuk = mysql_query($tajuk,$dbi);
			switch($bil) {
				case "1" : 
					$no = "A";
					break;
				case "2" :
					$no = "B";
					break;
				case "3" :
					$no = "C";
					break;
				case "4" :
					$no = "D";
					break;
				default :
					$no = "";
			}

			echo "<tr>";
			echo "<td align='center'>$no</td>";
			if($puid<>3){
				echo "<td>$pudesc</td>";
				echo "<td>".kira_jumlah_kontrak($puid)."</td>";
			} else {
				echo "<td>$pudesc
				<ul>";
					while($datatajuk = mysql_fetch_array($restajuk)){
						$ptdesc = $datatajuk['pt_desc'];
						$ptid = $datatajuk['pt_id'];

						echo "<li>$ptdesc</li>";
					}
				echo "</ul>
				</td>";
				echo "<td>";
				echo "<ul>";
				while($datatajuk2 = mysql_fetch_array($restajuk)){
					$ptdesc2 = $datatajuk2['pt_desc'];
					$ptid2 = $datatajuk2['pt_id'];

					echo "<li>".kira_jumlah_kontrak($puid,$ptid2)."</li>";

				}
				echo "</ul>";
				echo "</td>";
			}
			echo "</tr>";
		}
	?>
	<tr>
		<td colspan="2"></td>
		<td><?php echo kira_jumlah_semua();?></td>
	</tr>
</table>