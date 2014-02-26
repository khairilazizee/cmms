<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;
?>
<TABLE id="list_table" width="80%">
<TR><TD class="list_table_pageheader">Pengumuman</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">


 <?

	$query = "SELECT id,title,activity,startdate,enddate,ordering FROM announcement order by ordering ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td width=\"20%\" class=\"list_table_header\">Tajuk</td>
		          <td width=\"30%\" class=\"list_table_header\">Aktiviti</td>
				  <td class=\"list_table_header\">Tarikh Mula</td>
				  <td class=\"list_table_header\">Tarikh Akhir</td>
				  <td class=\"list_table_header\">Susunan</td><td class=\"list_table_header\">Tindakan</td></tr>";
	    while ($data=sql_fetch_array($result,$dbi)) {

          echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";

          $id = $data["id"];
		  $title = $data["title"];
							$activity = $data["activity"];
		  if ($data["startdate"]<>"")
		     $startdate = substr($data["startdate"],8,2)."/".substr($data["startdate"],5,2)."/".substr($data["startdate"],0,4);
		  else
		     $startdate = "";  
		   
		  if ($data["enddate"]<>"")
		     $enddate = substr($data["enddate"],8,2)."/".substr($data["enddate"],5,2)."/".substr($data["enddate"],0,4);
		  else
		     $enddate = "";   
		  $ordering = $data["ordering"];
          echo "<td >$title</td>"; 
          echo "<td >$activity</td>"; 
		  echo "<td>$startdate</td>";
		  echo "<td>$enddate</td>";
		  echo "<td align=\"center\">$ordering</td>";
		  echo "<td align=\"center\"><a href='admin.php?module=pengumuman&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>&nbsp;&nbsp;<a href='admin.php?module=pengumuman&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Hapus'></a></td>";
		  echo "</tr>";
		  $counttsk = $counttsk + 1;
					//}
	  } //end while 
	} 
?>
		</table>			
					<tr><td colspan="5"><input type="button" name="Tambah" value="Tambah" onclick="location.href='admin.php?module=pengumuman&task=tambah';">
										&nbsp;<input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=pengumuman&task=susun';"></td></tr>

      </td>
  </tr>
</table>

