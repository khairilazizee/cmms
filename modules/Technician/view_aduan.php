<?php

$aduanid = (int) mysql_real_escape_string($_GET['aduan']);
$statuskerja = (int) mysql_real_escape_string($_GET['sis']);
$tarikhbermula = date("Y-m-d h:i:s");

if($statuskerja<="1"){
    $update = "UPDATE tbl_workorder SET ws_id='2', work_start='$tarikhbermula' WHERE id='$aduanid'";
    $resupdate = mysql_query($update,$dbi);
}

if(isset($_POST['submit'])){
	$wsid = $_POST['txtStatus'];
	$catatan = mysql_real_escape_string($_POST['txtCatatan']);
	$flg = $_POST['flg'];
	// echo $loop;

	if($flg=="edit"){
		$update = "UPDATE tbl_workorder SET ws_id='$wsid', catatan_juruteknik='$catatan' WHERE id='$aduanid'";
		mysql_query($update,$dbi);
	}

    pageredirect("mainpage.php?module=Setup&task=list_aduan");
    
}

$flg = "add";
$sql = "SELECT sg_id, sys_id, tg_id, staff_id, task_date, ag_id, asset_id, ws_id, catatan_juruteknik FROM tbl_workorder WHERE 1 and id='$aduanid'";
// var_dump($sql);
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
	$txtCatatan = $data['catatan_juruteknik'];
	$flg = "edit";
}

?>
<form name="frmtask" method="POST" action="">
<table class="outerform" width="100%" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<td colspan="3" style="font-weight:bold;" class="formheader">Aduan</td>
	</tr>
	<tr>
		<td width="150" class="title">Kumpulan Sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtSysGroup" id="txtSysGroup" <?php echo $info; ?>>
				<!-- <option value="">- PILIH -</option> -->
				<?php
					$sql = "SELECT sg_id, sg_desc FROM system_group WHERE sg_id='$sysgroupid'";
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
					// echo "<option value=''>- PILIH -</option>";
					$sqlsystem = "SELECT sys_id, sys_desc FROM system WHERE sys_id='$systemid'";
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
		<td class="title">Sub sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtKumpTugasan" id="txtKumpTugasan" <?php echo $info; ?>>
				<!-- <option value="">- PILIH -</option> -->
				<?php
					$sqltugasan = "SELECT tg_id, tg_desc FROM task_group WHERE tg_id='$taskgroupid'";
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
	<tr>
		<td>Tarikh Mula</td>
            <td>:</td>
            <td><input type="text" readonly="" size="12" maxlength="12" name="txtTmula" id="txtTmula" value="<?php echo fmtdate($taskdate); ?>" readonly>
			</td>
	</tr>
	<tr>
		<td class="title">Kumpulan Aset</td>
		<td class="title">:</td>
		<td>
			<select name="txtAssetGroup" id="txtAssetGroup" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlag = "SELECT ag_desc, ag_id FROM asset_group WHERE ag_id='$assetgroupid'";
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
					$sqlasset = "SELECT asset_desc, asset_id FROM asset WHERE asset_id='$assetpilihid'";
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
					// echo "<option value=''>- PILIH -</option>";
					$sqltech = "SELECT staff_id, staff_name FROM staff WHERE staff_id='$staffid'";
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
	<?php 
	if($flg == 'edit') { ?>
	<tr>
		<td class="title">Status</td>
		<td class="title">:</td>
		<td>
			<select name="txtStatus" id="txtStatus">
				<option value="">- PILIH -</option>
				<?php
					$sqlstatus="select ws_id, ws_desc from work_status where 1 and ws_id not in ('1','2','4')";
					
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
			<textarea name="txtCatatan" rows="5" cols="70"><?php echo $txtCatatan;?></textarea>
		</td>
	</tr>
	<?php } ?>
	
	<tr>
		<td colspan="3">
	        <input type="hidden" name="taskid" value="<?php echo $bankid;?>"/>
	        <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
	        <!-- <input type="hidden" name="txtSysGroup" value="<?php echo $sysgroupid; ?>"/>
	        <input type="hidden" name="txtSystem" value="<?php echo $systemid; ?>"/>
	        <input type="hidden" name="txtKumpTugasan" value="<?php echo $taskgroupid; ?>"/>
	        <input type="hidden" name="txtTask" value="<?php echo $taskpilihid; ?>"/>
	        <input type="hidden" name="txtTarikhMula" value="<?php echo $taskdate; ?>"/>
	        <input type="hidden" name="txtAssetGroup" value="<?php echo $assetgroupid; ?>"/>
	        <input type="hidden" name="txtAsset" value="<?php echo $assetpilihid; ?>"/>
	        <input type="hidden" name="txtJuruteknik" value="<?php echo $staffid; ?>"/> -->
	        <input type="submit" value="Hantar" name="submit" class="button" onClick="return confirm('Adakah anda pasti?');"/>
	        <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Technician&task=list_aduan'" class="button"/>
	    </td>
    </tr>
</table>
</form>