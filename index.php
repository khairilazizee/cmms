<?php 
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT"); // Date in the past
session_start();
include_once("mainfile.php");
global $dbi;
head();
if (!$_SESSION["start"]){ 
   $_SESSION["start"]=1;
   sql_query("update visitor set total=total+1",$dbi);
}

define( '_UMPORTAL', 1 );
$home=1;
?>
</font> 
<table align="center" width="1004" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="8" height="8"><img src="images/border/b1.gif" width="8" height="8"></td>
    <td background="images/border/bg_top.gif"></td>
    <td width="14"><img src="images/border/b2.gif" width="14" height="8"></td>
  </tr>
  <tr> 
    <td background="images/border/bg_left.gif">&nbsp;</td>
    <td bgcolor="#DBE6F4">
	<table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><font face="Verdana, Arial, Helvetica, sans-serif"> 
            <?php include("header.php"); ?>
            </font></td>
        </tr>
        <tr> 
          <td> 
            <?php
	       $islogin=(int) $_SESSION["login"]; 
	  ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="1">
              <tr> 
                <td valign="top" align="center" width="200"> 
                  <?php
		    //if ($islogin){
			//   echo "<font size=1><font color='#B90220'>".$_SESSION["nama"]."<br><a href=\"logout.php\">Logout</a></font></font><br>";
			//}   
		    displayblock("left",$islogin);
			//$res_visitor = sql_query("SELECT total FROM visitor", $dbi);
			//$data_visitor = sql_fetch_row($res_visitor, $dbi);
			//$count_visitor=$data_visitor[0];
			//echo "<font size=1>&nbsp;Jumlah Pengunjung: <font color='#B90220'><u>".$count_visitor."</u></font></font>";
		  ?>
                </td>
                <?php echo '<td valign="top" align="center" >';
	            displayblock('center',$islogin);	 
	            echo '</td>';

               echo '<td valign="top" align="center" width="200">';
	           displayblock("right",$islogin);
	           echo '</td>';
	     ?> </tr>
            </table></td>
        </tr>
        <?php include("footer.php"); ?>
      </table>
	  </td>
    <td background="images/border/bg_right.gif">&nbsp;</td>
  </tr>
  <tr> 
    <td height="8"><img src="images/border/b3.gif" width="8" height="8"></td>
    <td background="images/border/bg_bottom.gif"></td>
    <td><img src="images/border/b4.gif" width="14" height="8"></td>
  </tr>
</table>
