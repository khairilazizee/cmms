<?php

include ("../../include/mysql.php");

$agid = $_GET['agid'];
// die($agid);

echo "<option value=''>- PILIH -</option>";
$sqlasset = "SELECT asset_desc, asset_id FROM asset WHERE asset_ag_id='$agid'";
$resasset = mysql_query($sqlasset,$dbi);
while($dataasset = mysql_fetch_array($resasset)){
	$assetid = $dataasset['asset_id'];
	$assetdesc = $dataasset['asset_desc'];

	echo "<option value='$assetid'>$assetdesc</option>";
}

?>