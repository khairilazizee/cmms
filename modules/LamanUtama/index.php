<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
    <td>
<?php

global $dbi;
global $usrrole;

	
$sql = "select menu.id,title from menu,menu_access where menu.id=menu_id and role=".$usrrole." and active='1' and type='menu' order by menupos";

$result = sql_query($sql, $dbi);

while ($datamenu=sql_fetch_array($result)){
  $parent=$datamenu["id"];
  $menu_title=$datamenu["title"];
  
  //Table title setiap kolum -----------------------
  $content .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#FFD2A0\">\n";
  $content .= "<tr>\n";
  $content .= "<td height=\"20\" class=\"title_sub\" style=\"text-align:left\">&nbsp;:: $menu_title\n";
  $content .= "</td></tr>\n";
  $content .= "</table>\n";
  //-----------------------------------------------
  
  $bgcolor="#FFFFFF"; 
  $sql2 = "select id,title,link,target_window,picture,description from menu,menu_access where menu.id=menu_id and role=".$usrrole." and parent='$parent' and active='1' order by menupos";
  $result2 = sql_query($sql2, $dbi);
  $iconcnt=0;
  	//$content .="<tr><td>\n";
	$content .="<table style=\"border:solid 1px #E8EFFC;\" width=\"100%\" bgcolor=\"$bgcolor\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\"><tr>\n";
  while ($data_submenu=sql_fetch_array($result2)) {
    $submenu_id=$data_submenu["id"];
    $submenu_title=$data_submenu["title"];
    $link=$data_submenu["link"];
    $target_window=$data_submenu["target_window"];
    $picture=$data_submenu["picture"];
    $description=$data_submenu["description"];

	if ($iconcnt==4){
	  $iconcnt=0;
	  $content .= "</tr><tr>";
	}  
    $content .= "<td width=\"20%\" align=\"center\"><a href=\"$link&m_id=$parent&s_id=$submenu_id\" target=\"$target_window\" ><img src=\"images/menu/$picture\" border=\"0\"><br>$submenu_title</a></td>\n";
	$idx++;  
	$iconcnt++;
  }

  while ($iconcnt<4){
    $content.="<td width=\"20%\">&nbsp;</td>";
    $iconcnt++;
  }
  $content .="</tr></table>\n";
  $content .= '<br>';
  
  $idx1++;
}

echo $content;
?>
  	</td>
	</tr>
</table>
