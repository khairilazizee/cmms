<?php
global $dbi;

	$sql = "select nama from user where login='".$_SESSION["username"]."'";
	$result = sql_query($sql, $dbi);
	if ($data1=sql_fetch_array($result)){
	 $nama=$data1["nama"];
	}
  $content = '<table width="100%" bgcolor="#E8EFFC" border="0" cellspacing="0" cellpadding="0">';
  $content .= '<tr><td align="center" colSpan="2">Anda login sebagai <br>';
  if ($_SESSION["userrole"]=="5")
    $content .=  "<strong>$nama</strong>";
  else
    $content .=  "<a href=\"mainpage.php?module=Profil\">$nama</a>";
  $content .= '</td></tr>';
  $content .= '<tr><td align="center" weight="50%">';
  $content .= '<br><a href="mainpage.php?module=LamanUtama">';
  $content .= '<img src="images/home.png"><br><strong><font color="#2A4089">HOME</font></strong></a><br><br>';
  $content .= '</td><td align="center" weight="50%"><br>';
  $content .= '<a href="logout.php"><img src="images/logout.png"><br><strong><font color="#FF0000">LOGOUT</font></strong></a><br><br></td></tr>';
  $content .= '</table>';

?>
