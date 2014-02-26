<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL_ADMIN' ) or die( 'Akses tidak dibenarkan !' );

 global $dbi;
 include("FCKEditor/fckeditor.php") ; 

 
    $id=$_GET["id"];
	
	$query = "SELECT id,title,activity,startdate,enddate,ordering FROM announcement where id=$id ";
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	if($num_rows > 0) {
     while ($data=sql_fetch_array($result,$dbi)) {
		$title = $data["title"];
		$activity = $data["activity"];	
		$active = $data["active"];
		
		if ($data["startdate"]<>"")
		   $startdate = substr($data["startdate"],8,2)."-".substr($data["startdate"],5,2)."-".substr($data["startdate"],0,4);
		else
		   $startdate = "";  
		   
		if ($data["enddate"]<>"")
		   $enddate = substr($data["enddate"],8,2)."-".substr($data["enddate"],5,2)."-".substr($data["enddate"],0,4);
		else
		   $enddate = "";   
		   
		$ordering = $data["ordering"];	
	  }
	} 
?>
<form name="frmrole" method="post" action="admin.php?module=pengumuman&task=simpan">
<table id="form_table_outer" width="80%">
  <tr><td class="form_table_header">Kemaskini Pengumuman</td></tr>
  <tr><td>
<table id="form_table_inner" width="100%">
    <tr> 
      <td>Tajuk</td>
      <td><input name="txt_title"  type="text" value="<?php echo $title; ?>" size="50" maxlength="50"></td>
    </tr>
    <tr> 
      <td width="11%">Pengumuman</td>
      <td width="89%">
	     <?php 
	     $sBasePath="FCKEditor/";
         $oFCKeditor = new FCKeditor('txt_aktiviti') ;
         $oFCKeditor->BasePath	= $sBasePath ;
		 $oFCKEditor->ToolbarSet	= 'Basic';
         $oFCKeditor->Value		= "$activity" ;
         $oFCKeditor->Create() ;
         echo "</td></tr>";
		 ?>
	  </td>
    </tr>
		<tr>
	 <td>Tarikh Mula</td>
	 <td><input type="textbox" name="txt_trkhmula" value="<?php echo $startdate; ?>" size="12" maxlength="10">
              (DD/MM/YYYY ) </td>
	</tr>
	<tr>
	 <td>Tarikh Akhir</td>
	 <td><input type="textbox" name="txt_trkhakhir" value="<?php echo $enddate; ?>" size="12" maxlength="10">
              (DD/MM/YYYY ) </td>
	</tr>
	   <tr>
      <td>Susunan</td>
      <td>
	  <?php
	    $query = "SELECT ordering FROM announcement order by ordering ";
        $result = sql_query($query,$dbi);
	    $num_rows = sql_num_rows($result);
		echo "<select name=\"txt_ordering\">";
		if ($num_rows > 0){
			while ($data=sql_fetch_array($result,$dbi)){
				$susun=$data["ordering"];
				if ($susun==$ordering)
				  echo "<option selected value=\"$susun\">$susun</option>";
				else
				  echo "<option value=\"$susun\">$susun</option>";
		    }
		} //num_rows > 0
		echo "</select>";
		?>	 	  
	  </td>
    </tr>
    <tr> 
      <td colspan="2" > 
	    <input type="hidden" name="txt_old_ordering" value="<?php echo $ordering ?>">
	    <input name="id" type="hidden" value="<?php echo $id; ?>"> 
        <input name="dbtrans" type="hidden" value="1"> 
		<input name="Simpan" type="submit" value="Simpan"> 
        <input name="Kembali" type="Button" value="Kembali" onclick="location.href='admin.php?module=pengumuman';"> 
      </td>
    </tr>
  </table>
</td></tr></table>
</form>
