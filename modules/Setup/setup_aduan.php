<script type="text/javascript">
	function checkform(){
		if(document.frmtask.txtAssetGroup.value==""){
			alert("Sila pilih Kumpulan Aset.");
			document.frmtask.txtAssetGroup.focus();
			return false;
		}
		else if(document.frmtask.txtZone.value==""){
			alert("Sila pilih lokasi.");
			document.frmtask.txtZone.focus();
			return false;
		}
		else if(document.frmtask.txtPengadu.value==""){
			alert("Sila isi nama pengadu.");
			document.frmtask.txtPengadu.focus();
			return false;
		}
		else if(document.frmtask.txtKaedah.value==""){
			alert("Sila pilih kaedah aduan.");
			document.frmtask.txtKaedah.focus();
			return false;
		}
		else if(document.frmtask.txtSysGroup.value==""){
			alert("Sila pilih Kumpulan Sistem.");
			document.frmtask.txtSysGroup.focus();
			return false;
		}
		else if(document.frmtask.txtTmula.value==""){
			alert("Sila nyatakan tarikh aduan.");
			document.frmtask.txtTmula.focus();
			return false;
		}
		else if(document.frmtask.txtKeterangan.value==""){
			alert("Sila isi keterangan masalah.");
			document.frmtask.txtKeterangan.focus();
			return false;
		}
		else if(document.frmtask.txtJuruteknik.value==""){
			alert("Sila pilih juruteknik.");
			document.frmtask.txtJuruteknik.focus();
			return false;
		}
		else{
			return confirm("Adakah anda pasti?");
		}
	}
</script>
<?php

$idworkorder = mysql_real_escape_string($_GET['sysid']);
$staffagid = $_SESSION['staffagid'];

$staffrole = $_SESSION['userrole'];
if($staffrole<>14 && $staffrole<>15)
    $info="enabled";
else
    $info="disabled";

if($_POST['submit']){
	// die("masuk");
	$sysgroup = $_POST['txtSysGroup'];
	$lokasi_p = $_POST['txtZone'];
	$namapengadu_p = mysql_real_escape_string($_POST['txtPengadu']);
	$kaedahadu_p = $_POST['txtKaedah'];
	$keteranganaduan_p = mysql_real_escape_string($_POST['txtKeterangan']);
	// die($sysgroup);
	// $system = $_POST['txtSystem'];
	// $task = $_POST['txtTask'];
	$juruteknik = $_POST['txtJuruteknik'];
	$asgroup = $_POST['txtAssetGroup'];
	// $asset = $_POST['txtAsset'];
	// $kekerapan = $_POST['txtKekerapan'];
	$tarikhmula = mysql_real_escape_string(mysqldate($_POST['txtTmula']));
	$status_p = $_POST['txtStatus'];
	$catatan_p = mysql_real_escape_string($_POST['txtCatatan']);
	// $kumptugasan = $_POST['txtKumpTugasan'];
	$flg = $_POST['flg'];
	// echo $tarikhmula;
	// $hari = (strtotime("31-12-2014") - strtotime($tarikhmula)) / (60 * 60 * 24);
	// $hari = $hari + 1;
	// $bahagi = $hari / $kekerapan;
	// echo round($hari);
	// die();
	if($flg=="add"){
		// No Aduan
        $sqlnoaduan="SELECT max(ad_no_aduan) as no_aduan FROM tbl_aduan";
        $resnoaduan=mysql_query($sqlnoaduan,$dbi);
        $x=mysql_fetch_array($resnoaduan);
        $idstaf=$x["no_aduan"];

        if ($idstaf<>"") {
            $idstaf=substr($idstaf,-4);
            $idbaru=$idstaf+1;
            $idbaru=sprintf("%04d",$idbaru);
        }
        else {
            $idbaru="0001";
        }

        if($asgroup==1){
        	$idaduan="SS";
        	$jabatan_p="TPM";
        }
        elseif($asgroup==2){
        	$idaduan="SP";
        	$jabatan_p="PM";
        }

        $noaduanbaru=$idaduan.date(y).$idbaru;

        // die($noaduanbaru);

		$sqlworkorder = "INSERT INTO tbl_aduan (ad_no_aduan, ad_lokasi, ad_pengadu, ad_jabatan, ad_kaedah, ad_tarikh_adu, ad_sg_id, ad_ag_id, ad_keterangan, ad_staff_id, ad_status) VALUES ('$noaduanbaru','$lokasi_p','$namapengadu_p','$jabatan_p','$kaedahadu_p','$tarikhmula','$sysgroup','$asgroup','$keteranganaduan_p','$juruteknik','1')";
		$resworkorder = mysql_query($sqlworkorder,$dbi);

	} elseif($flg == "edit"){
		if($asgroup==1)
			$jabatan_p="TPM";
		else
			$jabatan_p="PM";

		// die("UPDATE tbl_aduan SET ad_lokasi='$lokasi_p', ad_pengadu='$namapengadu_p', ad_jabatan='$jabatan_p', ad_kaedah='$kaedahadu_p', ad_tarikh_adu='$tarikhmula', ad_sg_id='$sysgroup', ad_ag_id='$asgroup', ad_keterangan='$keteranganaduan_p', staff_id='$juruteknik', ad_catatan='$catatan_p' WHERE ad_id='$idworkorder'");

		$update = "UPDATE tbl_aduan SET ad_lokasi='$lokasi_p', ad_pengadu='$namapengadu_p', ad_jabatan='$jabatan_p', ad_kaedah='$kaedahadu_p', ad_tarikh_adu='$tarikhmula', ad_sg_id='$sysgroup', ad_ag_id='$asgroup', ad_keterangan='$keteranganaduan_p', ad_staff_id='$juruteknik', ad_catatan='$catatan_p' WHERE ad_id='$idworkorder'";
		mysql_query($update,$dbi);
	}

	pageredirect("mainpage.php?module=Setup&task=list_aduan");

	
}

$flg = "add";
$sql = "SELECT ad_no_aduan, ad_lokasi, ad_pengadu, ad_jabatan, ad_kaedah, ad_tarikh_adu, ad_sg_id, ad_ag_id, ad_keterangan, ad_staff_id, ad_catatan, ad_status FROM tbl_aduan WHERE ad_id='$idworkorder'";
// die("SELECT sg_id, sys_id, tg_id, task_id, staff_id, task_date, ag_id, asset_id FROM tbl_workorder WHERE 1 and id='$idworkorder'");
$res = mysql_query($sql,$dbi);
if(mysql_num_rows($res)>0){
	$data = mysql_fetch_array($res);
	$noaduan = $data['ad_no_aduan'];
	$lokasi = $data['ad_lokasi'];
	$namapengadu = $data['ad_pengadu'];
	$jabatan = $data['ad_jabatan'];
	$kaedahadu = $data['ad_kaedah'];
	$taskdate = $data['ad_tarikh_adu'];
	$sysgroupid = $data['ad_sg_id'];
	$assetgroupid = $data['ad_ag_id'];
	$keteranganaduan = $data['ad_keterangan'];
	$staffid = $data['ad_staff_id'];
	$catatan = $data['ad_catatan'];
	$workstatus = $data['ad_status'];
	$flg = "edit";
}

?>
<form name="frmtask" method="POST" action="">
<table class="outerform" width="100%" cellspacing="0" cellpadding="3" align="center">
	<tr>
		<td colspan="3" style="font-weight:bold;" class="formheader">Aduan</td>
	</tr>
	<tr>
		<td class="title">No. Aduan</td>
		<td class="title">:</td>
		<td><input type="text" name="txtNoAduan" id="txtNoAduan" value="<?php echo $noaduan; ?>" readonly onclick="alert('Dijana oleh sistem');" /></td>
	</tr>
	<tr>
		<td class="title">Kumpulan Aset</td>
		<td class="title">:</td>
		<td>
			<select name="txtAssetGroup" id="txtAssetGroup" <?php echo $info; ?>>
				<?php
					echo "<option value=''>- PILIH -</option>";
					$sqlag = "SELECT ag_desc, ag_id FROM asset_group WHERE 1";
					if($staffagid<>0){
						$sqlag.=" and ag_id='$staffagid'";
					}
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
		<td class="title">Lokasi</td>
		<td class="title">:</td>
		<td>
			<select name="txtZone" id="txtZone">
				<option value="">- PILIH -</option>
				<?php
					$sql = "SELECT zon_id, zon_desc FROM zone WHERE 1 ";
					if($staffagid<>0)
						$sql.=" and ag_id='$staffagid'";

					$sql.=" ORDER BY zon_id";
					$res = mysql_query($sql,$dbi);
					while($datasg=mysql_fetch_array($res)){
						$sgid = $datasg['zon_id'];
						$sgdesc = $datasg['zon_desc'];

						echo "<option";
						if($lokasi==$sgid){
							echo " SELECTED";
						}
						echo " value='$sgid'>$sgdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="title">Nama Pengadu</td>
		<td class="title">:</td>
		<td><input type="text" name="txtPengadu" id="txtPengadu" value="<?php echo $namapengadu; ?>" size="50" maxlength="100" /></td>
	</tr>
	<tr>
		<td class="title">Kaedah Aduan</td>
		<td class="title">:</td>
		<td>
			<select name="txtKaedah" id="txtKaedah">
				<option value="">- PILIH -</option>
				<?php
					$sql="SELECT kad_id, kad_desc FROM tbl_aduan_kaedah ORDER BY kad_id";
					$res=mysql_query($sql,$dbi);
					while($datasg=mysql_fetch_array($res)){
						$sgid=$datasg['kad_id'];
						$sgdesc=$datasg['kad_desc'];

						echo "<option";
						if($kaedahadu==$sgid){
							echo " SELECTED";
						}
						echo " value='$sgid'>$sgdesc</option>";
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="150" class="title">Kumpulan Sistem</td>
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
	<!-- <tr>
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
		<td class="title">Sub sistem</td>
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
	</tr> -->
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
		<td>Tarikh Aduan</td>
            <td>:</td>
            <td><input type="text" readonly="" size="12" maxlength="12" name="txtTmula" id="txtTmula" value="<?php echo fmtdate($taskdate); ?>" <?php echo $info; ?>>
        <?php
        	if ($staffrole<>14 && $staffrole<>15) {
       	?>
        <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.frmtask.txtTmula);return false;" ><img class="PopcalTrigger" align="absmiddle" src="popupcal/calbtn.gif" width="34" height="22" border="0" alt=""></a>
        <?php } ?>
			</td>
	</tr>
	<!-- <tr>
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
	</tr> -->
	<tr>
		<td class="title" valign="top">Keterangan Masalah</td>
		<td class="title" valign="top">:</td>
		<td><textarea name="txtKeterangan" id="txtKeterangan" cols="70" rows="3"><?php echo $keteranganaduan; ?></textarea></td>
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
	<!-- <tr>
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
	</tr> -->
	<?php } 
	if($flg == 'edit') { ?>
	<!-- <tr>
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
	</tr> -->
	<tr>
		<td class="title" valign="top">Catatan</td>
		<td class="title" valign="top">:</td>
		<td>
			<textarea name="txtCatatan" rows="5" cols="70"></textarea>
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
	        <input type="submit" value="Hantar" name="submit" class="button" onClick="return checkform();"/>
	        <input type="button" name="back" value="Kembali" onclick="location.href='mainpage.php?module=Setup&task=list_aduan'" class="button"/>
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

 $("#txtAssetGroup").bind("change", function() {

     $.ajax({
         type: "GET",
         url: "modules/Setup/zone.php",
         data: "txtAssetGroup="+$("#txtAssetGroup").val(),
         success: function(html) {
             $("#txtZone").html(html);
         }
     });
 });


});
</script>


<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="popupcal/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>	

