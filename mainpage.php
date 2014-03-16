<?php 
define( '_UMPORTAL', 1 );

include_once("mainfile.php");

$home=0;
//$hlcolor= "#AACCF2";
//$ncolor="#C0E1FA";	
//$altcolor="#57C9DD";

$hlcolor= "#EEEEEE";
$ncolor="#FFFFFF";	


session_start();
if (!isset($username))
  $username= $_SESSION["username"];
if (!isset($user_password))  
  $user_password=$_SESSION["password"];

$islogin=$_SESSION["login"];	

if (!isset($usrrole))  
  $usrrole=$_SESSION["userrole"];
$faccode=getfak($username);
$displayframework=$_REQUEST["displayframework"];
if (!isset($displayframework))
  $displayframework=1;
  $module=$_REQUEST["module"];
  if (isset($_REQUEST["task"]))
	 $task=$_REQUEST["task"];
  else
	 $task="index"; 
  if ($_GET["m_id"]<>"")
    $menu_id=(int) $_GET["m_id"];

  if ($_GET["s_id"]<>"")
    $submenu_id=(int) $_GET["s_id"];

  $modname="mainpage.php?module=$module&m_id=$menu_id&s_id=$submenu_id";

if ($displayframework==0){  //do not display framework
   echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
   echo "<html>\n";
   echo "<head>\n";
   echo "<title>PORTAL CMMS JPM</title>\n";
   echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
   echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/html.css\" media=\"print, screen, projection, tv \" />\n";
   echo "</head>\n";
   echo "<body>";
   echo "<div class='container-displayframework'>";
   displaymodule($module,$task,0);
   echo "</div>";
   echo "</body></html>"; //echo '</td>';
} 
else
{ 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT"); // Date in the past
head();


$colwidth=824;	
  $date = date("d-m-Y");
 $time = date("h:i:s");
?>
<table align="center" width="1004" border="0" cellpadding="0" cellspacing="0">

  <tr> 
    <td bgcolor="#DBE6F4">
<table align="center" width="100%" border="0"  cellspacing="0" cellpadding="0">
    <tr >
    <td class="CenterWrap"><?php include("header.php"); ?></td>
  </tr>
  <tr>
  	<td background="images/header_sub.jpg">
		<table width="100%" border="0">
			<tr>	
				<td width="200">&nbsp;</td>
				<td><center><font color="#FFFFFF"><strong>Selamat Datang</strong></center></font></td>
  				<td align="right" width="200"><font color="#FFFFFF"><? echo " $date / $time"; ?></font></td>
			</tr>
		</table>
	</td>
  
  </tr>
  <tr><td>
  <center><br>
  <table width="98%" border="0" cellpadding="1" cellspacing="0" >
  <tr>
    <td valign="top"  align="center" width="200">
	<?php 
		    //if ($islogin)
			//   	echo "<font size=1><font color='#B90220'>".$_SESSION["nama"]."<br><a href=\"logout.php\">Logout</a></font></font><br>";
	        	displayblock("left",$islogin);
				//$res_visitor = sql_query("SELECT total FROM visitor", $dbi);
				//$data_visitor = sql_fetch_row($res_visitor, $dbi);
				//$count_visitor=$data_visitor[0];
				//echo "<font size=1>&nbsp;Jumlah Pengunjung: <font color='#B90220'><u>".$count_visitor."</u></font></font>";
    ?>
	</td>
    <?php 
		 echo "<td valign=\"top\" align=\"center\" width=\"$width\">\n";
		//Border start --------------------------------
		 echo "<table width=\"98%\" bgcolor=\"#FFFFFF\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		 echo "<tr>\n";
		 echo "<td width=\"13\" height=\"11\"><img src=\"images/border/center1.gif\" width=\"13\" height=\"11\"></td>\n";
		 echo "<td background=\"images/border/center_top.gif\"></td>\n";
		 echo "<td width=\"13\"><img src=\"images/border/center2.gif\" width=\"13\" height=\"11\"></td>\n";
		 echo "</tr>\n";
		 echo "<tr>\n";
 		 echo "<td background=\"images/border/center_left.gif\"></td>\n";
		 echo "<td>\n";
         //start display modules trail
        /*$sqlt="select title from modules where name='".$_GET["module"]."'";
        $rest=sql_query($sqlt,$dbi);
        $datat=sql_fetch_array($rest);
        $module_title=$datat[0];
   
         echo "<table><tr><td><a href=\"\">Home</a></td><td>&nbsp;<img src=\"images/arrow3.gif\">&nbsp;</td><td><a href=\"$modname\">$module_title</a></td></tr></table>";
         */   
      //end display modules trail
	     displaymodule($module,$task,1);
		 echo "</td>\n";
		 echo "<td background=\"images/border/center_right.gif\"></td>\n";
         echo "</tr>\n";
		 echo "<tr>\n";
		 echo "<td height=\"11\"><img src=\"images/border/center3.gif\" width=\"13\" height=\"11\"></td>\n";
		 echo "<td background=\"images/border/center_bottom.gif\"></td>\n";
		 echo "<td><img src=\"images/border/center4.gif\" width=\"13\" height=\"11\"></td>\n";
		 echo "</tr>\n";
		 echo "</table>\n";
		 //End border -----------------------------------
	     echo '</td>';
	?> 
  </tr>
</table>
</center><br>
	</td>
  </tr>
  <tr>
  <td>
  <?php include("footer.php"); ?>
	</td></tr>
</table>	
  </tr>

</table>
<?php
}
?>