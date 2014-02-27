<?php

include ("include/mysql.php");
include ("include/verify_user.php");
$content="";
//include ("include/useronline.php");


function head()
{
 echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
 echo "<html>\n";
 echo "<head>\n";
 echo "<title>PORTAL NKRA KPM</title>\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"chrometheme/chromestyle.css\" />";
 echo "<script type=\"text/javascript\" src=\"chromejs/chrome.js\"></script>";
 echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/html.css\" media=\"screen, projection, tv \" />\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/cssmenu.css\" media=\"screen, projection, tv \" />\n";
 echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/admin.css\" media=\"screen, projection, tv \" />\n";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/normalize.css\" media=\"screen, projection, tv \" />\n";
 echo " <LINK REL=\"SHORTCUT ICON\" HREF=\"http://localhost:90/umportal/favicon.ico\">\n"; 
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
 echo "<body leftmargin=\"0\" topmargin=\"0\" marginwidth=\"0\" marginheight=\"0\" bgcolor=\"#D5D5D5\">\n";
 echo "<SCRIPT language=\"JavaScript\" src=\"style2.js\" type=\"text/javascript\"></SCRIPT>\n";
}

function checkform()
{
 foreach ($_REQUEST as $key => $val) {
  $val = mysql_escape_string($val);
 }
 return(0);
}

function displayblock($blockpos,$islogin)
{
global $dbi;
global $home;
 
  if($islogin==0)
    $qry="select image,title,name from blocks where public='1' and active='1' and position='$blockpos' order by ordering";
  else {
       $qry="select image,title,name from blocks where active='1' and position='$blockpos' order by ordering";
  }	
  $resblock=sql_query($qry,$dbi);
  $block_num=sql_num_rows($resblock);
	
  for($block_idx=0;$block_idx<$block_num;$block_idx++){ 
    $title=sql_result($resblock,$block_idx,"title");
	$name=sql_result($resblock,$block_idx,"name");

    if (($islogin==1 and $name=="block-Login") or ($home==1 and $name=="block-cssMenu")){
      $content = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>\n';
	}  
	else{
     if ($blockpos=="center"){
		echo "<table width=\"98%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
  		echo "<tr>\n";
    	echo "	<td width=\"13\" height=\"11\"><img src=\"images/border/center1.gif\" width=\"13\" height=\"11\"></td>\n";
    	echo "	<td background=\"images/border/center_top.gif\"></td>\n";
    	echo "	<td width=\"13\"><img src=\"images/border/center2.gif\" width=\"13\" height=\"11\"></td>\n";
  		echo "</tr>\n";
  		echo "<tr>\n";
    	echo "	<td background=\"images/border/center_left.gif\"></td>\n";
    	echo "	<td>\n";
		
        //echo "<table  width=\"100%\" bgcolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>\n";
		}
	  else {
        echo "<table width=\"200\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr><td>\n";
	  	}
				
	  //Title untuk blok dan content -----------------------------------------------------------------------------------------
	  if ($title<>""){
	     if ($blockpos=="center"){
  	  	   //echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
		   //echo "<tr>\n";
		   //echo "<td width=\"21\"><img src=\"images/task_edit.gif\"></td><td><strong><font color=\"#D7441F\" size=\"4\">&nbsp;".$title."</font></strong>\n";
	       //echo "</td></tr>\n";
	       //echo "</table></td>\n";
      		
  	  	   //echo "</tr>\n";
 	       //echo "</table>";		
			
		 }  
	    else {
		   echo "<table width=\"202\" background=\"images/blockbg3.gif\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\n";
	       echo "<tr><td height=\"27\" align=\"center\" ><strong><font color=\"#ffffff\">".$title."</font></strong></td></tr>\n";
 	       echo "</table>\n";
		      }  //else

	   }  //if title
	  if (file_exists("blocks/".$name.".php"))
        include("blocks/".$name.".php");
	  else
	     $content="$name tidak wujud";
	  if ($blockpos <> "center") {	 
	  
	  //Content bagi setiap blok ---------------------------------------------------------------------------------------------
	  echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-left:solid 1px #ABBFE1;border-right:solid 1px #ABBFE1;border-bottom:solid 1px #ABBFE1;\">\n
            <tr><td width=\"200\" bgcolor=\"#EEEEEE\" height=\"100%\">\n";
	  echo $content;
	  }

	     if ($blockpos=="center"){

  	  	    echo "<table width=\"100%\" bgcolor=\"#FFFFFF\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
       		echo "<tr>\n";
      		echo "<td>".$content."</td>\n";
		}
	  
	  if ($blockpos <> "center"){
	        echo "</td></tr></table>";
            echo "<table height=\"8\"width=\"200\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
            echo "<tr><td></td></tr></table>\n";

      }
	  
	  
	  if ($blockpos == "center"){
  			
	  		echo "</td></tr></table>\n";
		    
			echo "	</td>\n";
    	    echo "	<td background=\"images/border/center_right.gif\"></td>\n";
  		    echo "	</tr>\n";
			echo "<tr>\n";
    		echo "<td height=\"11\"><img src=\"images/border/center3.gif\" width=\"13\" height=\"11\"></td>\n";
    		echo "<td background=\"images/border/center_bottom.gif\"></td>\n";
    		echo "<td><img src=\"images/border/center4.gif\" width=\"13\" height=\"11\"></td>\n";
  			echo "</tr>\n";
			//echo "<tr><td height=\"5\"></td><td></td><td></td></tr>\n";
			echo "</table>\n";
            echo "<table height=\"5\"width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
            echo "<tr><td></td></tr></table>\n";
	  }
	  else {
	  	  echo "</td></tr></table>\n";
	  }	

	//}
  }
}
}


function displaymodule($modulename,$filename,$frame)
{
 global $dbi;
 $role=$_SESSION["userrole"];
 $papar=0;
 $show=0;
 checkform();

 $sql="select title,displaytitle,registered from modules where name='$modulename'";
 $res=sql_query($sql,$dbi);
 $numrow=sql_num_rows($res);
 if ($numrow > 0)

   list($title,$displaytitle,$register)=sql_fetch_row($res);
   //skrin yang perlukan cas login
   if ($register=="1" and !isset($_SESSION["username"])){
     pageredirect("mainpage.php?module=Login&r=$modulename");
     $_SESSION["modulename"]=$modulename;
   }	 
   if ($frame<>0){
   if ($modulename=="News")
     $show=$_GET["show"];
	 
   if ($modulename=="Maklumat"){
     $kategori=$_GET["kategori"];
	 $papar=$_GET["papar"];
     $sql_title="select title from content_category where id='$kategori'";
     $res_title=sql_query($sql_title,$dbi);
     $numrow_title=sql_num_rows($res_title);  
	 if ($numrow_title > 0)
	   $title=sql_result($res_title,"title",0);	 
   }

  } //$frame <> 0
   $sql="select name from modules where name='$modulename' and active='1'";
// echo $sql;
 $res=sql_query($sql,$dbi);
 $active=sql_num_rows($res);

 if ($active==0)
    error_access_module("Inactive");
 else {	
    $sql="select name from modules where public='1' and name='$modulename'";
    $res=sql_query($sql,$dbi);
    $grant=sql_num_rows($res);
    if ($grant==0){
       $sql="select name from modules,module_access where modules.id=module_id and role=$role and name='$modulename'";
       $res=sql_query($sql,$dbi);
       $grant=sql_num_rows($res);
    } // grant==0
    if ($grant==0)
      error_access_module("AccessDenied");
    else {
      if (file_exists("modules/".$modulename."/".$filename.".php"))
         include("modules/".$modulename."/".$filename.".php");
	  else
	     error_access_module("FileNotFound");	 
    } // grant==0	
  } // $active==0	
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

function getfak($usr)
{
global $dbi;
   $query="select fakulti from user where login='$usr'";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	if ($num_rows > 0)
      $fak=sql_result($result,0,"fakulti");
	else
	  $fak="";  
return($fak);
} 

function pageredirect($url)
{
 echo "<script language=\"javascript\">location.href=\"$url\"</script>";
}

function error_access_module($err)
{
  if ($err=="Inactive"){
    $errtitle="TIDAK AKTIF";
	$errmsg="Aplikasi ini belum diaktifkan lagi. Sila hubungi pentadbir untuk mengaktifkan aplikasi ini.<br><br>";
 }	
  else if ($err=="AccessDenied"){
    $errtitle="TIDAK DIBENARKAN";
    $errmsg="Anda tidak dibenarkan memasuki aplikasi ini. Sila hubungi pentadbir bagi mendapatkan kebenaran.<br><br>";
  }	
  else if ($err=="FileNotFound"){
    $errtitle="TIDAK WUJUD";
    $errmsg="Aplikasi tidak wujud.";
  }	  
   echo "<br>";
   echo "<br>";
   echo "<table style=\"border:solid 1px #DD0000\" width=\"400\" cellspacing=\"0\" cellpadding=\"2\">";
   echo "<tr bgcolor=\"#DD0000\"><td colspan=\"2\"><strong><font color=\"#EEEEEE\"> :: Perhatian</font></strong></td></tr>";
   echo "<tr height=\"50\">";
   echo "<td align=\"center\" width=\"50\" bgcolor=\"#EEEEEE\" ><img src=\"images/warning.gif\"></td>";
   echo "<td bgcolor=\"#EEEEEE\" valign=\"center\"><strong><font color=\"#FF0000\">$errmsg</font></strong></td>";
   echo "</tr>";
   echo "</table>";

}
?>
