<?php
global $dbi;
$usrrole=$_SESSION["userrole"];

$sql = "select menu.id,title from menu,menu_access where menu.id=menu_id and role=".$usrrole." and active='1' and type='menu' order by menupos";

$content ="<script \"text/javascript\" src=\"jscript/cssmenu.js\"></script>\n";
$content .= "<div class=\"suckerdiv\">\n";
$result = sql_query($sql, $dbi);
$num1=sql_num_rows($result);
//echo "select menu.id,title from menu,menu_access where menu.id=menu_id and role=".$usrrole." and active='1' and type='menu' order by menupos <br>";

$idx1=0;
$content .= "<ul id=\"suckertree1\">\n";
while ($idx1 < $num1){
  $sql2 = "select id,title,link,target_window from menu,menu_access where menu.id=menu_id and role=".$usrrole." and parent=".sql_result($result,$idx1,"id")." and active='1' order by menupos";
  $result2 = sql_query($sql2, $dbi);
  $num=mysql_numrows($result2);
  $title=sql_result($result,$idx1,"title");
  $idx=0;
  //echo "$sql2 <br>";
  $content .="<li><a href=\"#\">$title</a>\n";
  //$content .="<li>$title</a>\n";
  $content .="<ul>\n";
  while ($idx < $num) {
  //echo "idx=$idx ";
    $link=sql_result($result2,$idx,"link");
	$id=sql_result($result2,$idx,"id");
	$subtitle=sql_result($result2,$idx,"title");
    $target=sql_result($result2,$idx,"target_window");
    $content .="<li><a href=\"$link\" target=\"$target\">$subtitle</a></li>\n";
	$idx++;
  }
  $content .="</ul>\n";
  $content .="</li>\n";
  $idx1++;
}
$content .="</ul>\n";
$content .="</div>\n";
?>