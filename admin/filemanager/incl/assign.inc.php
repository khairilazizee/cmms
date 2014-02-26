<?php
global $dbi, $username;
global $directories;
$fulllink = $home_directory.$path."doc/";

if (!@include_once("admin/filemanager/incl/auth.inc.php"))
 include_once("admin/filemanager/incl/auth.inc.php");

if ($AllowUpload && isset($_GET['assign']))
{
 $counter=$_POST["txtcounter"];

 print "<table cellspacing=0 cellpadding=0 class='upload'>";
 for ($folderidx=1;$folderidx<=$counter;$folderidx++){
   $kodfak=$_POST["txtptj$folderidx"];
   $folderptj=$_POST["txtfolder$folderidx"];
   if ($folderptj <> ""){
      $res=sql_query("select fakulti from folderptj where fakulti='$kodfak'",$dbi);
	  if (sql_num_rows($res) > 0)
	     sql_query("update folderptj set folder='$folderptj' where fakulti='$kodfak'",$dbi);
      else
	     sql_query("insert folderptj values ('$kodfak','$folderptj')",$dbi);
   }
   //print "<tr><td>$kodfak</td><td>$folderptj</td></tr>";
 } 
 print "<tr><td  width='250'><font color='#0000CC'>Direktori 'Home' Ptj telah disimpan.</font></td></tr>";
 print "</table>";
}

else if ($AllowUpload)
{
   if ($open = @opendir($fulllink))
  {
   for($i=0;($directory = readdir($open)) != FALSE;$i++)
    if (is_dir($fulllink.$directory) && $directory != "." && $directory != ".." )
      $directories[$i] = array($directory,$directory);
   closedir($open);

   if (isset($directories))
   {
    sort($directories);
    reset($directories);
   }
  }

 print "<table class='index' width=95% cellpadding=0 cellspacing=0 bgcolor=\"FFFFFF\">";
  print "<tr bgcolor='999999'>";
   print "<td class='iheadline' height=21 >";
    print "<font class='iheadline'>&nbsp;Direktori 'Home'  PTj ".htmlentities($path)." bagi kegunaan Admin PTj memuat naik dokumen</font>";
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
    print "<form action='$modname&amp;output=assign&amp;assign=true' method='post'>";

    print "<table cellpadding=0 cellspacing=0 bgcolor=\"#999999\" width=60%>";
	print "<tr bgcolor=\"#3399CC\"><td width=\"5%\"><b>Bil.</b></td><td width=\"60%\"><b>PTj</b></td><td width=\"35%\"><b>Direktori 'Home'</b></td></tr>";
    print "<tr><td colspan=\"3\">";
    print "<table  cellpadding=2 bgcolor=\"#3399CC\" width=\"100%\" align=\"center\">";
	$res=sql_query("select kod_fak,nama_fak from fak order by nama_fak",$dbi);
	$cnt=0;
    while($data=sql_fetch_array($res,$dbi)){ 
	  $cnt++;
	  print "<tr bgcolor=\"#FFFFFF\"><td width=\"5%\">".$cnt."</td>";
      print "<td width=\"60%\"><input type=\"hidden\" name=\"txtptj$cnt\" size=\"5\" value=\"".$data[0]."\">".$data[1]."</td>";
	  print "<td>";
	  //print "<select name=\"tt\"><option>pilih</option></select>";
	  createlist($cnt,$data[0]);
	  print "</td></tr>\n";
	}
    print "</table>";
    print "</td></tr>";
    print "</table>";
    print "<br>";
    print "<input class='bigbutton' type='submit' value='Simpan'>";
	print "<input type=\"hidden\" name=\"txtcounter\" value=\"$cnt\">";
    print "<input type='hidden' name=path value=\"".htmlentities($path)."\">";
    print "</form>";

    print "<br /><br /></center>";

   print "</td>";
  print "</tr>";
 print "</table>";

}
else
 print "<font color='#CC0000'>$StrAccessDenied</font>";

function createlist($cnt,$kodfak)
{
  global $directories;
  global $dbi;
  $res=sql_query("select folder from folderptj where fakulti='$kodfak'",$dbi);
  if (sql_num_rows($res) > 0)
    $folder=sql_fetch_array($res);
  else
    $folder="";
	
  print "<select name=\"txtfolder$cnt\">";
  if ($folder=="")
      print "<option value=\"\" selected>-- Pilih Direktori --</option>";
  else
      print "<option value=\"\">-- Pilih Direktori --</option>";
  
  for($idx=0;$idx<count($directories);$idx++){
     if ($folder[0]==$directories[$idx][0])
        print "<option value=\"".$directories[$idx][0]."\" selected>".$directories[$idx][0]."</option>";
	 else
        print "<option value=\"".$directories[$idx][0]."\">".$directories[$idx][0]."</option>";
  }	 
  print "</select>"; 
}	
?>