<?php

$idworkorder = mysql_real_escape_string($_GET['sysid']);

$staffrole = $_SESSION['userrole'];
if($staffrole<>14 && $staffrole<>15)
    $info="enabled";
else
    $info="disabled";

if($_POST['submit']){
	// die("masuk");
	$sysgroup = $_POST['txtSysGroup'];
	// die($sysgroup);
	$system = $_POST['txtSystem'];
	$task = $_POST['txtTask'];
	$juruteknik = $_POST['txtJuruteknik'];
	$asgroup = $_POST['txtAssetGroup'];
	$asset = $_POST['txtAsset'];
	$kekerapan = $_POST['txtKekerapan'];
	$tarikhmula = mysql_real_escape_string(mysqldate($_POST['txtTmula']));
	$status_p = $_POST['txtStatus'];
	$catatan = mysql_real_escape_string($_POST['txtCatatan']);
	$kumptugasan = $_POST['txtKumpTugasan'];
	$flg = $_POST['flg'];
	// echo $tarikhmula;
	// $hari = (strtotime("31-12-2014") - strtotime($tarikhmula)) / (60 * 60 * 24);
	// $hari = $hari + 1;
	// $bahagi = $hari / $kekerapan;
	// echo round($hari);
	// die();
	if($flg == "edit"){
		$update = "UPDATE tbl_workorder SET sg_id='$sysgroup', tg_id='$kumptugasan', sys_id='$system', staff_id='$juruteknik', task_date='$tarikhmula', ag_id='$asgroup', asset_id='$asset', ws_id='$status_p', catatan='$catatan' WHERE id='$idworkorder'";
		mysql_query($update,$dbi);
	}

	pageredirect("mainpage.php?module=Officer&task=list_aduan");

	
}

$flg = "add";
$sql = "SELECT sg_id, sys_id, tg_id, staff_id, task_date, ag_id, asset_id, ws_id FROM tbl_workorder WHERE 1 and id='$idworkorder'";
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
		<td colspan="3" style="font-weight:bold;" class="formheader">Aduan</td>
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
		<td>Tarikh Mula</td>
        <td>:</td>
        <td>
        	<input type="text" readonly="" size="12" maxlength="12" name="txtTmula" id="txtTmula" value="<?php echo fmtdate($taskdate); ?>">
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
			<textarea name="txtCatatan" rows="5" cols="70"></textarea>
		</td>
	</tr>
	
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
	        <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Officer&task=list_aduan'" class="button"/>
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

 $("#txtSysGroup, #txtAssetGroup").bind("change", function() {

     $.ajax({
         type: "GET",
         url: "modules/Setup/asset.php",
         data: "txtSysGroup="+$("#txtSysGroup").val() + "&agid="+$("#txtAssetGroup").val(),
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

