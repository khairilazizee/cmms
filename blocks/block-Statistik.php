<?php

defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );

include_once("mainfile.php");
global $dbi;

$content="<table width='200' cellspacing='3' cellpadding='1' class='table'>";
$sql = "SELECT ws_id, ws_desc FROM work_status ORDER BY ws_id";
$res = mysql_query($sql,$dbi);
while($data = mysql_fetch_array($res)){
	$descworking = $data['ws_desc'];
	$content.="<tr>";
	$content.="<td style='background-color:transparent'>$descworking</td>";
	$content.="<td style='background-color:transparent' align='center'>x</td>";
	$content.="</tr>";
}
$content.="</table>";


?>