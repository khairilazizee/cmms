<?php
global $modname;
$modname="admin.php?module=filemanager";
define("VERSION", "0.2.3");

include("admin/filemanager/conf/config.inc.php");
include("admin/filemanager/incl/functions.inc.php");
include("admin/filemanager/lang/$language.inc.php");
include("admin/filemanager/incl/header.inc.php");
include("admin/filemanager/incl/html.header.inc.php");


/* register directory/filename */

if (isset($_GET['directory_name']))
{
    $directory_name = basename(stripslashes($_GET['directory_name']))."/";
}
if (isset($_GET['filename']))
{
    $filename = basename(stripslashes($_GET['filename']));
}
if (isset($_POST['directory_name']))
{
    $directory_name = basename(stripslashes($_POST['directory_name']))."/";
}
if (isset($_POST['filename']))
{
    $filename = basename(stripslashes($_POST['filename']));
}
if (isset($_POST['new_directory_name']))
{
    $new_directory_name = basename(stripslashes($_POST['new_directory_name']))."/";
}
if (isset($_POST['new_filename']))
{
    $new_filename = basename(stripslashes($_POST['new_filename']));
}


/* validate path */

if (isset($_GET['path']))
    $path = validate_path($_GET['path']);
else if (isset($_POST['path']))
    $path = validate_path($_POST['path']);

if (!isset($path) || $path == "./" || $path == ".\\" || $path == "/" || $path == "\\")
    $path = false;


//if (isset($_SESSION['session_username']) && $_SESSION['session_username'] == $username && isset($_SESSION['session_password']) && $_SESSION['session_password'] == md5($password) || !$phpfm_auth)
//{
    if (!(@opendir($home_directory.$path)) || (substr($home_directory, -1) != "/"))
    {
        print "<table class='output' width=95% cellpadding=0 cellspacing=0>";
        print "<tr><td align='center'>";

        if (!(@opendir($home_directory)))
            print "<font color='#CC0000'>$StrInvalidHomeFolder</font>";
        else if (!(@opendir($home_directory.$path)))
            print "<font color='#CC0000'>$StrInvalidPath</font>";
        if (substr($home_directory, -1) != "/")
            print "&nbsp;<font color='#CC0000'>$StrMissingTrailingSlash</font>";

        print "</td></tr>";
    print "</table><br />";
    }

    if (isset($_GET['action']) && is_file("admin/filemanager/incl/".$_GET['action'].".inc.php") && is_valid_name($_GET['action']))
        include("admin/filemanager/incl/".basename($_GET['action']).".inc.php");
    else if (isset($_GET['output']) && is_file("admin/filemanager/incl/".$_GET['output'].".inc.php") && is_valid_name($_GET['output']))
    {
        print "<table class='output' width=95% cellpadding=0 cellspacing=0>";
            print "<tr><td align='center'>";
                include("admin/filemanager/incl/".basename($_GET['output']).".inc.php");
            print "</td></tr>";
        print "</table><br />";

        include("admin/filemanager/incl/filebrowser.inc.php");
    }
    else
    {
        include("admin/filemanager/incl/filebrowser.inc.php");
    }
//}
//else
//{
//    include("admin/filemanager/incl/login.inc.php");
//}

//include("admin/filemanager/incl/footer.inc.php");

?>