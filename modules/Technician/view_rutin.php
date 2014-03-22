<?php

$rutinid = (int) mysql_real_escape_string($_REQUEST['rutin']);
$idworkorder = mysql_real_escape_string($_GET['sis']);
$tarikhbermula = date("Y-m-d");

if($statuskerja<="1"){
    $update = "UPDATE tbl_rutin SET ws_id='2', work_start='$tarikhbermula' WHERE id='$rutinid'";
    $resupdate = mysql_query($update,$dbi);
}


if(isset($_POST['submit'])){
	$wsid = $_POST['txtStatus'];
	$flg = $_POST['flg'];
	$datedone = date("Y-m-d");
	// echo $loop;

	if($flg=="edit"){
		$update = "UPDATE tbl_rutin SET ws_id='$wsid', work_done='$datedone' WHERE id='$rutinid'";
		mysql_query($update,$dbi);
	}

    pageredirect("mainpage.php?module=Setup&task=list_rutin");
    
}

$sqlselect = "SELECT sg_id, sys_id, tg_id, staff_id, hari, ag_id, asset_id FROM tbl_rutin WHERE id='$rutinid'";
$resselect = mysql_query($sqlselect,$dbi);
if($info = mysql_fetch_array($resselect)){
	$flg = "edit";
	$sysgroupid = $info['sg_id'];
	$systemid = $info['sys_id'];
	$taskgroupid = $info['tg_id'];
	$assetgroupid = $info['ag_id'];
	$assetpilihid = $info['asset_id'];
	$staffid = $info['staff_id'];
	$haripilih = $info['hari'];
}

?>
<form name="frmtask" method="POST" action="">
<table class="outerform" width="100%" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<td colspan="3" style="font-weight:bold;" class="formheader">Rutin</td>
	</tr>
	<tr>
		<td width="100" class="title">Kumpulan Sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtSysGroup" id="txtSysGroup">
				<option value="">- PILIH -</option>
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
			<select name="txtSystem" id="txtSystem">
				<?php
					echo "<option value=''>- PILIH -</option>";
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
		<td width="100" class="title">Sub sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtKumpTugasan" id="txtKumpTugasan">
				<option value="">- PILIH -</option>
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
		<td class="title">Kumpulan Aset</td>
		<td class="title">:</td>
		<td>
			<select name="txtAssetGroup" id="txtAssetGroup">
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
			<select name="txtAsset" id="txtAsset">
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
			<select name="txtJuruteknik" id="txtJuruteknik">
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqltech = "SELECT staff_id, staff_name FROM staff WHERE staff_id='$staffid' ";
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
	<?php if($flg=="add") { ?>
	<tr>
		<td class="title">Hari</td>
		<td class="title">:</td>
		<td>
			<input type="checkbox" name="chkhari[]" value="1"> Isnin
			<input type="checkbox" name="chkhari[]" value="2"> Selasa
			<input type="checkbox" name="chkhari[]" value="3"> Rabu
			<input type="checkbox" name="chkhari[]" value="4"> Khamis
			<input type="checkbox" name="chkhari[]" value="5"> Jumaat
			<input type="checkbox" name="chkhari[]" value="6"> Sabtu
			<input type="checkbox" name="chkhari[]" value="7"> Ahad
		</td>
	</tr>
	<?php }elseif($flg == "edit") {?>
	<tr>
		<td class="title">Hari</td>
		<td class="title">:</td>
		<td>
			<select name="chkhari" id="chkhari">
				<option value="">- PILIH -</option>
				<?php
					$sqlhari = "SELECT id, keterangan_bm FROM tbl_hari WHERE id='$haripilih' ORDER BY id";
					$reshari = mysql_query($sqlhari,$dbi);
					while($datahari = mysql_fetch_array($reshari)){
						$idhari = $datahari['id'];
						$keteranganhari = $datahari['keterangan_bm'];

						echo "<option ";
						if($haripilih == $idhari){
							echo " SELECTED ";
						}
						echo " value='$idhari'>$keteranganhari</option>";
					}
				?>
			</select>
		</td>
	</tr>
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
		<td class="title">Catatan</td>
		<td class="title">:</td>
		<td><textarea name="txtCatatanJuruteknik" id="txtCatatanJuruteknik" cols="100%" rows="5"></textarea></td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="3">
	        <input type="hidden" name="rutin" value="<?php echo $rutinid;?>"/>
	        <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
	        <input type="submit" value="Hantar" name="submit" class="button" onClick="return confirm('Adakah anda pasti?');"/>
	        <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_rutin'" class="button"/>
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