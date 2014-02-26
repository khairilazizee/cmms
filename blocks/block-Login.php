<?php
global $module;
mt_srand ((double)microtime()*1000000);
$maxran = 1000000;
$random_num = mt_rand(0, $maxran);
if (isset($_REQUEST["loginfail"]))
  $loginfail=$_REQUEST["loginfail"];
else  
  $loginfail=0;

$content = '<table width="100%" bgcolor="#E8EFFC" border="0" cellspacing="0" cellpadding="2"><tr><td>
            <form name="frmlogin" action="login.php" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">';

$content .= '<tr><td colspan=\"3\">&nbsp;<td></tr>
			<tr> 
                <td width="99"><font color="#000000">&nbsp;&nbsp;LoginID</font></td>
                <td width="150"><input type="text" name="username" size="15" maxlength="25"></td>
              </tr>
              <tr> 
                <td><font color="#000000">&nbsp;&nbsp;Katalaluan</font></td>
                <td><input type="password" name="user_password" size="15" maxlength="25"></td>
              </tr>';
			  
$content .= ' <input type="hidden" name="op" value="login">
              <tr> 
                <td height="22">&nbsp;</td>
                <td><input name="submit" type="submit" value="Login"></td>
              </tr>';
if (isset($module)){
 if ($module=="frontpage")
     $content .= '<tr><td align="center" colspan="2"><font color="#FF0000">Pengguna tidak sah !</td></tr>';
}
			  
$content .='</table>';
$content .= '<table width="100%" bgcolor="#E8EFFC" border="0" cellspacing="5" cellpadding="0">';
if ($loginfail==1)   
  $content .= '<tr><td align="center"><font color="#FF0000"><b>Pengguna tidak sah !<b></font></td></tr>';

$content .= '</table></form></td></tr>';
			  //<tr><td align="center" colspan="3"><a href="mainpage.php?module=Register"><strong>Daftar LoginID Baru</strong></a><td></tr>
			  //<tr><td colspan=\"3\">&nbsp;<td></tr>';

$content.='</table>';
?>
