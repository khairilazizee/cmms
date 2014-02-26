<?php
include ("include/mysql.php");
include ("include/verify_user.php");
$content="";

function head()
{
 echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
 echo "<html>\n";
 echo "<head>\n";
 echo "<title>Admin PORTAL NKRA KPM</title>\n";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/html.css\" media=\"screen, projection, tv \" />\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/cssmenu.css\" media=\"screen, projection, tv \" />\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/admin.css\" media=\"screen, projection, tv \" />\n";
 echo "<script type=\"text/javascript\" src=\"jscript/clock.js\"></script>\n";
 echo "<script type=\"text/javascript\" src=\"jscript/imagebrowse.js\"></script>\n";
 echo "<style type=\"text/css\">\n";
 echo "#dhtmltooltip{\n";
 echo "position: absolute;\n";
 echo "left: -300px;\n";
 echo "width: 150px;\n";
 echo "border: 1px solid black;\n";
 echo "padding: 2px;\n";
 echo "background-color: lightyellow;\n";
 echo "visibility: hidden;\n";
 echo "z-index: 100;\n";
 echo "/*Remove below line to remove shadow. Below line should always appear last within this CSS*/\n";
 echo "filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);\n";
 echo "}\n";
 echo "#dhtmlpointer{\n";
 echo "position:absolute;\n";
 echo "left: -300px;\n";
 echo "z-index: 101;\n";
 echo "visibility: hidden;\n";
 echo "}\n";
 echo "</style>\n";
 echo "</head>\n";
 echo "<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" onLoad=\"clock()\" bgcolor=\"#FFFFFF\">\n";
 echo "<SCRIPT language=\"JavaScript\" src=\"style2.js\" type=\"text/javascript\"></SCRIPT>\n";
}

function checkform()
{
 foreach ($_REQUEST as $key => $val) {
  $val = mysql_escape_string($val);
 }
 return(0);
}


function adminmenu()
{
global $dbi;
global $usrrole;
global $username;

$admin=isadmin($username);

if ($admin<>1)
 return;
echo '<table bgcolor="#6699CC" width="150" border="0" cellspacing="0" cellpadding="1"><tr><td>';
echo '<table bgcolor="#6699CC" width="150" border="0" cellspacing="0" cellpadding="1">';
echo '<tr><td background="images/bg2.gif"><font color="#FFFFFF">&nbsp;Menu Admin</font></td></tr>';
$sql = "select id,title from menu where admin='1' and active='1' and type='menu'";

$result = sql_query($sql, $dbi);

$num1=sql_num_rows($result);
 
$idx1=0;
while ($idx1 < $num1){
  $sql2 = "select title,link from menu where admin='1' and parent=".sql_result($result,$idx1,"id")." and active='1' order by menupos";

  $result2 = sql_query($sql2, $dbi);
  $num=mysql_numrows($result2);
  $idx=0;
  while ($idx < $num) {
    echo '<tr><td width="150"><a href="'.sql_result($result2,$idx,"link").'" class="menuadmin" >&nbsp;'.sql_result($result2,$idx,"title").'</a></td></tr>';
	$idx++;  
  }
  $idx1++;
}
echo '<tr><td><br>
   <form name="frmlogout" action="admin.php" method="post">
   <input type="hidden" name="txtop" value="logout">
   <input type="submit" name="Logout" value="Logout">
   <br><br>
   </form>
</td></tr>';
echo '</table></td></tr></table>';

}


function adminmodule($modulename,$filename)
{
 global $username,$dbi;
 if (isadmin($username)==0){
   echo '<br><table width="70%" border="0" cellspacing="0" cellpadding="5">
         <tr><td><div align="center"><font color="#FF0000"><strong>CAPAIAN TIDAK DIBENARKAN</strong></font></div></td></tr>
        <tr> <td>Anda tidak dibenarkan memasuki aplikasi ini. Sila hubungi webmaster bagi mendapatkan kebenaran.</td></tr>
        </table>';
  }
  else {
 $sql="select title from modules where name='$modulename'";
 $res=sql_query($sql,$dbi);
 $numrow=sql_num_rows($res);
 if ($numrow > 0)
   list($title)=sql_fetch_row($res);  
  if ($modulename <> "adminpanel") 
    echo "<table align=\"center\" width=\"100%\"><tr><td><a href=\"admin.php\"><b>Muka Depan</b></a>&nbsp;<img src=\"images/arrow3.gif\">";
	if ($filename<>"index")
	  echo "&nbsp;<a href=\"admin.php?module=$modulename\"><b>$title</b></a>";
	else
	  echo "&nbsp;<b>$title</b>";
	echo "</td></tr></table>";
  if (file_exists("admin/".$modulename."/".$filename.".php")){
      include("admin/".$modulename."/".$filename.".php");
	  }
  } // grant==0	
}


function isadmin($username)
{
 global $dbi;

$query = "SELECT role FROM user where login='$username'";

 $result = sql_query($query,$dbi);
 $num_rows = sql_num_rows($result);

 if ($num_rows > 0)
    $role=sql_result($result,0,"role");
 if ($role==1)
    return(1);
 else
   return(0);		
}


function pageredirect($url)
{
 echo "<script language=\"javascript\">location.href=\"$url\"</script>";
}

function error_access_module($err)
{
  if ($err=="Inactive"){
    $errtitle="TIDAK AKTIF";
	$errmsg="Aplikasi ini belum diaktifkan lagi. Sila hubungi webmaster untuk mengaktifkan aplikasi ini.<br><br>";
 }	
  else if ($err=="AccessDenied"){
    $errtitle="TIDAK DIBENARKAN";
    $errmsg="Anda tidak dibenarkan memasuki aplikasi ini. Sila hubungi webmaster bagi mendapatkan kebenaran.<br><br>";
  }	
  else if ($err=="FileNotFound"){
    $errtitle="TIDAK WUJUD";
    $errmsg="Aplikasi tidak wujud di dalam EMiS Portal.";
  }	  
   echo "<br>";
   echo "<table width=\"70%\" bgcolor=\"#FF0000\" border=\"0\" cellspacing=\"0\" cellpadding=\"1\">";
   echo "<tr><td><table width=\"100%\" bgcolor=\"#FFFFFF\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
   echo "<tr><td background=\"images/bg_merah.gif\"><div align=\"center\"><font color=\"#FFFFFF\"><strong>$errtitle</strong></font></div></td></tr>";
   echo "<tr> <td bgcolor=\"#FFFFFF\">$errmsg</td></tr>";
   echo "</table></td></tr></table>";
}
?>
