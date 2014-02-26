<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );


 global $dbi;
  $id=$_REQUEST["id"];  
  $author=$_REQUEST["txt_author"];  
  $title=$_REQUEST["txt_title"];
  $header=$_REQUEST["txt_header"];
  $content=$_REQUEST["txt_content"];
  $public=$_REQUEST["txt_public"];
  if (!isset($public))
    $public=0;
  $startdate=$_REQUEST["txt_startdate"];
  if ($startdate=="")
    $startdate=date("Y-m-d");
  else 
   $startdate=substr($startdate,6,4)."-".substr($startdate,3,2)."-".substr($startdate,0,2);
  $enddate=$_REQUEST["txt_enddate"];
  if ($enddate==""){
   $y=(int) substr($startdate,0,4);
   $y+=1;
   $enddate=$y.substr($startdate,4,6); 
  }
  else 
   $enddate=substr($enddate,6,4)."-".substr($enddate,3,2)."-".substr($enddate,0,2);
 $active=$_REQUEST["txt_active"];
  
  if (!isset($active))
    $active=0;
  $now = date("Y-m-d G:i:s");	
  $dbtrans=$_REQUEST["dbtrans"];  
  if ($dbtrans=="0") //insert
     $qry="insert into news(author,title,datecreated,header,content,public,startdate,enddate,frontpage,active)
	       values('$author','$title','$now','$header','$content','$public','$startdate','$enddate',0,'$active')"; 
  else if ($dbtrans=="1") //update
     $qry="update news set author='$author',title='$title',header='$header',content='$content',public='$public',startdate='$startdate',enddate='$enddate',active='$active' where id=$id";
		   
  sql_query($qry,$dbi);
  //echo $qry;
  pageredirect("admin.php?module=adminnews");
  

?>


 
