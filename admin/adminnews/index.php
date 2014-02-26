<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;
?>

<TABLE id="list_table" width="80%">
<TR><TD class="list_table_pageheader">Berita</TD></TR>
<tr><td>
<?php
 $selectedyear=$_GET["year"];
 if (!isset($selectedyear))
   $selectedyear=date("Y");
 
 $qryyear="select year(datecreated) from news group by year(datecreated)";
 $resyear=sql_query($qryyear,$dbi);
 echo "<form name=\"frm1\" action=\"admin.php?module=adminnews\" method=\"post\">\n";
 echo "Tahun&nbsp;\n";
 echo "<select name=\"txtyear\" onChange=\"location.href='admin.php?module=adminnews&year='+document.frm1.txtyear.value;\">\n";
 while($datayear=sql_fetch_array($resyear)){
   if ($datayear[0]==$selectedyear)
     echo "<option selected value=\"$datayear[0]\">$datayear[0]</option>\n";
   else
     echo "<option value=\"$datayear[0]\">$datayear[0]</option>\n";
 }
 echo "</select>\n";
 echo "</form>";
?>
</td></tr>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">

 <?

	$query = "SELECT id,title,author,public,active,startdate,enddate FROM news where year(datecreated)=$selectedyear order by datecreated ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Bil</td>
		          <td class=\"list_table_header\">Tajuk Berita</td>
		          <td class=\"list_table_header\">Penulis</td>
		          <td class=\"list_table_header\">Tarikh Mula</td>
		          <td class=\"list_table_header\">Tarikh Akhir</td>
				  <td class=\"list_table_header\">Aktif?</td>
				  <td class=\"list_table_header\">Tindakan</td></tr>";
		$cntnews=0;		  
	    while ($data=sql_fetch_array($result,$dbi)) {
                   echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";
				   $cntnews++;
                   $id = $data["id"];
				   $title = $data["title"];
				   $author = $data["author"];
				   $active = $data["active"];
				   $startdate = $data["startdate"];
		           if ($startdate <> "") 
		              $startdate=substr($startdate,8,2)."-".substr($startdate,5,2)."-".substr($startdate,0,4);
		           $enddate = $data["enddate"];
		           if ($enddate <> "") 
		           $enddate=substr($enddate,8,2)."-".substr($enddate,5,2)."-".substr($enddate,0,4);							
                   echo "<td >$cntnews</td>"; 
                   echo "<td >$title</td>"; 
                   echo "<td >$author</td>"; 
                   echo "<td >$startdate</td>"; 
                   echo "<td >$enddate</td>"; 
                   echo "<td >$active</td>"; 
				   echo "<td ><a href='admin.php?module=adminnews&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=adminnews&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
				   echo "</tr>";
					//}
					} //end while 
					} 
					?>
	</table>				
					<tr><td colspan="5"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=adminnews&task=tambah';">
      </td>
  </tr>

		</td>
	</tr>
</table>

