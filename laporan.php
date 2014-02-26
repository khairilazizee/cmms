<?php
session_start();
include ("include/mysql.php");

$module=$_GET["module"];
$laporan=$_GET["laporan"];

include ("modules/$module/$laporan.php");
?>