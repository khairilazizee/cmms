<?php
include "../mainfile.php";
$kod=$_GET["kod"];
$sql="select peperiksaan,tarikh_peperiksaan,tempat,gred_jawatan,tk,sesi from maklumat_peperiksaan where kod='$kod'";

$res=sql_query($sql,$dbi);
if ($dataperiksa=sql_fetch_array($res)){
  $nama_peperiksaan=$dataperiksa[0];
  $tarikh_peperiksaan=fmtdate($dataperiksa[1]);
  $tempat=$dataperiksa[2];
  $gred_jawatan=$dataperiksa[3];
  $tk=$dataperiksa[4];
  $sesi=$dataperiksa[5];

  echo "$nama_peperiksaan|$tarikh_peperiksaan|$tempat|$gred_jawatan|$tk|$sesi";
}
else
  echo "|||||";
?>
