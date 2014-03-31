<?php

global $dbi;

function kira_jumlah_kontrak($puid,$ptid){
	global $dbi;

	if($puid<>3) {
		$sql = "SELECT SUM(ps_price) as ps_price, SUM(pt_price) as pt_price, SUM(psi_price) as psi_price FROM  tbl_pengurusan_utama LEFT JOIN tbl_pengurusan_tajuk ON tbl_pengurusan_utama.pu_id=tbl_pengurusan_tajuk.pu_id LEFT JOIN tbl_pengurusan_sub ON tbl_pengurusan_tajuk.pt_id=tbl_pengurusan_sub.pt_id LEFT JOIN tbl_pengurusan_subitem ON tbl_pengurusan_sub.ps_id=tbl_pengurusan_subitem.ps_id WHERE tbl_pengurusan_utama.pu_id='$puid'";
		// echo $sql."<br />";
		$res = mysql_query($sql,$dbi);
		$fetchprice = mysql_fetch_array($res);
		$psprice = $fetchprice['ps_price'];
		$ptprice = $fetchprice['pt_price'];
		$psiprice = $fetchprice['psi_price'];
		$sum = $psiprice + $ptprice + $psprice;
	} else {
		$sql = "SELECT pt_price FROM tbl_pengurusan LEFT JOIN tbl_pengurusan_tajuk ON tbl_pengurusan_utama.pu_id=tbl_pengurusan_tajuk.pu_id WHERE tbl_pengurusan_utama.pu_id='$puid' and tbl_pengurusan_tajuk.pt_id='$ptid'";
		$res = mysql_query($sql,$dbi);
		$fetchprice = mysql_fetch_array($res);
		$ptprice = $fetchprice['pt_price'];
		$sum = $ptprice;
	}

	return number_format($sum,2,".",",");
}

function kira_jumlah_semua(){
	global $dbi;

	$sql = "SELECT SUM(ps_price) as ps_price, SUM(pt_price) as pt_price, SUM(psi_price) as psi_price FROM  tbl_pengurusan_utama LEFT JOIN tbl_pengurusan_tajuk ON tbl_pengurusan_utama.pu_id=tbl_pengurusan_tajuk.pu_id LEFT JOIN tbl_pengurusan_sub ON tbl_pengurusan_tajuk.pt_id=tbl_pengurusan_sub.pt_id LEFT JOIN tbl_pengurusan_subitem ON tbl_pengurusan_sub.ps_id=tbl_pengurusan_subitem.ps_id";
	// echo $sql;
	$res = mysql_query($sql,$dbi);
	$fetchprice = mysql_fetch_array($res);
	$psprice = $fetchprice['ps_price'];
	$ptprice = $fetchprice['pt_price'];
	$psiprice = $fetchprice['psi_price'];
	$sum = $psiprice + $ptprice + $psprice;

	return number_format($sum,2,".",",");
}

?>