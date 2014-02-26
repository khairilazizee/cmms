<?php

if (!@include_once("admin/filemanager/incl/auth.inc.php"))
 include_once("admin/filemanager/incl/auth.inc.php");

if ($AllowDownload)
{
  print "<table class='index' width=95% cellpadding=0 cellspacing=0 bgcolor=\"FFFFFF\">";
   print "<tr bgcolor='999999'>";
    print "<td class='iheadline' height=21>";
     print "<font class='iheadline'>&nbsp;$StrDownload \"".htmlentities($filename)."\"</font>";
    print "</td>";
    print "<td class='iheadline' align='right' height=21>";
     print "<font class='iheadline'><a href='$modname&amp;path=".htmlentities(rawurlencode($path))."'><img src='admin/filemanager/icon/back.gif' border=0 alt='$StrBack'></a></font>";
    print "</td>";
   print "</tr>";
   print "<tr>";
    print "<td valign='top' colspan=2>";
     print "<center><br />";
      print "$StrDownloadClickLink<br /><br />";
      print "<a href='$modname&task=download2&displayframework=0".SID."&amp;path=".htmlentities(rawurlencode($path))."&amp;filename=".htmlentities(rawurlencode($filename))."&amp;action=download'>$StrDownloadClickHere <i>\"".htmlentities($filename)."\"</i></a>";
     print "<br /><br /></center>";
     print "</td>";
   print "</tr>";
  print "</table>";
}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

?>