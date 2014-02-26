<?php

list($seconds, $microseconds) = explode(" ", microtime());
$time_start = $seconds + $microseconds;

//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//header("Cache-Control: no-store, no-cache, must-revalidate");
//header("Cache-Control: post-check=0, pre-check=0", false);
//header("Pragma: no-cache");
//header("Content-Type: text/html; charset=$StrLanguageCharset");

if (isset($session_save_path)) session_save_path($session_save_path);
ini_set('magic_quotes_gpc', 1);
ini_set('session.use_trans_sid', 0);
error_reporting(E_ALL);
clearstatcache();
//session_start();

//$modname = "?".SID."&amp;";

/*if (isset($_POST['input_username']) && isset($_POST['input_password']) && $_POST['input_username'] == $username && md5($_POST['input_password']) == md5($password))
{
    $_SESSION['session_username'] = $_POST['input_username'];
    $_SESSION['session_password'] = md5($_POST['input_password']);
}
else if (isset($_GET['action']) && $_GET['action'] == "logout")
{
    $_SESSION = array();
    session_destroy();
    setcookie(session_name(),"",0,"/");
}
*/
?>