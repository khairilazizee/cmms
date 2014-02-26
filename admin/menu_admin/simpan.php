<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;

 function susun($ordering,$old_ordering,$flg,$jenis,$menu)
 {
 
   global $dbi;
  if ($flg==0){
    if ($jenis=="menu")
       $query = "SELECT id,menupos FROM menu where  admin='1' and type='$jenis' and menupos <= $ordering and menupos > $old_ordering order by menupos ";
	else
       $query = "SELECT id,menupos FROM menu where admin='1' and parent='$menu' and menupos <= $ordering and menupos > $old_ordering order by menupos ";
  }	
  else {
    if ($jenis=="menu")
       $query = "SELECT id,menupos FROM menu where admin='1' and type='$jenis' and  menupos >= $ordering and menupos < $old_ordering order by menupos "; 
    else	   
       $query = "SELECT id,menupos FROM menu where admin='1' and parent='$menu' and  menupos >= $ordering and menupos < $old_ordering order by menupos "; 
  }	
	
 //echo $query."<br>";
  $result = sql_query($query,$dbi);
  while ($data=sql_fetch_array($result,$dbi)) {
     $id=$data["id"];
	 $ord=$data["menupos"];
     if ($flg==0)
	    $ord--;
      else
	     $ord++;		
	  $query="update menu set menupos=". $ord ." where id=$id";

	 sql_query($query,$dbi);  
	 //echo $query."<br>";
  }
} //function susun  

  $id=$_REQUEST["id"];
  $dbtrans=$_REQUEST["dbtrans"];
  $tajuk=$_REQUEST["txt_tajuk"];  
  $jenis=$_REQUEST["txt_jenis"];  
  $menu=$_REQUEST["txt_menu"];  
  $pautan=$_REQUEST["txt_pautan"]; 
  $module=$_REQUEST["txt_modul"];  
  $aktif=$_REQUEST["txt_aktif"];  
  $category=$_REQUEST["txt_kategori"];  
  $image=$_REQUEST["txt_imej"];  
  $catatan=$_REQUEST["txt_catatan"];
  $targetwindow=$_REQUEST["txt_targetwindow"];
  if (!isset($category))
     $category=0;
  if (!isset($aktif))
     $aktif=0;
  $ordering=$_REQUEST["txt_ordering"];  
  $old_ordering=$_REQUEST["txt_old_ordering"];  
  if(!isset($admin))
    $admin=0;
	
  if ($dbtrans=="0") //insert
     $qry="insert into menu(parent,title,link,`type`,category,target_window,active,menupos,admin,module,picture,description)
	       values('$menu','$tajuk','$pautan','$jenis',$category,'$targetwindow','$aktif',$ordering,'1','$module','$image','$catatan')"; 
  else if ($dbtrans=="1") { //update
     $qry="update menu set parent='$menu',title='$tajuk',link='$pautan',`type`='$jenis',
	       target_window='$targetwindow',active='$aktif',menupos='$ordering',admin='1',category=$category,module='$module',picture='$image',description='$catatan' where id=$id";
     if ($old_ordering < $ordering)
       susun($ordering,$old_ordering,0,$jenis,$menu);
	 else if ($old_ordering > $ordering)  
       susun($ordering,$old_ordering,1,$jenis,$menu);
	     
  }
  //echo $qry;		   
  sql_query($qry,$dbi);
  
  pageredirect("admin.php?module=menu_admin");


?>


 
