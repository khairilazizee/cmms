<?php

$staffid = $_SESSION['staffid'];

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
				<td bgcolor="#999999" style="color:#FFFFFF" width="50%" align="left">  <a href="<?php echo "mainpage.php?module=Setup&task=workorder&" . "month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a>
				</td>
				<td bgcolor="#999999" style="color:#FFFFFF" width="50%" align="right"><a href="<?php echo "mainpage.php?module=Setup&task=workorder&" . "month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a>  
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td align="center">
		<table width="100%" border="0" cellpadding="2" cellspacing="2">
			<tr align="center">
				<td colspan="7" bgcolor="#999999" style="color:#FFFFFF"><strong><?php echo namabulan($cMonth).' '.$cYear; ?></strong></td>
			</tr>
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
			    	echo "<td align='center' style='border:1px solid #ccc;' valign='middle' height='20px'><a href='mainpage.php?module=Technician&task=workorder&day=$hari&month=$cMonth&year=$cYear'>". ($i - $startday + 1) . "</a></td>\n";
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
		<th>Sub sistem</th>
		<th width="100">Tindakan</th>
	</tr>
	<?php
		$bil = 0;
		$sqltugasan = "SELECT  staff_id, tg_id FROM tbl_workorder WHERE task_date='$currentdate'";

		if($staffid<>""){
			$sqltugasan .=" and staff_id='$staffid'";
		}
		// echo $sqltugasan;
		$restugasan = mysql_query($sqltugasan,$dbi);
		while($data = mysql_fetch_array($restugasan)){
			$staff_id = $data['staff_id'];
			$namastaff = GetDesc("staff","staff_name","staff_id",$staff_id);
			$agid = $data['ag_id'];
			$namaassetgroup = GetDesc("asset_group","ag_desc","ag_id",$agid);
			$asset = $data['asset_id'];
			$namaasset = GetDesc("asset","asset_desc","asset_id",$asset);
			$subsistem = $data['tg_id'];
			$namasubsistem = GetDesc("task_group","tg_desc","tg_id",$subsistem);
			$id = $data['id'];
			$bil++;

			echo "<tr>";
			echo "<td>$bil</td>";
			echo "<td>$namasubsistem</td>";
			echo "<td align='center'><a href='mainpage.php?module=Technician&task=list_workorder&sub=$subsistem&sis=$id'><img src='images/admin/btn_papar.gif'/></a></td>";
			echo "</tr>";
		}
	?>
</table>