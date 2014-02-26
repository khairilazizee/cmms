<?php

if (!@include_once("admin/filemanager/incl/auth.inc.php"))
 include_once("admin/filemanager/incl/auth.inc.php");

if ($AllowEdit && isset($_GET['save']) && isset($_POST['filename']))
{
 $text = stripslashes($_POST['text']);

 if (!is_valid_name(stripslashes($_POST['filename'])))
  print "<font color='#CC0000'>$StrFileInvalidName</font>";
 else if ($fp = @fopen ($home_directory.$path.stripslashes($_POST['filename']), "wb"))
 {
  fwrite($fp, $text);
  fclose($fp);
  print "<font color='#009900'>$StrSaveFileSuccess</font>";
 }
 else
  print "<font color='#CC0000'>$StrSaveFileFail</font>";

}

else if ($AllowEdit && isset($_GET['filename']))
{
 print "<table class='index' width=90% cellpadding=0 cellspacing=0>";
  print "<tr>";
   print "<td class='iheadline' height=21>";
    print "<font class='iheadline'>&nbsp;$StrEditing \"".htmlentities($filename)."\"</font>";
   print "</td>";
   print "<td class='iheadline' align='right' height=21>";
    print "<font class='iheadline'><a href='$modname&amp;path=".htmlentities(rawurlencode($path))."'><img src='icon/back.gif' border=0 alt='$StrBack'></a></font>";
   print "</td>";
  print "</tr>";
  print "<tr>";
   print "<td valign='top' colspan=2>";

   print "<center><br />";

   if ($fp = @fopen($home_directory.$path.$filename, "rb"))
   {
    print "<form action='$modname&amp;output=edit&amp;save=true' method='post'>";

    print "<textarea cols=120 rows=20 name='text'>";
    print htmlentities(fread($fp, filesize($home_directory.$path.$filename)));
    fclose ($fp);
    print "</textarea>";

    print "<br /><br />";
    print "$StrFilename <input size=40 name='filename' value=\"".htmlentities($filename)."\">";

    print "<br /><br />";
   print "<input class='bigbutton' type='reset' value='$StrRestoreOriginal'>&nbsp;<input class='bigbutton' type='submit' value='$StrSaveAndExit'>";

   print "<input type='hidden' name='path' value=\"".htmlentities($path)."\">";
   print "</form>";
   }
   else
    print "<font color='#CC0000'>$StrErrorOpeningFile</font>";

   print "<br /><br /></center>";

   print "</td>";
  print "</tr>";
 print "</table>";
}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

?>