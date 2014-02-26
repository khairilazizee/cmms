<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_REQUEST["id"];  
  $title=$_REQUEST["txt_title"];  
  $kodfak=$_REQUEST["txt_kodfak"];  
  $dbtrans=$_REQUEST["dbtrans"];  
  if ($dbtrans=="0") //insert
     $qry="insert into content_category(title,fakulti)
	       values('$title','$kodfak')"; 
  else if ($dbtrans=="1") { //update
     $qry="update content_category set title='$title',fakulti='$kodfak' where id=$id";
	 $qry2="update content_pages set fakulti='$kodfak' where category=$id";
  }		   
  sql_query($qry,$dbi);
  if ($dbtrans=="1")
    sql_query($qry2,$dbi);
  //echo $qry;
  pageredirect("admin.php?module=adminkategori");
  

?>


 
