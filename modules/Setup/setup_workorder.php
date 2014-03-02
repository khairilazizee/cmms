<form name="frmtask" method="POST" action="">
<table class="outerform" width="100%" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<td colspan="3" style="font-weight:bold;" class="formheader">Setup Work Order</td>
	</tr>
	<tr>
		<td width="100" class="title">System Group</td>
		<td width="5" class="title">:</td>
		<td>
			<select name="txtSysGroup" id="txtSysGroup">
				<option value="">- PILIH -</option>
				<?php
					$sql = "SELECT sg_id, sg_desc FROM system_group";
					$res = mysql_query($sql,$dbi);
					while($datasg = mysql_fetch_array($res)){
						$sgid = $datasg['sg_id'];
						$sgdesc = $datasg['sg_desc'];

						echo "<option value='$sgid'>$sgdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">System</td>
		<td class="title">:</td>
		<td>
			<select name="txtSystem" id="txtSystem">
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlsystem = "SELECT sys_id, sys_desc FROM system";
					$ressystem = mysql_query($sqlsystem,$dbi);
					while($datasystem = mysql_fetch_array($ressystem)){
						$sysid = $datasystem['sys_id'];
						$sysdesc = $datasystem['sys_desc'];

						echo "<option value='$sysid'>$sysdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Task</td>
		<td class="title">:</td>
		<td>
			<select name="txtTask" id="txtTask">
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqltask = "SELECT task_id, task_desc FROM task";
					$restask = mysql_query($sqltask,$dbi);
					while($datatask = mysql_fetch_array($restask)){
						$taskid = $datatask['task_id'];
						$taskdesc = $datatask['task_desc'];

						echo "<option value='$taskid'>$taskdesc</option>";
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
					$sqltech = "SELECT nama, id FROM user WHERE role='15'";
					$restech = mysql_query($sqltech,$dbi);
					while($datatech = mysql_fetch_array($restech)){
						$techid = $datatech['id'];
						$techname = $datatech['nama'];

						echo "<option value='$techid'>$techname</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Tugasan</td>
		<td class="title">:</td>
		<td>
			<input type="text" name="txtTugasan" size="60">
		</td>
	</tr>
	<tr>
		<td class="title">Asset Group</td>
		<td class="title">:</td>
		<td>
			<select name="txtAssetGroup" id="txtAssetGroup">
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlag = "SELECT ag_desc, ag_id FROM asset_group";
					$resag = mysql_query($sqlag,$dbi);
					while($dataag = mysql_fetch_array($resag)){
						$agid = $dataag['ag_id'];
						$agdesc = $dataag['ag_desc'];

						echo "<option value='$agid'>$agdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Asset</td>
		<td class="title">:</td>
		<td>
			<select name="txtAsset" id="txtAsset">
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlasset = "SELECT asset_desc, asset_id FROM asset";
					$resasset = mysql_query($sqlasset,$dbi);
					while($dataasset = mysql_fetch_array($resasset)){
						$assetid = $dataasset['asset_id'];
						$assetdesc = $dataasset['asset_desc'];

						echo "<option value='$assetid'>$assetdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Kekerapan Tugas</td>
		<td class="title">:</td>
		<td>
			<select name="txtKekerapan" id="txtKekerapan">
				<option value="">- PILIH -</option>
				<option value="1">Seminggu sekali</option>
				<option value="2">Dua minggu sekali</option>
				<option value="3">Sebulan Sekali</option>
				<option value="4">Setahun Sekali</option>
			</select>
		</td>
	</tr>
	<td colspan="3">
            <input type="hidden" name="taskid" value="<?php echo $bankid;?>"/>
            <input type="hidden" name="flg" value="<?php echo $flg;?>"/>
            <input type="submit" value="Submit" name="submit" class="button"/ onClick="return confirm('Do you wish to proceed?');">
            <input type="button" name="back" value="Back" onclick="location.href='mainpage.php?module=Setup&task=list_task'" class="button"/>
        </td>
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


});
</script>


