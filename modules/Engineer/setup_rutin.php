<?php

$rutinid = (int) mysql_real_escape_string($_REQUEST['rutin']);

if(isset($_POST['submit'])){
	$hari = $_POST['chkhari'];
	$sysgroup = $_POST['txtSysGroup'];
	// die($sysgroup);
	$system = $_POST['txtSystem'];
	$kumptugasan = $_POST['txtKumpTugasan'];
	$juruteknik = $_POST['txtJuruteknik'];
	$asgroup = $_POST['txtAssetGroup'];
	$asset = $_POST['txtAsset'];
	$rutin = $_POST['rutin'];
	$wstatus = $_POST['txtStatus'];
	$catatan = $_POST['txtCatatan'];
	$loop = count($hari);
	$flg = $_POST['flg'];

	// echo $loop;

	if($flg=="edit"){
		$update = "UPDATE tbl_rutin SET sg_id='$sysgroup', sys_id='$system', tg_id='$kumptugasan',staff_id='$juruteknik', hari='$hari', ag_id='$asgroup', asset_id='$asset', ws_id='$wstatus', catatan='$catatan' WHERE id='$rutin'";
		mysql_query($update,$dbi);
	}
    // echo("You selected $N day(s): ");

    pageredirect("mainpage.php?module=Engineer&task=list_rutin");
    
}

$flg = "add";
$sqlselect = "SELECT sg_id, sys_id, tg_id, staff_id, hari, ag_id, asset_id, ws_id, catatan FROM tbl_rutin WHERE id='$rutinid'";
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
	$workstatus = $info['ws_id'];
	$catat = $info['catatan'];
}

?>
<form name="frmtask" method="POST" action="">
<table class="outerform" width="100%" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<td colspan="3" style="font-weight:bold;" class="formheader">Rutin</td>
	</tr>
	<tr>
		<td width="150" class="title">Kumpulan Sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<input type="text" value="<?php echo GetDesc("system_group","sg_desc","sg_id",$sysgroupid); ?>" readonly />
			<input type="hidden" name="txtSysGroup" id="txtSysGroup" value="<?php echo $sysgroupid; ?>" />
		</td>
	</tr>
	<tr>
		<td class="title">Sistem</td>
		<td class="title">:</td>
		<td>
			<input type="text" value="<?php echo GetDesc("system","sys_desc","sys_id",$systemid); ?>" size="60" readonly />
			<input type="hidden" name="txtSystem" id="txtSystem" value="<?php echo $systemid; ?>">
		</td>
	</tr>
	<tr>
		<td class="title">Sub sistem</td>
		<td width="5" class="title">:</td>
		<td>
			<input type="text" value="<?php echo GetDesc("task_group","tg_desc","tg_id",$taskgroupid); ?>" size="60" readonly />
			<input type="hidden" name="txtKumpTugasan" id="txtKumpTugasan" value="<?php echo $taskgroupid; ?>">
		</td>
	</tr>
	<tr>
		<td class="title">Kumpulan Aset</td>
		<td class="title">:</td>
		<td>
			<input type="text" value="<?php echo GetDesc("asset_group","ag_desc","ag_id",$assetgroupid); ?>" readonly />
			<input type="hidden" name="txtAssetGroup" id="txtAssetGroup" value="<?php echo $assetgroupid; ?>">
		</td>
	</tr>
	<tr>
		<td class="title">Aset</td>
		<td class="title">:</td>
		<td>
			<input type="text" value="<?php echo GetDesc("asset","asset_desc","asset_id",$assetpilihid); ?>" size="50" readonly />
			<input type="hidden" name="txtAsset" id="txtAsset" value="<?php echo $assetpilihid; ?>">
	</tr>
	<tr>
		<td class="title">Juru Teknik</td>
		<td class="title">:</td>
		<td>
			<input type="text" value="<?php echo GetDesc("staff","staff_name","staff_id",$staffid); ?>" size="60" readonly />
			<input type="hidden" name="txtJuruteknik" id="txtJuruteknik" value="<? echo $staffid; ?>">
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
			<input type="text" value="<?php echo GetDesc("tbl_hari","keterangan_bm","id",$haripilih); ?>" readonly />
			<input type="hidden" name="chkhari" id="chkhari" value="<?php echo $haripilih; ?>">
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td class="title">Status</td>
		<td class="title">:</td>
		<td><input type="text" value="<?php echo GetDesc("work_status","ws_desc","ws_id",$workstatus); ?>" readonly /></td>
	</tr>
	<tr>
		<td class="title">Pengesahan</td>
		<td class="title">:</td>
		<?php
			if($workstatus<3){
				echo "<td><input type=\"text\" value=\"Menunggu tugasan selesai oleh juruteknik\" size=\"40\" readonly /></td>";
			}
			elseif($workstatus>4){
				echo "<td><input type=\"text\" value=\"Sudah disahkan oleh pegawai\" size=\"40\" readonly /></td>";
			}
			else{
		?>
		<td>
			<select name="txtStatus" id="txtStatus">
				<option value="">- PILIH -</option>
				<?php
					$sqlstatus="select ws_id, ws_desc from work_status where 1";
					if($staffrole==15)
						$sqlstatus.=" and ws_id!='4'";
					if($_SESSION['userrole']==12)
						$sqlstatus.=" and ws_id='3' or ws_id='4'";
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
		<?php } ?>
	</tr>
	<tr>
		<td class="title" valign="top">Catatan</td>
		<td class="title" valign="top">:</td>
		<td>
			<textarea name="txtCatatan" rows="5" cols="70"><?php echo $catat; ?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="3">
	        <input type="hidden" name="rutin" value="<?php echo $rutinid;?>"/>
	        <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
	        <input type="submit" value="Hantar" name="submit" class="button" onClick="return confirm('Adakah anda pasti?');"/>
	        <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Engineer&task=list_rutin'" class="button"/>
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