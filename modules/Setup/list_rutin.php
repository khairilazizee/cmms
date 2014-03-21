<style type="text/css">
	ul.nav {
		width:100%;
		margin:0 auto;
		padding: 4px 0;
		z-index:-1;
	}

	ul.nav li {
		list-style:none;
		/*padding:10px;*/
		display:block;
		float:right;
	}

	ul.nav li a {
		border-top:1px solid #ccc;
		border-left:1px solid #ccc;
		border-right:1px solid #ccc;
		padding: 9px 15px;
		text-decoration:none;
		background-color: #f2f2f2;
		color: #000;
		font-weight:bold;
		letter-spacing:1px;
		line-height: 2em;
    	height: 2em;
	}

	ul.nav li a:hover {
		background-color: #1c1c1c;
		color:#fff;
	}

	ul.nav li a.active {
		background-color: #1c1c1c;
		color:#fff;
	}

	.ruang {
		border:1px solid #ccc;
		width:100%;
	}

	#isi {
		padding:5px 5px;
	}
</style>
<?php

include('include/function.php');
$Mfunction = new fungsi();
$limit = 25;

if(!isset($_GET["limit"]))
  $rowstart = 0;
else
  $rowstart = $_GET["limit"];

$haripilih = $_GET['hari'];
if($haripilih==1){
	$isnin = "active";
} elseif($haripilih==2){
	$selasa = "active";
} elseif($haripilih==3){
	$rabu = "active";
} elseif($haripilih==4){
	$khamis = "active";
} elseif($haripilih==5){
	$jumaat = "active";
} elseif($haripilih==6){
	$sabtu = "active";
} elseif($haripilih==7){
	$ahad = "active";
}

?>
<div style="text-align:right;font-weight:bold;"><a href="mainpage.php?module=Setup&task=setup_rutin">Tambah<img src="images/admin/btn_add.gif"></a></div><br>	
<table width="100%">
	<tr>
		<td>
			<ul class="nav">
		    	<li><a class="<?php echo $ahad;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=7">Ahad</a></li>
		    	<li><a class="<?php echo $sabtu;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=6">Sabtu</a></li>
		    	<li><a class="<?php echo $jumaat;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=5">Jumaat</a></li>
		    	<li><a class="<?php echo $khamis;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=4">Khamis</a></li>
		    	<li><a class="<?php echo $rabu;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=3">Rabu</a></li>
		    	<li><a class="<?php echo $selasa;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=2">Selasa</a></li>
		    	<li><a class="<?php echo $isnin;?>" href="mainpage.php?module=Setup&task=list_rutin&hari=1">Isnin</a></li>
		    </ul>
		</td>
	</tr>
	<tr>
		<td>
			<div class="ruang">
				<div id="isi">
					<table width="100%" cellspacing="1" cellpadding="4" align="center" class="table">
						<tr>
							<th>Bil</th>
							<th>Kump. Tugasan</th>
							<th>Juruteknik</th>
							<th>Kump. Asset</th>
							<th>Status</th>
							<th>Tindakan</th>
						</tr>
						<?php
							$bil=0;
							$sqlrutin = "SELECT id, tg_id, staff_id, ag_id, ws_id FROM tbl_rutin WHERE hari='$haripilih' and js_id='3'";
							// echo $sqlrutin;
							$resrutin = mysql_query($sqlrutin,$dbi);
							$sqlrutinfull = $sqlrutin." LIMIT $rowstart, $limit";
							$resrutinfull = mysql_query($sqlrutinfull,$dbi);
							$cnt=$rowstart;
							while($info = mysql_fetch_array($resrutinfull)){
								$cnt++;
								$tgid = $info['tg_id'];
								$namakumptugasan = GetDesc("task_group","tg_desc","tg_id",$tgid);
								$staffid = $info['staff_id'];
								$namastaff = GetDesc("staff","staff_name","staff_id",$staffid);
								$agid = $info['ag_id'];
								$namakumpaset = GetDesc("asset_group","ag_desc","ag_id",$agid);
								$stat = $info['ws_id'];
								$wstatus = GetDesc("work_status","ws_desc","ws_id",$stat);
								$idrutin = $info['id'];


								echo "<tr bgcolor=\"$bgcolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$bgcolor'\">\n";
								echo "<td>$cnt</td>";
								echo "<td>$namakumptugasan</td>";
								echo "<td>$namastaff</td>";
								echo "<td>$namakumpaset</td>";
								echo "<td>$wstatus</td>";
								echo "<td align='center'>
									 <a href=\"mainpage.php?module=Setup&task=setup_rutin&rutin=$idrutin\"><img src=\"images/admin/btn_edit.gif\"/></a>&nbsp;&nbsp;<a href=\"mainpage.php?module=Setup&task=list_rutin&delete=1&iddelete=$idrutin\" onClick=\"return confirm('Hapus Data?');\"><img src=\"images/admin/btn_delete.gif\"/></a>
								</td>";
								echo "</tr>";
							}
						?>
					</table>
				</div>
			</div>
		</td>
	</tr>
</table>