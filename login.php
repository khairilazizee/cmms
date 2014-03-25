<?php
 session_start();
 include("mainfile.php");
 $username=$_REQUEST["username"];
 $user_password=$_REQUEST["user_password"];
 $user_verify=$_REQUEST["user_verify"];
 $islogin=$_REQUEST["islogin"];


        if (check_user_login($username,$user_password)==1 and $_SESSION["verification"]==$user_verify ){
        //if (check_user_login($username,$user_password)==1){
           $sql1="select * from user where login='$username' and password='".md5("$user_password")."'";
		   //die($sql1);
		   $res1=sql_query($sql1,$dbi);
		   if (sql_num_rows($res1) > 0){
		     $role=sql_result($res1,0,"role");
			 //$email=sql_result($res1,0,"email");
			 $negeri=sql_result($res1,0,"negeri");
			 $kodppd=sql_result($res1,0,"kodppd");
			 $kodsek=sql_result($res1,0,"kodsek");
			 $staffid = sql_result($res1,0,"login");
			 $staffagid = sql_result($res1,0,"ag_id");
			 
			 
		   }
		   if ($kodsek!="") {
		   		$query="SELECT KodJenisSekolah,KodJenisAsrama FROM tssekolah WHERE KodSekolah='$kodsek'";
		   		$query=sql_query($query,$dbi);
		   		$jenissek=sql_result($query,0,"KodJenisSekolah");
		   		$jenisasrama=sql_result($query,0,"KodJenisAsrama");

		   }
           $_SESSION["username"]=$username;	   
           $_SESSION["password"]=$user_password;
           $_SESSION["userrole"]=$role;
           $_SESSION['staffid'] = $staffid;
           $_SESSION['staffagid'] = $staffagid;
	  	   //$_SESSION["email"]=$email;	   
	  	   $_SESSION["negeri"]=$negeri;	
	  	   $_SESSION["kodppd"]=$kodppd;	
	  	   $_SESSION["kodsek"]=$kodsek;	
	       $_SESSION["login"]=1;
		   $_SESSION["jenissek"]=$jenissek;
		   $_SESSION["jenisasrama"]=$jenisasrama;
		   if($role==3)//JPN
		   		$_SESSION["select"]=" AND KodNegeriJPN='$negeri'";
		   elseif($role==4)//PPD
		   		$_SESSION["select"]=" AND KodPPD='$kodppd'";
		   session_write_close();	   
	       //header("Location: mainpage.php?module=LamanUtama");
     	   $now = date("Y-m-d H:i:s");

		   $qry="update `user` set `lastlogin`=`currentlogin` where `login`='$username'"; 		   
		   sql_query($qry,$dbi);

		   $qry="update `user` set `currentlogin`='$now' where `login`='$username'"; 		   
		   sql_query($qry,$dbi);

           if ($_SESSION["userrole"]=="5") {  //audit trail utk sekolah
                $yr=date("Y");
                $m=(int) date("m");
                $reschk=sql_query("select * from statistik_login where kodsekolah='$kodsek' and tahun='$yr'",$dbi);
                if (sql_num_rows($reschk)>0)
                     $sql="update statistik_login set bil_$m=bil_$m + 1 where kodsekolah='$kodsek' and tahun='$yr' ";
                else   
                     $sql="insert into statistik_login(kodsekolah,tahun,bil_$m) values('$kodsek','$yr',1)";
                sql_query($sql,$dbi);
           }     	   

     	   
		   if ($_SESSION["userrole"]==5) // user role SEKOLAH
		   		pageredirect("mainpage.php?module=LamanUtama");		   
		   else
		   		pageredirect("mainpage.php?module=LamanUtama");
        }
		else {
		   echo ".";
           $islogin=0;
           echo "<form name=\"frm1\" action=\"index.php\" method=\"post\">";
		   echo "<input type=\"hidden\" name=\"loginfail\" value=\"1\">";
		   echo "</form>";
           echo "<script language=\"javascript\">document.frm1.submit();</script>";		   
              //header("Location: index.php");	  
		}


function GetRole($fak)
{
global $dbi;


  $sql = "SELECT role FROM fak_role WHERE fak='$fak' and defaultrole=1";
  $result = sql_query($sql,$dbi);
  if (sql_num_rows($result)<>0){
     $datafak = sql_fetch_row($result);
	 $role=$datafak[0];
  }
  else
    $role=0;
return($role);
}

function GetUserFak($login)
{
global $dbi;

  $sql = "SELECT fakulti FROM user WHERE login='$login'";
  $result = sql_query($sql,$dbi);
  $fak = sql_result($result,0,"fakulti");

return($fak);
}

		
?>