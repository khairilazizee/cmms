<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

global $username;
global $dbi;
global $ncolor;
global $hlcolor;

function checkblock($name)
{
    global $dbi;
	
	$query = "SELECT id FROM blocks where name='$name'";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);	
	if($num_rows > 0) 
	   return(1);
	else
	  return(0);
} //function checkblock
?>

<TABLE id="list_table" width="70%">
<TR><TD class="list_table_pageheader">Blok</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
<tr><td colspan="7"><input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=block&task=susun';"></td></tr>

 <?

	$query = "SELECT id,title,position,name,image,public,active,ordering FROM blocks order by ordering ";
				   
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
			
		
	if($num_rows > 0) {
	    echo "<tr><td class=\"list_table_header\">Nama Blok</td><td class=\"list_table_header\">Tajuk Blok</td>
		   <td class=\"list_table_header\">Kedudukan</td><td class=\"list_table_header\">Paparan Umum</td>
		   <td class=\"list_table_header\">Aktif?</td><td class=\"list_table_header\">Susunan</td><td class=\"list_table_header\">Tindakan</td></tr>\n";
	    while ($data=sql_fetch_array($result,$dbi)) {
              $id = $data["id"];
			  $title = $data["title"];
			  $name = $data["name"];
			  $position = $data["position"];
			  $public = $data["public"];
			  $active = $data["active"];
			  $ordering = $data["ordering"];

			  if ($name=="block-Login" or $name=="block-Profil")
			     $rowcolor="#CCCCCC";
			  else
	            $rowcolor=$ncolor;
								
              echo "<tr bgcolor='$rowcolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$rowcolor'\">"; 
              echo "<td >$name</td>"; 
              echo "<td >$title</td>"; 
              if (strcmp($position,"left")==0)
				  echo "<td >kiri</td>"; 
              else if (strcmp($position,"center")==0)
				  echo "<td >tengah</td>"; 
              else 
				  echo "<td >kanan</td>"; 
              echo "<td >$public</td>"; 
              echo "<td >$active</td>"; 
              echo "<td >$ordering</td>"; 
			  echo "<td ><a href='admin.php?module=block&task=kemaskini&id=$id'><img src='images/admin/btn_edit.gif' border='0' alt='Kemaskini'></a>";
			  if (!($name=="block-Login" or $name=="block-CASLogin" or $name=="block-Staf"))
			     echo "&nbsp;&nbsp;<a href='admin.php?module=block&task=hapus&id=$id' onclick='return confirm(\"Hapuskan rekod ?\");'><img src='images/admin/btn_delete.gif' border='0' alt='Kemaskini'></a>";
			  echo "</td></tr>\n";

	} //end while 
  } // $numrows > 0
?>

<tr><td colspan="7"><input type="button" value="Susun Semula" name="btnSusun" onClick="location.href='admin.php?module=block&task=susun';"></td></tr>					
</table>
</td></tr></table>
<br>
<TABLE id="list_table" width="30%">
<TR><TD class="list_table_pageheader">Blok Belum Aktif</TD></TR>
<tr><td>
<TABLE cellpadding="1" cellspacing="1" border="0" width="100%">
 <?

	$blocksdir = dir("blocks");
	    echo "<tr><td class=\"list_table_header\">Nama Blok</td>
				  <td class=\"list_table_header\">Tindakan</td></tr>\n";
		while($func=$blocksdir->read()) {
		$func=basename($func,".php");
	    if(checkblock($func)==0 and ereg("block",$func)) {
               echo "<tr bgcolor=\"$ncolor\" onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\">"; 
               echo "<td>$func</td>"; 
               echo "<td ><a href='admin.php?module=block&task=aktif&name=$func'>Aktifkan</a></td>"; 
			   echo "</tr>\n";
		    }
	    }

?>
</table>
</td></tr></table>