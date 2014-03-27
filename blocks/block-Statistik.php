<?php

defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );

include_once("mainfile.php");
global $dbi;

function kira_jumlah($id){
	global $dbi;
	$sqlworkorder = "SELECT COUNT(*) as jumlahworkorder FROM tbl_workorder WHERE ws_id='$id'";
	$resworkorder = mysql_query($sqlworkorder,$dbi);
	$w = mysql_fetch_array($resworkorder);
	$bilworkorder = $w['jumlahworkorder'];

	$sqlrutin = "SELECT COUNT(*) as jumlahrutin FROM tbl_rutin WHERE ws_id='$id'";
	$resrutin = mysql_query($sqlrutin,$dbi);
	$r = mysql_fetch_array($resrutin);
	$bilrutin = $r['jumlahrutin'];

	$bilsemua = $bilworkorder + $bilrutin;
	return $bilsemua;
}

$content="<table width='200' cellspacing='3' cellpadding='1' class='table'>";
$sql = "SELECT ws_id, ws_desc FROM work_status ORDER BY ws_id";
$res = mysql_query($sql,$dbi);
while($data = mysql_fetch_array($res)){
	$descworking = $data['ws_desc'];
	$idworking = $data['ws_id'];
	$content.="<tr>";
	$content.="<td style='background-color:transparent'>$descworking</td>";
	$content.="<td style='background-color:transparent' align='center'>".kira_jumlah($idworking)."</td>";
	$content.="</tr>";
}
$content.="</table>";


?>