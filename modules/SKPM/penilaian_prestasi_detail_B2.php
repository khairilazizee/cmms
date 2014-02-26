<script type="text/javascript">

function semak()
{

if (document.frmKpi.txtKpi2.value==''){
  alert('Masukkan Maklumat Aktiviti dan Pencapaian !');
  document.frmKpi.txtKpi2.focus();
  return false;
}
return true;
}

</script>
<?php
global $username;
global $dbi;
global $modname;

include("conn_oracle.php");

     $sqlstr="SELECT DISTINCT KPH_NOSTAF,KPH_KOD_UNIT,ADP_TKH_MULA_UMPORTAL,ADP_TKH_TAMAT_UMPORTAL 
              FROM SN_PT_ADMIN_PTJ,SN_PT_KPI_HDR,SN_KD_JBT,SN_KD_SKS,SN_KD_UNT 
              WHERE KPH_KOD_UNIT = UNT_KOD_UNIT
              AND UNT_KOD_SEKSYEN = SKS_KOD_SEKSYEN
              AND SKS_KOD_JABATAN = JBT_KOD_JABATAN
              AND ADP_JABATAN = JBT_KOD_JABATAN
              AND TO_CHAR(SYSDATE,'YYYYMMDD') BETWEEN
              TO_CHAR(ADP_TKH_MULA_UMPORTAL,'YYYYMMDD')
              AND TO_CHAR(ADP_TKH_TAMAT_UMPORTAL,'YYYYMMDD')";	
			  
      $qry = OCIParse($c,$sqlstr);
      OCIExecute($qry,OCI_DEFAULT);
      if (OCIFetch($qry))
	 	$tutup_kpi=0;
      else
	    $tutup_kpi=1;
		  
 $qry = "SELECT staff_no FROM user WHERE  login='$username'";
 $result = sql_query($qry,$dbi);
 $nostaff = sql_result($result,0,"staff_no");
 
 $qry = OCIParse($c,"SELECT TKW_TAHUN_PENILAIAN FROM SN_PT_THN_KWL");
 OCIExecute($qry,OCI_DEFAULT);
 if (OCIFetch($qry)){
	$tahun = ociresult($qry,"TKW_TAHUN_PENILAIAN");
 }
 else
	 $tahun = date("Y");	 
// $tahun=(int) date("Y");
 
if ($_POST["Submit"]=="Simpan" and $tutup_kpi=="0"){

 $op=$_POST["op"];
 $kpi2=strtoupper($_POST["txtKpi2"]);
 $id=$_POST["txtID"]; 
// echo "Tahun $tahun<br>";
// echo "kpi2 $kpi2<br>";
// echo "No Staf $nostaff<br>";
// die("dah abis");
 
 
 
 if ($op=="Tambah"){
   $sql="insert into SN_PT_MARK_BONUS(BON_TAHUN,BON_NOSTAF,BON_AKT_PENCAPAIAN,BON_CREATED_BY,BON_CREATED_DATE) 
          values(:tahun,:nostaf,:kpi2,:createdby,SYSDATE)";
   $query = OCIParse($c,"$sql");
   OCIBindByName($query,":tahun",$tahun);
   OCIBindByName($query,":nostaf",$nostaff);
   OCIBindByName($query,":kpi2",$kpi2); 
   OCIBindByName($query,":createdby",strtoupper($username));
   OCIExecute($query,OCI_DEFAULT);
   OCICommit($c);
 }  
 else {
   $sql="update SN_PT_MARK_BONUS set BON_AKT_PENCAPAIAN=:kpi2,BON_UPDATED_BY=:updatedby,BON_UPDATED_DATE=SYSDATE 		 
		  where BON_NOSTAF=:nostaff and BON_TAHUN=:tahun and ROWID=:id"; 

   $query = OCIParse($c,"$sql");
   OCIBindByName($query,":tahun",$tahun);
   OCIBindByName($query,":nostaff",$nostaff);
   OCIBindByName($query,":kpi2",$kpi2); 
   OCIBindByName($query,":updatedby",strtoupper($username));
   OCIBindByName($query,":id",$id);
   OCIExecute($query,OCI_DEFAULT);
   OCICommit($c);
 }
 

   pageredirect("$modname&task=penilaian_prestasi#B2");
   	
} //simpan

	 

 if (isset($_GET["id"])){
   $id=htmlentities($_GET["id"]);

   $qry = "SELECT staff_no FROM user WHERE  login='$username'";
   $result = sql_query($qry,$dbi);
   $nostaff = sql_result($result,0,"staff_no");

   $op="Kemaskini";
   $sql="select BON_AKT_PENCAPAIAN from SN_PT_MARK_BONUS where BON_NOSTAF=:nostaf and ROWID=:id";
   $query = OCIParse($c,"$sql");
   OCIBindByName($query,":nostaf",$nostaff);
   OCIBindByName($query,":id",$id);
   
   OCIExecute($query,OCI_DEFAULT);
   if (OCIFetch($query)){
      $kpi2=ociresult($query,"BON_AKT_PENCAPAIAN");
   }   
 }
 else
   $op="Tambah";

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="13"><img src="images/bar_organizer/top_left.gif" width="13" height="23"></td>
    <td background="images/bar_organizer/top_bg.gif"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="bottom"> 
          <td>&nbsp;</td>
          <td height="23" >&nbsp;</td>
          <td height="23" width="85" background="images/bar_organizer/tab1d2.gif"><div align="center"><strong><?php echo $op; ?></strong></div>
            </td>
        </tr>
      </table></td>
    <td width="13"><img src="images/bar_organizer/top_right3.gif" width="13" height="23"></td>
  </tr>
  <tr> 
    <td background="images/bar_organizer/left_bg.gif">&nbsp;</td>
    <td bgcolor="#FAFAAD"><table width="100%" border=0 cellpadding=3 cellspacing=0 class="outset1">
        <tr> 
          <td><table width="100%" border=0 align="center" cellpadding=0 cellspacing=0 class="outset1" style="border-top: 1px solid #C0C099;border-bottom: 1px solid #C0C099;border-right: 1px solid #C0C099;border-left: 1px solid #C0C099;">
              <tr> 
                <td> <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#79ACEE">
                    <tr> 
                      <td width="291" height="23" background="images/bar_organizer/bg_title_left.jpg"><FONT color=#FFFFFF><b>&nbsp;</b></font><FONT color=#FFFFFF face=verdana,arial,helvetica><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
                        Tambah Aktiviti dan Pencapaian</font></b></font></td>
                      <td>&nbsp;</td>
                      <td width="291"><img src="images/bar_organizer/bg_title_right.jpg"></td>
                    </tr>
                  </table>
                  <table width="100%" border=0 align="center" cellpadding=5 cellspacing=0 bgcolor="#FFFFFF">
                    <!--DWLayoutTable-->
                    <tr> 
                      <!--<td height="0"></td>-->
                    <TR> 
                      <TD vAlign=top bgColor=#F8F8F8 colspan="3" width="100%">
					  <!-- content start -->
<?php if ($tutup_kpi=="0") { ?>
<form name="frmKpi" action="mainpage.php?module=HRISOnline&task=penilaian_prestasi_detail_B2" method="post">
  <table bgcolor="#CCCCCC" width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr><td>
  <table bgcolor="#FFFFFF" width="100%" border="0" cellpadding="1">
                                  <tr height="20"> 
                                    <td width="154">1. Maklumat berkenaan Aktiviti 
                                      dan Pencapaian<br><font color="#FF0000">Jangan tekan butang "Enter" semasa menaip</font></td>
                                    <td width="3">:</td>
                                    <td width="552"><textarea  name="txtKpi2" cols="60" rows="2" id="txtKpi2"><?php echo $kpi2; ?></textarea>
									<input name="txtID" type="hidden" id="txtID" value="<?php echo $id; ?>"></td>
                                  </tr>
                                  <tr height="25"> 
                                    <td colspan="3" align="center"><input type="submit" name="Submit" value="Simpan" onClick="return semak();"> 
                                      <input name="Batal" type="button" id="Batal" value="Batal" onClick="location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi#B2';"> 
                                      <input type="hidden" name="txtNoStaf" value="<?php echo $nostaf; ?>">
                                      <input type="hidden" name="op" value="<?php echo $op; ?>">
                                    </td>
                                  </tr>
                                </table>
  </td></tr>
  </table>
</form>
		<?php } 
	else {
?>
					   <font color="#FF0000">Adalah dengan ini dimaklumkan bahawa proses memasukkan/mengemaskini 
                        data telah tamat.<br> Anda hanya dibenarkan memapar dan mencetak 
                        sahaja.<br> Sebarang kemusykilan, sila hubungi <strong>En Husin</strong> / 
                        <strong>Pn Rosaida</strong> (BSM) - sambungan 3236</font><br>
					<input type="button" name="Back" value="Kembali" OnClick="location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi#B2';">

<?php
	}
	?>				  
					  <!-- content end -->
                      </TD>
                    </TR>
                  </table></td>
              </tr>
            </table> </td>
        </tr>
      </table></td>
    <td background="images/bar_organizer/right_bg.gif">&nbsp;</td>
  </tr>
  <tr> 
    <td height="9"><img src="images/bar_organizer/bottom_left.gif" width="13" height="9"></td>
    <td background="images/bar_organizer/bottom_bg.gif"></td>
    <td><img src="images/bar_organizer/bottom_right.gif" width="13" height="9"></td>
  </tr>
</table>
<!--  PopCalendar(tag name and id must match) Tags should not be enclosed in tags other than the html body tag. -->
<iframe width=174 height=189 name="gToday:normal:agenda.js" id="gToday:normal:agenda.js" src="HelloWorld/ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
<?php
  OCILogoff($c);
?>  