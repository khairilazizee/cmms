<?php

include ("../../include/mysql.php");

$txtSysGroup = $_GET['txtSysGroup'];
// die($txtSysGroup);

echo "<option value=''>- PILIH -</option>";
$sqlsystem = "SELECT sys_id, sys_desc FROM system WHERE sys_id='$txtSysGroup'";
$ressystem = mysql_query($sqlsystem,$dbi);
while($datasystem = mysql_fetch_array($ressystem)){
	$sysid = $datasystem['sys_id'];
	$sysdesc = $datasystem['sys_desc'];

	echo "<option value='$sysid'>$sysdesc</option>";
}

?>