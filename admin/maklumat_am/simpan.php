<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;

 function susun($ordering,$old_ordering,$flg)
 {
  global $dbi;
  if ($flg==0)
    $query = "SELECT id,ordering FROM maklumat_am where ordering <= $ordering and ordering > $old_ordering order by ordering ";
  else
    $query = "SELECT id,ordering FROM maklumat_am where ordering >= $ordering and ordering < $old_ordering order by ordering ";
 //echo $query."<br>";
  $result = sql_query($query,$dbi);
  while ($data=sql_fetch_array($result,$dbi)) {
     $id=$data["id"];
	 $ord=$data["ordering"];
     if ($flg==0)
	    $ord--;
      else
	     $ord++;		
	  $query="update maklumat_am set ordering=". $ord ." where id=$id";

	 sql_query($query,$dbi);  
	 //echo $query."<br>";
  }
} //function susun  

  $id=$_REQUEST["id"];  
  $title=$_REQUEST["txt_title"];  
  $link=$_REQUEST["txt_link"];  
  $category=$_REQUEST["txt_kategori"];
  $pages=$_REQUEST["txt_halaman"];
  $target=$_REQUEST["txt_target"];  
  $ordering=$_REQUEST["txt_ordering"];  
  $old_ordering=intval($_REQUEST["txt_old_ordering"]);
  $dbtrans=$_REQUEST["dbtrans"]; 
   
  if ($dbtrans=="0") //insert
     $qry="insert into maklumat_am(title,link,category,pages,ordering)
	       values('$title','$link','$category','$pages',$ordering)"; 
  else if ($dbtrans=="1") { //update
    if ($old_ordering < $ordering)
       susun($ordering,$old_ordering,0);
	 else  if ($old_ordering > $ordering)
       susun($ordering,$old_ordering,1);
     $qry="update maklumat_am set title='$title',link='$link',category='$category',pages='$pages',ordering=$ordering where id=$id";
  }		   
  sql_query($qry,$dbi);
  //echo $qry;
  pageredirect("admin.php?module=maklumat_am");
  

?>


 
