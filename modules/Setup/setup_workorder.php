<?php

$idworkorder = mysql_real_escape_string($_GET['sysid']);

$staffrole = $_SESSION['userrole'];
if($staffrole<>14 && $staffrole<>15)
    $info="enabled";
else
    $info="disabled";

if($_POST['submit']){
	$sysgroup = $_POST['txtSysGroup'];
	$system = $_POST['txtSystem'];
	$task = $_POST['txtTask'];
	$juruteknik = $_POST['txtJuruteknik'];
	$asgroup = $_POST['txtAssetGroup'];
	$asset = $_POST['txtAsset'];
	$kekerapan = $_POST['txtKekerapan'];
	$tarikhmula = mysql_real_escape_string(mysqldate($_POST['txtTarikhMula']));
	$status_p = $_POST['txtStatus'];
	$catatan = mysql_real_escape_string($_POST['txtCatatan']);
	$flg = $_POST['flg'];

	$hari = (strtotime("31-12-2014") - strtotime($tarikhmula)) / (60 * 60 * 24);
	$hari = $hari + 1;
	// $bahagi = $hari / $kekerapan;
	// echo round($bahagi);
	if($flg=="add"){
		if($kekerapan == 7 or $kekerapan == 14 or $kekerapan == 30){
			for ( $counter = 0; $counter <= $hari; $counter+= $kekerapan) {
				$tarikhbaru[$counter] = date("Y-m-d", strtotime("$tarikhmula +$counter days"));
				// echo $counter.$tarikhbaru[$counter]."<br />";
				$sqlworkorder = "INSERT INTO tbl_workorder (sg_id, sys_id, task_id, staff_id, task_date, ag_id, asset_id,ws_id,js_id) VALUES ('$sysgroup','$system','$task','$juruteknik','".$tarikhbaru[$counter]."','$asgroup','$asset','1','2')";
				$resworkorder = mysql_query($sqlworkorder,$dbi);
			}
		} elseif($kekerapan == 365) {
			$tarikhbaru = date("Y-m-d", strtotime("$tarikhmula +$kekerapan days"));
			$sqlworkorder = "INSERT INTO tbl_workorder (sg_id, sys_id, task_id, staff_id, task_date, ag_id, asset_id,ws_id,js_id) VALUES ('$sysgroup','$system','$task','$juruteknik','$tarikhbaru','$asgroup','$asset','1','2')";
			$resworkorder = mysql_query($sqlworkorder,$dbi);
		} else {
			$sqlworkorder = "INSERT INTO tbl_workorder (sg_id, sys_id, task_id, staff_id, task_date, ag_id, asset_id,ws_id,js_id) VALUES ('$sysgroup','$system','$task','$juruteknik','$tarikhmula','$asgroup','$asset','1','2')";
			$resworkorder = mysql_query($sqlworkorder,$dbi);
		}
	} elseif($flg == "edit"){
		$update = "UPDATE tbl_workorder SET sg_id='$sysgroup', sys_id='$system', task_id='$task', staff_id='$juruteknik', task_date='$tarikhmula', ag_id='$asgroup', asset_id='$asset', ws_id='$status_p', catatan='$catatan' WHERE id='$idworkorder'";
		mysql_query($update,$dbi);
	}

	pageredirect("mainpage.php?module=Setup&task=list_workorder");

	
}

$flg = "add";
$sql = "SELECT sg_id, sys_id, tg_id, task_id, staff_id, task_date, ag_id, asset_id, ws_id FROM tbl_workorder WHERE 1 and id='$idworkorder'";
// die("SELECT sg_id, sys_id, tg_id, task_id, staff_id, task_date, ag_id, asset_id FROM tbl_workorder WHERE 1 and id='$idworkorder'");
$res = mysql_query($sql,$dbi);
if(mysql_num_rows($res)>0){
	$data = mysql_fetch_array($res);
	$sysgroupid = $data['sg_id'];
	$systemid = $data['sys_id'];
	$taskgroupid = $data['tg_id'];
	$taskpilihid = $data['task_id'];
	$staffid = $data['staff_id'];
	$taskdate = $data['task_date'];
	$assetgroupid = $data['ag_id'];
	$assetpilihid = $data['asset_id'];
	$workstatus = $data['ws_id'];
	$flg = "edit";
}

?>
<form name="frmtask" method="POST" action="">
<table class="outerform" width="100%" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<td colspan="3" style="font-weight:bold;" class="formheader">Arahan Kerja</td>
	</tr>
	<tr>
		<td width="100" class="title">Kumpulan Sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtSysGroup" id="txtSysGroup" <?php echo $info; ?>>
				<option value="">- PILIH -</option>
				<?php
					$sql = "SELECT sg_id, sg_desc FROM system_group";
					$res = mysql_query($sql,$dbi);
					while($datasg = mysql_fetch_array($res)){
						$sgid = $datasg['sg_id'];
						$sgdesc = $datasg['sg_desc'];

						echo "<option";
						if($sysgroupid==$sgid){
							echo " SELECTED ";
						}
						echo" value='$sgid'>$sgdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Sistem</td>
		<td class="title">:</td>
		<td>
			<select name="txtSystem" id="txtSystem" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlsystem = "SELECT sys_id, sys_desc FROM system";
					$ressystem = mysql_query($sqlsystem,$dbi);
					while($datasystem = mysql_fetch_array($ressystem)){
						$sysid = $datasystem['sys_id'];
						$sysdesc = $datasystem['sys_desc'];

						echo "<option ";
						if($systemid==$sysid){
							echo " SELECTED ";
						}
						echo " value='$sysid'>$sysdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="100" class="title">Sub sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtKumpTugasan" id="txtKumpTugasan" <?php echo $info; ?>>
				<option value="">- PILIH -</option>
				<?php
					$sqltugasan = "SELECT tg_id, tg_desc FROM task_group";
					$restugasan = mysql_query($sqltugasan,$dbi);
					while($datatg = mysql_fetch_array($restugasan)){
						$tgid = $datatg['tg_id'];
						$tgdesc = $datatg['tg_desc'];

						echo "<option ";
						if($taskgroupid==$tgid){
							echo " SELECTED ";
						}
						echo " value='$tgid'>$tgdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<!-- <tr>
		<td class="title">Tugasan</td>
		<td class="title">:</td>
		<td>
			<select name="txtTask" id="txtTask" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqltask = "SELECT task_id, task_desc FROM task";
					$restask = mysql_query($sqltask,$dbi);
					while($datatask = mysql_fetch_array($restask)){
						$taskid = $datatask['task_id'];
						$taskdesc = $datatask['task_desc'];

						echo "<option ";
						if($taskpilihid==$taskid){
							echo " SELECTED ";
						}
						echo " value='$taskid'>$taskdesc</option>";
					}
				?>
			</select>
		</td>
	</tr> -->
	<tr>
		<td>Tarikh Mula</td>
            <td>:</td>
            <td><input type="text" readonly="" size="12" maxlength="12" name="txtTmula" id="txtTmula" value="<?php echo fmtdate($taskdate); ?>" <?php echo $info; ?>>
        <?php
        	if ($staffrole<>14 && $staffrole<>15) {
       	?>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmtask.txtTmula);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
        <?php } ?>
			</td>
	</tr>
	<tr>
		<td class="title">Kumpulan Aset</td>
		<td class="title">:</td>
		<td>
			<select name="txtAssetGroup" id="txtAssetGroup" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlag = "SELECT ag_desc, ag_id FROM asset_group";
					$resag = mysql_query($sqlag,$dbi);
					while($dataag = mysql_fetch_array($resag)){
						$agid = $dataag['ag_id'];
						$agdesc = $dataag['ag_desc'];

						echo "<option ";
						if($assetgroupid==$agid){
							echo " SELECTED ";
						}
						echo " value='$agid'>$agdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Aset</td>
		<td class="title">:</td>
		<td>
			<select name="txtAsset" id="txtAsset" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlasset = "SELECT asset_desc, asset_id FROM asset";
					$resasset = mysql_query($sqlasset,$dbi);
					while($dataasset = mysql_fetch_array($resasset)){
						$assetid = $dataasset['asset_id'];
						$assetdesc = $dataasset['asset_desc'];

						echo "<option ";
						if($assetpilihid == $assetid){
							echo " SELECTED ";
						}
						echo " value='$assetid'>$assetdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Juru Teknik</td>
		<td class="title">:</td>
		<td>
			<select name="txtJuruteknik" id="txtJuruteknik" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqltech = "SELECT staff_id, staff_name FROM staff ";
					$restech = mysql_query($sqltech,$dbi);
					while($datatech = mysql_fetch_array($restech)){
						$techid = $datatech['staff_id'];
						$techname = $datatech['staff_name'];

						echo "<option ";
						if($staffid == $techid){
							echo " SELECTED ";
						}
						echo " value='$techid'>$techname</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<?php if($flg == "add") { ?>
	<tr>
		<td class="title">Kekerapan Tugas</td>
		<td class="title">:</td>
		<td>
			<select name="txtKekerapan" id="txtKekerapan" <?php echo $info; ?>>
				<option value="">- PILIH -</option>
				<option value="7">Seminggu sekali</option>
				<option value="14">Dua minggu sekali</option>
				<option value="30">Sebulan Sekali</option>
				<option value="365">Setahun Sekali</option>
			</select>
		</td>
	</tr>
	<?php } 
	if($flg == 'edit') { ?>
	<tr>
		<td class="title">Status</td>
		<td class="title">:</td>
		<td>
			<select name="txtStatus" id="txtStatus">
				<option value="">- PILIH -</option>
				<?php
					$sqlstatus="select ws_id, ws_desc from work_status where 1";
					if($staffrole==15)
						$sqlstatus.=" and ws_id!='4'";
					if($staffrole==14)
						$sqlstatus.=" and ws_id!='1' and ws_id!='2'";
					$qstat=mysql_query($sqlstatus,$dbi);
					while ($resstat=mysql_fetch_array($qstat)) {
						$wsid=$resstat["ws_id"];
						$wsdesc=$resstat["ws_desc"];

						echo "<option ";
						if ($workstatus==$wsid) {
							echo " SELECTED ";
						}
						echo "value='$wsid'>$wsdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title" valign="top">Catatan</td>
		<td class="title" valign="top">:</td>
		<td>
			<textarea name="txtCatatan" rows="10" cols="100%"></textarea>
		</td>
	</tr>
	<?php } ?>
	
	<tr>
		<td colspan="3">
	        <input type="hidden" name="taskid" value="<?php echo $bankid;?>"/>
	        <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
	        <input type="hidden" name="txtSysGroup" value="<?php echo $sysgroupid; ?>"/>
	        <input type="hidden" name="txtSystem" value="<?php echo $systemid; ?>"/>
	        <input type="hidden" name="txtKumpTugasan" value="<?php echo $taskgroupid; ?>"/>
	        <input type="hidden" name="txtTask" value="<?php echo $taskpilihid; ?>"/>
	        <input type="hidden" name="txtTarikhMula" value="<?php echo $taskdate; ?>"/>
	        <input type="hidden" name="txtAssetGroup" value="<?php echo $assetgroupid; ?>"/>
	        <input type="hidden" name="txtAsset" value="<?php echo $assetpilihid; ?>"/>
	        <input type="hidden" name="txtJuruteknik" value="<?php echo $staffid; ?>"/>
	        <input type="submit" value="Hantar" name="submit" class="button" onClick="return confirm('Adakah anda pasti?');"/>
	        <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_workorder'" class="button"/>
	    </td>
    </tr>
</table>
</form>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
$(function() {

 $("#txtSysGroup").bind("change", function() {

     $.ajax({
         type: "GET",
         url: "modules/Setup/system.php",
         data: "txtSysGroup="+$("#txtSysGroup").val(),
         success: function(html) {
             $("#txtSystem").html(html);
         }
     });
 });

 $("#txtAssetGroup").bind("change", function() {

     $.ajax({
         type: "GET",
         url: "modules/Setup/asset.php",
         data: "agid="+$("#txtAssetGroup").val(),
         success: function(html) {
             $("#txtAsset").html(html);
         }
     });
 });

 $("#txtSysGroup, #txtAssetGroup" ).bind("change", function() {
 	$.ajax({
 		type:"GET",
 		url:"modules/Setup/juruteknik.php",
 		data:"txtSysGroup="+$("#txtSysGroup").val() + "&agid="+$("#txtAssetGroup").val(),
 		success:function(html){
 			$("#txtJuruteknik").html(html);
 		}
 	});
 });


});
</script>


<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>	

