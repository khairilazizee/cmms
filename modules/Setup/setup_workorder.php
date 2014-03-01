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
					$sqlsystem = "SELECT sys_id, sys_desc FROM system WHERE sys_id='$txtSysGroup'";
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
});
</script>


