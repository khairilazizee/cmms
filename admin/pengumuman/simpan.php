<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;

 function susun($ordering,$old_ordering,$flg)
 {
 
  global $dbi;

  if ($flg==0)
    $query = "SELECT id,ordering FROM announcement where ordering <= $ordering and ordering > $old_ordering order by ordering ";
  else
    $query = "SELECT id,ordering FROM announcement where ordering >= $ordering and ordering < $old_ordering order by ordering ";
 //echo $query."<br>";
  $result = sql_query($query,$dbi);
  while ($data=sql_fetch_array($result,$dbi)) {
     $id=$data["id"];
	 $ord=$data["ordering"];
     if ($flg==0)
	    $ord--;
      else
	     $ord++;		
	  $query="update announcement set ordering=". $ord ." where id=$id";

	 sql_query($query,$dbi);  
	 //echo $query."<br>";
  }
} //function susun  

  $id=$_REQUEST["id"];  
  $title=$_REQUEST["txt_title"];  
  $activity=$_REQUEST["txt_aktiviti"];  
  $active="1";  
  $startdate=$_REQUEST["txt_trkhmula"];
  if ($startdate=="")
    $startdate=date("Y-m-d");
  else 
    $startdate=substr($startdate,6,4)."-".substr($startdate,3,2)."-".substr($startdate,0,2);
		
  $enddate=$_REQUEST["txt_trkhakhir"];
  if ($enddate==""){
   $y=(int) substr($startdate,0,4);
   $y+=1;
   $enddate=$y.substr($startdate,4,6); 
  }	
  else 
    $enddate=substr($enddate,6,4)."-".substr($enddate,3,2)."-".substr($enddate,0,2);

  $ordering=$_REQUEST["txt_ordering"];  
  $old_ordering=intval($_REQUEST["txt_old_ordering"]);
  $dbtrans=$_REQUEST["dbtrans"]; 

  if ($dbtrans=="0") //insert
     $qry="insert into announcement(title,activity,active,startdate,enddate,ordering)
	       values('$title','$activity','$active','$startdate','$enddate',$ordering)"; 
  else if ($dbtrans=="1") {//update
      if ($old_ordering < $ordering)
       susun($ordering,$old_ordering,0);
	 else  if ($old_ordering > $ordering)
       susun($ordering,$old_ordering,1);
    $qry="update announcement set title='$title',activity='$activity',active='$active',startdate='$startdate',enddate='$enddate',ordering=$ordering where id=$id";
  }		   
  sql_query($qry,$dbi);
  //echo $qry;
  pageredirect("admin.php?module=pengumuman");
  

?>


 
