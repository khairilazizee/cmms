<?php

// capaian mesti melalui page umportal
defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );


include_once("mainfile.php");
global $dbi;
	
	
$content = "<A name=scrollingCode></A><marquee behavior=\"scroll\" loop=\"-1\" height=\"200\" width=\"200\" direction=\"up\" " .
        "scrollamount=\"1\" hspace=\"0\" vspace=\"0\" scrolldelay=\"0\" bgcolor=\"#E8EFFC\" onmouseover='this.stop()' " .
        "onmouseout='this.start()'><table width=\"200\"><tr><td>";

$date = explode(" ", Date("m/d/Y H:i"));
$temp = explode("/", $date[0]);
$curr = "'$temp[2]-$temp[0]-$temp[1] $date[1]'";

$sql = "select title,activity from announcement where curdate() between startdate and enddate order by ordering";
$result = sql_query($sql, $dbi);
if (sql_num_rows($result) == 0) {
  $content .= "<div align='center'>Tiada berita terkini.</div>";
}
else {
  while (list($title,$activity) = sql_fetch_row($result)) {
    $content .= "<b>$title</b><br>$activity<P><HR noShade SIZE=1><P>";

  }
}

$content .= "</td></tr></table></marquee>";

?>

