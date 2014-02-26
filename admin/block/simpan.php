<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 
 function changestatus($name,$active)
 {
   global $dbi;
   if ($name=="block-Login")
      $block="block-CASLogin";
   else  
      $block="block-Login";
   if ($active==1)
     $flg=0;
   else
     $flg=1;
   sql_query("update blocks set active='$flg' where name='$block'",$dbi);	 
 }
 
 function susun($ordering,$old_ordering,$flg)
 {
 
  global $dbi;
  if ($flg==0)
    $query = "SELECT id,ordering FROM blocks where ordering <= $ordering and ordering > $old_ordering order by ordering ";
  else
    $query = "SELECT id,ordering FROM blocks where ordering >= $ordering and ordering < $old_ordering order by ordering ";
 //echo $query."<br>";
  $result = sql_query($query,$dbi);
  while ($data=sql_fetch_array($result,$dbi)) {
     $id=$data["id"];
	 $ord=$data["ordering"];
     if ($flg==0)
	    $ord--;
      else
	     $ord++;		
	  $query="update blocks set ordering=". $ord ." where id=$id";

	 sql_query($query,$dbi);  
	 //echo $query."<br>";
  }
} //function susun  

  $id=$_REQUEST["id"];  
  $title=$_REQUEST["txt_title"];
  $position=$_REQUEST["txt_position"];
  $name=$_REQUEST["txt_name"];
  $image=$_REQUEST["txt_image"];
  $public=$_REQUEST["txt_public"];
  if($public=="")
     $public=0;
  $active=$_REQUEST["txt_active"];
  if ($active=="")
    $active=0;
  $ordering=intval($_REQUEST["txt_ordering"]);
  $old_ordering=intval($_REQUEST["txt_old_ordering"]);
  $dbtrans=$_REQUEST["dbtrans"];
  
  if ($dbtrans=="0") //insert
     $qry="insert into  blocks(title,position,name,image,public,active,ordering) values('$title','$position','$name','$image',$public,$active,$ordering)";
  elseif ($dbtrans=="1") {//update
     if ($old_ordering < $ordering)
       susun($ordering,$old_ordering,0);
	 else if ($old_ordering > $ordering)
       susun($ordering,$old_ordering,1);
     $qry="update blocks set title='$title',position='$position',name='$name',image='$image',public=$public,active=$active,ordering=$ordering where id=$id";
  }	 
		   
  sql_query($qry,$dbi);
  if ($name=="block-Login" or $name=="block-CASLogin")
    changestatus($name,$active);

  pageredirect("admin.php?module=block");
  

?>


 
