<script type="text/javascript">
/*  
Script made by Martial Boissonneault © 2001-2003 http://getElementById.com/
This script may be used and changed freely as long as this msg is intact
Visit http://getElementById.com/ for more free scripts and tutorials.
Script featured at SimplytheBest.net http://simplythebest.net/scripts/
*/
// Courtesy of SimplytheBest.net - http://simplythebest.net/scripts/

function SwitchMenu(obj){
	if(document.getElementById){
	var el = document.getElementById(obj);
	var ar = document.getElementById("cont").getElementsByTagName("DIV");
		if(el.style.display == "none"){
			for (var i=0; i<ar.length; i++){
				ar[i].style.display = "none";
			}
			el.style.display = "block";
		}else{
			el.style.display = "none";
		}
	}
}
function ChangeClass(menu, newClass) { 
	 if (document.getElementById) { 
	 	document.getElementById(menu).className = newClass;
	 } 
} 
document.onselectstart = new Function("return true");
</script>
<!-- Menu start -->
<div id="cont">
<?php
  //HR3 - Kursus/Peperiksaan
  //HR2 - Kursus/Peperiksaan/Penyelenggaraan
  //HR1 - Kursus/Peperiksaan/Penyelenggaraan/Laporan
  //39 - Kursus
  //98 - Peperiksaan
  //92 - Penyelenggaraan
  //119 - Laporan

  $content="";
 // if ($_SESSION["username"]=="pie")
 //   $sql="select id,title from menu,menu_access where id=menu_id and role=".$_SESSION["userrole"]." and parent=0 and id<>92 and id<>119 order by menupos";
 // else
    $sql="select id,title from menu,menu_access where id=menu_id and role=".$_SESSION["userrole"]." and parent=0 order by menupos";

  $res=sql_query($sql,$dbi);
  $cnt=1;
  while($data=sql_fetch_array($res)){
	$parent=$data["id"];
	$title=$data["title"];
	echo "<p id=\"menu$parent\" class=\"menuOut\" onclick=\"SwitchMenu('sub$parent')\" onmouseover=\"ChangeClass('menu$parent','menuOver')\" onmouseout=\"ChangeClass('menu$parent','menuOut')\"><img src=\"images/arrow3.gif\">&nbsp;$title</p>\n";
	echo "<div class=\"submenu\" id=\"sub$parent\" style=\"display:none;\">\n";
	echo "  <ul>\n";
    $sql2="select id,title,link,target_window from menu,menu_access where id=menu_id and role=".$_SESSION["userrole"]." and parent=$parent order by menupos";
 	//$sql2="select title,link from menu where parent=$parent order by pos";
	$res2=sql_query($sql2,$dbi);
	while ($data2=sql_fetch_array($res2)){
	    $submenu=$data2["id"];
	    $link=$data2["link"]."&m_id=$parent&s_id=$submenu";
		$subtitle=$data2["title"];
        $target=$data2["target_window"];
        if ($submenu==$_GET["s_id"])
		  echo "<li><a href=\"$link\" target=\"$target\" title=\"$subtitle\" style=\"background:#CC3366;color:#FFFFFF;border:1px solid #000;\">$subtitle</a></li>\n";
        else
		  echo "<li><a href=\"$link\" target=\"$target\" title=\"$subtitle\">$subtitle</a></li>\n";
	}	
    echo "  </ul>\n";
	echo "</div>\n";
	$cnt++;

}	

?>

</div>

<!-- Menu end -->
<?php
//ASAL
/* $m=$_GET["module"];
 $resmenu=sql_query("select id from menu where parent=0 and module='$m'",$dbi);
 if ($datamenu=sql_fetch_array($resmenu)){
   $id_menu=$datamenu[0];
   $content.= "<script type=\"text/javascript\">SwitchMenu('sub$id_menu','',0)</script>";
 }  
*/
if ($_GET["m_id"]<>""){
  $id_menu=(int) $_GET["m_id"];
  $content.= "<script type=\"text/javascript\">SwitchMenu('sub$id_menu','',0)</script>";
}
?>  
