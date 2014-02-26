<?php 
// capaian mesti melalui page umportal
defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );

include_once("mainfile.php");
global $dbi;

$content = "";

$result = sql_query("select title,content,image from message where active=1 order by createddate",$dbi);

while(list($title, $c,$image) = sql_fetch_row($result)){

   //$content.="<table width=\"100%\" bgcolor=\"#F8F5D6\" cellspacing=\"0\" cellpadding=\"1\" border=\"0\"><tr><td>";
   $content.="<table width=\"100%\" bgcolor=\"#FFFFFF\" cellspacing=\"1\" cellpadding=\"5\" border=\"0\">";
   $content .= "<tr><td>".$c."</td></tr>"; 
   $content .="</td></tr></table>";
   //$content .="</td></tr></table>";

}   
?>
