<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
  $id=$_REQUEST["id"];  
  $category=$_REQUEST["txt_category"];  
  $author=$_REQUEST["txt_author"];  
  $title=$_REQUEST["txt_title"]; 
  $active=$_REQUEST["txt_active"]; 
  $content=$_REQUEST["txt_content"];
  if (!isset($active))
    $active=0;
  $ptj_only=$_REQUEST["txt_ptj_only"]; 
  if (!isset($ptj_only))
    $ptj_only=0;
  $dbtrans=$_REQUEST["dbtrans"];  
  $now = date("Y-m-d G:i:s");
  if ($dbtrans=="0") //insert
     $qry="insert into content_pages(title,category,content,ptj_only,active,author,createddate) 
	       values('$title','$category','$content','$ptj_only','$active','$author','$now')"; 
  else if ($dbtrans=="1") //update
     $qry="update content_pages set title='$title', category=$category, content='$content', ptj_only='$ptj_only',active='$active' where id=$id";
		   
  sql_query($qry,$dbi);
  //echo $qry;
  pageredirect("admin.php?module=adminhalaman");
  

?>


 
