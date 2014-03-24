<?php

include ("../../include/mysql.php");

$txtSysGroup = $_GET['txtSysGroup'];
$agid = $_GET['agid'];
// die($txtSysGroup);

echo "<option value=''>- PILIH -</option>";
$sqltech = "SELECT staff_id, staff_name FROM staff WHERE staff_ag_id='$agid' and staff_sg_id='$txtSysGroup' ";
$restech = mysql_query($sqltech,$dbi);
while($datatech = mysql_fetch_array($restech)){
	$techid = $datatech['staff_id'];
	$techname = $datatech['staff_name'];

	echo "<option value='$techid'>$techname</option>";
}

?>