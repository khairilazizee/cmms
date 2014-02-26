<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_REQUEST["id"];
  $title=$_REQUEST["txt_title"];  
  $name=$_REQUEST["txt_name"];  
  $image=$_REQUEST["txt_image"];  

  $public=$_REQUEST["txt_public"];  
  if ($public=="")
     $public=0;

  $admin=$_REQUEST["txt_admin"];  
  if ($admin=="")
     $admin=0;
	 
  $active=$_REQUEST["txt_active"];  
  if ($active=="")
     $active=0;

  $ordering=$_REQUEST["txt_ordering"];  
  $dbtrans=$_REQUEST["dbtrans"];  
  if ($dbtrans=="0") //insert
     $qry="insert into modules(title,name,image,public,active,admin,ordering)
	       values('$title','$name','$image','$public','1','$admin','$ordering')"; 
  else //update
     $qry="update modules set title='$title',image='$image',public='$public',active='$active',ordering='$ordering' where id='$id'";
		   
  sql_query($qry,$dbi);
  pageredirect("admin.php?module=module");

?>


 
