<?php

include ("../../include/mysql.php");

$agid = $_GET['txtAssetGroup'];
// die($agid);

echo "<option value=''>- PILIH -</option>";
$sqlasset = "SELECT zon_id, zon_desc FROM zone WHERE ag_id='$agid'";
$resasset = mysql_query($sqlasset,$dbi);
while($dataasset = mysql_fetch_array($resasset)){
	$assetid = $dataasset['zon_id'];
	$assetdesc = $dataasset['zon_desc'];

	echo "<option value='$assetid'>$assetdesc</option>";
}

?>