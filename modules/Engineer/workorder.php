<?php

$staffid = $_SESSION['staffid'];
$staffagid = $_SESSION['staffagid'];

$cMonth = $_REQUEST["month"];
$cYear = $_REQUEST["year"];
$cDay = $_REQUEST['day'];
if($cMonth==""){
	$cMonth = date("m");
}

if($cYear==""){
	$cYear = date("Y");
}

if($cDay==""){
	$cDay = date("d");
}

$tarikhsemasa = sprintf("%02d",$cDay)." / ".sprintf("%02d",$cMonth)." / ".$cYear;
$currentdate = $cYear."-".sprintf("%02d",$cMonth)."-".sprintf("%02d",$cDay);
 
$prev_year = $cYear;
$next_year = $cYear;
$prev_month = $cMonth-1;
$next_month = $cMonth+1;
 
if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $cYear - 1;
}
if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $cYear + 1;
}


?>
<table width="100%">
<tr >
	<td align="center">
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
			<tr>
				<td bgcolor="#999999" style="color:#FFFFFF" width="10%" align="center">  <a href="<?php echo "mainpage.php?module=Setup&task=workorder&" . "month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF"><img src="images/left-arrow.gif"></a>
				</td>
				<td width="80%" align="center" bgcolor="#999999" style="color:#FFFFFF"><strong><?php echo namabulan($cMonth).' '.$cYear; ?></td>
				<td bgcolor="#999999" style="color:#FFFFFF" width="10%" align="center"><a href="<?php echo "mainpage.php?module=Setup&task=workorder&" . "month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF"><img src="images/right-arrow.gif"></a>  
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center">
		<table width="100%" border="0" cellpadding="2" cellspacing="2">
			<!-- <tr align="center">
				<td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong><?php echo namabulan($cMonth).' '.$cYear; ?></strong></td>
			</tr> -->
			<tr>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
			<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
			</tr>
			<?php 
			$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
			$maxday = date("t",$timestamp);
			$thismonth = getdate ($timestamp);
			$startday = $thismonth['wday'];
			for ($i=0; $i<($maxday+$startday); $i++) {
				$hari = $i - $startday + 1;
			    if(($i % 7) == 0 ) 
			    	echo "<tr>\n";
			    if($i < $startday) 
			    	echo "<td style='border:1px solid #ccc;'>&nbsp;</td>\n";
			    else 
			    	echo "<td align='center' style='border:1px solid #ccc;' valign='middle' height='20px'><a href='mainpage.php?module=Setup&task=workorder&day=$hari&month=$cMonth&year=$cYear'>". ($i - $startday + 1) . "</a></td>\n";
			    if(($i % 7) == 6 ) 
			    	echo "</tr>\n";
			}
			?>
		</table>
	</td>
</tr>
</table>

<table class="table" width="100%">
	<tr>
		<td class="formheader" colspan="6" style="font-weight:bold;text-align:center;text-transform:uppercase;background:#fff;color:#000;">Senarai Tugasan pada <?php echo $tarikhsemasa;?></td>
	</tr>
	<tr>
		<th width="5">Bil</th>
		<th width="300">Tugasan</th>
		<th>Juruteknik</th>
		<th width="100">Kump. Asset</th>
		<!-- <th width="100">Asset</th> -->
		<!-- <th width="100">Tindakan</th> -->
		<th width="100">Status</th>
	</tr>
	<?php
		$bil = 0;
		$sqltugasan = "SELECT staff_id, ag_id, asset_id, ws_id, task_desc FROM tbl_workorder , task WHERE task.tg_id=tbl_workorder.tg_id and tbl_workorder.task_date='$currentdate'";
		if($staffagid<>0){
			$sqltugasan.=" and tbl_workorder.ag_id='$staffagid'";
		}
		// echo $sqltugasan;
		$restugasan = mysql_query($sqltugasan,$dbi);
		while($data = mysql_fetch_array($restugasan)){
			$namatugasan = $data['task_desc'];
			$staff_id = $data['staff_id'];
			$wsid = $data['ws_id'];
			$wstatus = GetDesc("work_status","ws_desc","ws_id",$wsid);
			$namastaff = GetDesc("staff","staff_name","staff_id",$staff_id);
			$agid = $data['ag_id'];
			$namaassetgroup = GetDesc("asset_group","ag_desc","ag_id",$agid);
			$asset = $data['asset_id'];
			$namaasset = GetDesc("asset","asset_desc","asset_id",$asset);
			$bil++;

			echo "<tr>";
			echo "<td>$bil</td>";
			echo "<td>$namatugasan</td>";
			echo "<td>$namastaff</td>";
			echo "<td>$namaassetgroup</td>";
			// echo "<td>$namaasset</td>";
			echo "<td>$wstatus</td>";
			// echo "<td align='center'><img src='images/admin/btn_papar.gif'/></td>";
			echo "</tr>";
		}
	?>
</table>