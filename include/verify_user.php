<?php
function check_user_login($usr,$pwd)
{
global $dbi;
$exist=0;
  $qry="select login,password from user where login='".$usr."' and password='".md5($pwd)."'";
  $res=sql_query($qry,$dbi);
  if (sql_num_rows($res) > 0){
    $login=sql_result($res,0,0);
	$password=sql_result($res,0,1);
	if ($login==$usr and $password=$pwd)
	  $exist=1;
  }
  
  return ($exist);

}
?>