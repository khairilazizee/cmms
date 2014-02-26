<?php
global $dbi, $username;
$fulllink = $home_directory.$path;

if (!@include_once("admin/filemanager/incl/auth.inc.php"))
 include_once("admin/filemanager/incl/auth.inc.php");

if ($AllowUpload && isset($_GET['upload']))
{
 print "<table cellspacing=0 cellpadding=0 class='upload'>";

 if (!isset($_FILES['userfile']))
  // maximum post size reached
  print $StrUploadFailPost;
 else
 {
  for($i=0;$i<1;$i++)
  {
   $_FILES['userfile']['name'][$i] = stripslashes($_FILES['userfile']['name'][$i]);
   if (@move_uploaded_file($_FILES['userfile']['tmp_name'][$i], realpath($home_directory.$path)."/".$_FILES['userfile']['name'][$i]))
    {
	print "<tr><td width='250'>$StrUploading ".$_FILES['userfile']['name'][$i]."</td><td width='50' align='center'>[<font color='#009900'>$StrUploadSuccess</font>]</td></tr>";
	//print $fulllink;
	//die;
	}
   else if ($_FILES['userfile']['name'][$i])
    print "<tr><td width='250'>$StrUploading ".$_FILES['userfile']['name'][$i]."</td><td width='50' align='center'>[<font color='#CC0000'>$StrUploadFail</font>]</td></tr>";
  }
 }
 print "</table>";
}

else if ($AllowUpload)
{
 print "<table class='index' width=95% cellpadding=0 cellspacing=0 bgcolor=\"FFFFFF\">";
  print "<tr bgcolor='999999'>";
   print "<td class='iheadline' height=21 >";
    print "<font class='iheadline'>&nbsp;$StrUploadFilesTo \"/".htmlentities($path)."\"</font>";
   print "</td>";
   print "<td class='iheadline' align='right' height=21>";
    print "<font class='iheadline'><a href='$modname&amp;path=".htmlentities(rawurlencode($path))."'><img src='admin/filemanager/icon/back.gif' border=0 alt='$StrBack'></a></font>";
   print "</td>";
  print "</tr>";
  print "<tr>";
   print "<td valign='top' colspan=2>";

    print "<center><br />";

    //print "$StrUploadQuestion mmm<br />";
    //print "Sila pilih dokumen <br />";
    print "<form action='$modname&amp;output=upload&amp;upload=true' method='post' enctype='multipart/form-data'>";

    print "<table bgcolor=\"FFCCFF\" width=60%>";
    print "<tr><td>";
    print "<table class='upload' align=\"center\">";
     //print "<tr><td>$StrFirstFile</td><td><input type='file' name='userfile[]' size=50></td></tr>";
     print "<tr><td>Sila pilih dokumen</td><td> : <input type='file' name='userfile[]' size=50></td></tr>";
    print "</table>";
    print "</td></tr>";
    print "</table>";

    print "<input class='bigbutton' type='submit' value='$StrUpload'>";
    print "<input type='hidden' name=path value=\"".htmlentities($path)."\">";
    print "</form>";

    print "<br /><br /></center>";

   print "</td>";
  print "</tr>";
 print "</table>";
}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

?>