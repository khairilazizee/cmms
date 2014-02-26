<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;

$category=$_REQUEST["txt_kategori"];
$tahun=$_REQUEST["txt_tahun"];
if (isset($category))
  $_SESSION["category"]=$category;
else {
  if (isset($_SESSION["category"]))
     $category=$_SESSION["category"];
}  

if (isset($tahun))
  $_SESSION["tahun"]=$tahun;
else {
  if (isset($_SESSION["tahun"]))
     $tahun=$_SESSION["tahun"];
}   
//echo "session cat:".$_SESSION["category"]." category:".$category;  
?>
<TABLE id="list_table" width="90%">
<TR><TD class="list_table_pageheader">Halaman</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">

 <?
	echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"6\">";
    echo "<form name=\"frmkandungan\" method=\"post\" action=\"admin.php?module=adminhalaman\">";
    echo "Kategori&nbsp;&nbsp;<select name=\"txt_kategori\" onchange=\"document.frmkandungan.submit();\">";
    
	$query = "SELECT id,title FROM content_category order by id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	$cnt=1;	
	if($num_rows > 0) {
	    while($data=sql_fetch_array($result,$dbi)){ 
			 
		  $id = $data["id"];
		  $title = $data["title"];
		  if ($cnt==1 and !isset($category)){
		    $category=$id;
			$_SESSION["category"]=$id;
		  }
		  if ($id==$category)
	        echo "<option selected value=\"$id\">$title</option>";
		  else
	        echo "<option value=\"$id\">$title</option>";
		}
	} 
	echo '</select></td></tr>';
    $sqldate="select year(createddate) from content_pages  where category=$category group by year(createddate)";
    echo "<tr><td>Tahun&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name=\"txt_tahun\"  onchange=\"document.frmkandungan.submit();\">";
    $res1=sql_query($sqldate,$dbi);
	$cnt=1;
    while ($data1=sql_fetch_array($res1)){
         $thn=$data1[0];
		  if ($cnt==1 and !isset($tahun)){
		    $tahun=$thn;
			$_SESSION["tahun"]=$id;
		  }		 
		 if ($thn==$tahun)
           echo "<option value=\"$thn\" selected>$thn</option>";
		 else
           echo "<option value=\"$thn\">$thn</option>";
   }
    echo "</select></form></td></tr>";

    $query = "SELECT id,title,ptj_only,active,author ,createddate from content_pages where category=$category and year(createddate)=$tahun";	
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Tajuk Halaman</td>
				  <td class=\"list_table_header\">Aktif</td>
				  <td class=\"list_table_header\">Dihantar Oleh</td>
				  <td class=\"list_table_header\">Tarikh</td>
				  <td class=\"list_table_header\">Tindakan</td></tr>";
	    while ($data=sql_fetch_array($result,$dbi)) {
                   echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";
                            $id = $data["id"];
							$title = $data["title"];
							$type = $data["type"];
							$ptj_only = $data["ptj_only"];
							$active = $data["active"];
							$author = $data["author"];
							$createddate = $data["createddate"];
                            echo "<td >$title</td>"; 
                            echo "<td >$active</td>"; 
                            echo "<td >$author</td>"; 
                            echo "<td >$createddate</td>"; 
							echo "<td ><a href='admin.php?module=adminhalaman&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=adminhalaman&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
							echo "</tr>";
					//}
					} //end while 
					} 
					?>
					</table>
					<tr><td colspan="6">
					<form name="frmtambah" action="admin.php?module=adminhalaman&task=tambah" method="post">
					<input type="hidden" name="txt_kategori" value="<?php echo $category ?>">
					<input type="submit" name="Tambah" value="Tambah">
					</form>
      </td>
  </tr>
</table>

