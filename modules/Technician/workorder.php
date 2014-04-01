<?php

kebenaran($_SESSION['login']);

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
	$cDay = date("d") + 1;
}

$tarikhsemasa = sprintf("%02d",$cDay)." / ".sprintf("%02d",$cMonth)." / ".$cYear;
// echo $tarikhsemasa;
$_SESSION['tarikhsemasa'] = $tarikhsemasa;
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
				<td bgcolor="#999999" style="color:#FFFFFF" width="10%" align="center">  <a href="<?php echo "mainpage.php?module=Technician&task=workorder&" . "month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF"><img src="images/left-arrow.gif"></a>
				</td>
				<td width="80%" align="center" bgcolor="#999999" style="color:#FFFFFF"><strong><?php echo namabulan($cMonth).' '.$cYear; ?></td>
				<td bgcolor="#999999" style="color:#FFFFFF" width="10%" align="center"><a href="<?php echo "mainpage.php?module=Technician&task=workorder&" . "month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF"><img src="images/right-arrow.gif"></a>  
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
		<td class="formheader" colspan="6" style="font-weight:bold;text-align:center;text-transform:uppercase;background:#fff;color:#000;">
			<div style="float: left;">Senarai Tugasan pada <?php echo $tarikhsemasa;?></div>
			<div style="float: right;"></div>
		</td>
	</tr>
	<tr>
		<th width="5">Bil</th>
		<th>Sub sistem</th>
		<th width="100">Tindakan</th>
	</tr>
	<?php
		$bil = 0;
		$sqltugasan = "SELECT  staff_id, tg_id, id, ws_id FROM tbl_workorder WHERE task_date='$currentdate'";

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
			$status = $data['ws_id'];
			if($status==1){
				$kepastian = "onclick='return confirm(\"Menekan butang ini bermaksud kerja-kerja sudah bermula dan data akan direkod. Anda pasti?\")'";
			}
			$bil++;

			echo "<tr>";
			echo "<td>$bil</td>";
			echo "<td>$namasubsistem</td>";
			echo "<td align='center'><a href='mainpage.php?module=Technician&task=list_task&sub=$subsistem&sis=$id' $kepastian ><img src='images/admin/btn_papar.gif'/></a>
				<a href=\"mainpage.php?module=Technician&task=borang&sub=$subsistem&sis=$id&displayframework=0\" target=\"_blank\"><img src=\"images/print.gif\"></a>
			</td>";
			echo "</tr>";
		}
	?>
</table>
<br /><br />

<?php
	$sqltugasan = "SELECT  ad_id, ad_no_aduan, ad_lokasi, ad_pengadu, ad_jabatan, ad_kaedah, ad_tarikh_adu, ad_sg_id, ad_ag_id, ad_keterangan, ad_staff_id, ad_catatan, ad_status FROM tbl_aduan WHERE ad_tarikh_adu='$currentdate'";

	if($staffid<>""){
		$sqltugasan .=" and ad_staff_id='$staffid'";
	}
	$restugasan = mysql_query($sqltugasan,$dbi);

	$jumtugasan = mysql_num_rows($restugasan);
	if($jumtugasan<>0){
?>
<table class="table" width="100%">
	<tr>
		<td class="formheader" colspan="6" style="font-weight:bold;text-align:center;text-transform:uppercase;background:#fff;color:#000;">
			<div style="float: left;">Senarai Aduan pada <?php echo $tarikhsemasa;?></div>
			<div style="float: right;"></div>
		</td>
	</tr>
	<tr>
		<th width="80">No Aduan</th>
		<th width="150">Lokasi</th>
		<th>Keterangan</th>
		<th width="100">Tindakan</th>
	</tr>
	<?php
		$bil = 0;
		
		// echo $sqltugasan;
		
		while($data = mysql_fetch_array($restugasan)){
			$staff_id = $data['ad_staff_id'];
			$namastaff = GetDesc("staff","staff_name","staff_id",$staff_id);
			$agid = $data['ad_ag_id'];
			$namaassetgroup = GetDesc("asset_group","ag_desc","ag_id",$agid);
			$sgid = $data['ad_sg_id'];
			$namasysgroup = GetDesc("system_group","sg_desc","sg_id",$sgid);
			$idlokasi = $data['ad_lokasi'];
			$lokasi = GetDesc("zone","zon_desc","zon_id",$idlokasi);
			$noaduan = $data['ad_no_aduan'];
			$pengadu = $data['ad_pengadu'];
			$tarikhadu = $data['ad_tarikh_adu'];
			$keterangan = $data['ad_keterangan'];
			$id = $data['ad_id'];
			$status = $data['ad_status'];
			if($status==1){
				$kepastian = "onclick='return confirm(\"Menekan butang ini bermaksud kerja-kerja sudah bermula dan data akan direkod. Anda pasti?\")'";
			}
			$bil++;

			echo "<tr>";
			echo "<td>$noaduan</td>";
			echo "<td>$lokasi</td>";
			echo "<td>$keterangan</td>";
			echo "<td align='center'><a href='mainpage.php?module=Technician&task=list_aduan&noadu=$noaduan&sis=$id' $kepastian ><img src='images/admin/btn_papar.gif'/></a>
				<a href=\"mainpage.php?module=Technician&task=borang&noadu=$noaduan&sis=$id&displayframework=0\" target=\"_blank\"><img src=\"images/print.gif\"></a>
			</td>";
			echo "</tr>";
		}
	?>
</table>
<?php } ?>