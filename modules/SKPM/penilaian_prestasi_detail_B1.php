<script type="text/javascript">

function isInteger(s){
	var i;
    for (i = 0; i < s.length; i++){   
        // Check that current character is number.
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))) return false;
    }
    // All characters are numbers.
    return true;
}


function semak()
{
var wajaran;
var wajaranold;
var jum_wajaran;
var jum_wajaran_baru;


if (document.frmKpi.txtKpi.value==''){
  alert('Masukkan Keterangan Penunjuk Prestasi Utama !');
  document.frmKpi.txtKpi.focus();
  return false;
}
if (document.frmKpi.txtSasaran.value==''){
  alert('Masukkan Sasaran !');
  document.frmKpi.txtSasaran.focus();
  return false;
}

if (document.frmKpi.txtWajaran.value==''){
  alert('Masukkan Peratas Wajaran !');
  document.frmKpi.txtWajaran.focus();
  return false;
}

if (isInteger(document.frmKpi.txtWajaran.value)==false){
  alert('Masukkan nombor sahaja untuk Wajaran !');
  document.frmKpi.txtWajaran.focus()
  return false;
}

if (document.frmKpi.txtWajaranold.value=="")
 document.frmKpi.txtWajaranold.value=0;
wajaran=parseInt(document.frmKpi.txtWajaran.value);
wajaran_old=parseInt(document.frmKpi.txtWajaranold.value);
jum_wajaran=parseInt(document.frmKpi.txtJum_wajaran.value);
jum_wajaran_baru = jum_wajaran+wajaran-wajaran_old;

if ( jum_wajaran_baru > 100){
  alert('Jumlah Wajaran melebihi 100 !');
  document.frmKpi.txtWajaran.focus()
  return false; 
}

if ( jum_wajaran_baru < 100)
  alert('Jumlah Wajaran belum cukup 100 !');

return true;
}

</script>
<?php
global $username;
global $dbi;
global $modname;

include("conn_oracle.php");
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
 
     
 $sql="SELECT SUM(KPD_PERATUS_WAJARAN) AS JUM FROM SN_PT_KPI_DTL WHERE KPD_NOSTAF='$nostaff' AND KPD_TAHUN='$tahun'";
 $query = OCIParse($c,$sql);
 OCIExecute($query,OCI_DEFAULT);
 if (OCIFetch($query)){
 	$jum_wajaran = ociresult($query,"JUM");
 }

  
if ($_POST["post"]=="1" and $tutup_kpi=="0"){

 $op=$_POST["op"];
 $kpi=strtoupper($_POST["txtKpi"]);
 $id=$_POST["txtID"]; 
 $sasaran=strtoupper($_POST["txtSasaran"]);
 $wajaran=$_POST["txtWajaran"];

 if ($op=="Tambah"){
   $sql="insert into SN_PT_KPI_DTL(KPD_TAHUN,KPD_NOSTAF,KPD_PENUNJUK_PRESTASI,KPD_SASARAN,KPD_PERATUS_WAJARAN,KPD_CREATED_BY,KPD_CREATED_DATE) 
         values(:tahun,:nostaf,:kpi,:sasaran,:wajaran,:createdby,SYSDATE)";
   $query = OCIParse($c,"$sql");
   OCIBindByName($query,":tahun",$tahun);
   OCIBindByName($query,":nostaf",$nostaff);
   OCIBindByName($query,":kpi",$kpi); 
   OCIBindByName($query,":sasaran",$sasaran); 
   OCIBindByName($query,":wajaran",$wajaran);
   OCIBindByName($query,":createdby",strtoupper($username));
   OCIExecute($query,OCI_DEFAULT);
   OCICommit($c);
 }  
 else {
   $sql="update SN_PT_KPI_DTL set KPD_PENUNJUK_PRESTASI=:kpi,KPD_SASARAN=:sasaran,
         KPD_PERATUS_WAJARAN=:wajaran,KPD_UPDATED_BY=:updatedby,KPD_UPDATED_DATE=SYSDATE 		 
		  where KPD_NOSTAF=:nostaff and KPD_TAHUN=:tahun and ROWID=:id"; 

   $query = OCIParse($c,"$sql");
   OCIBindByName($query,":tahun",$tahun);
   OCIBindByName($query,":nostaff",$nostaff);
   OCIBindByName($query,":kpi",$kpi); 
   OCIBindByName($query,":sasaran",$sasaran); 
   OCIBindByName($query,":wajaran",$wajaran);
   OCIBindByName($query,":updatedby",strtoupper($username));
   OCIBindByName($query,":id",$id);
   OCIExecute($query,OCI_DEFAULT);
   OCICommit($c);
 }
 

   pageredirect("$modname&task=penilaian_prestasi#B1");
   	
} //simpan

	 

 if (isset($_GET["id"])){
   $id=htmlentities($_GET["id"]);

   $qry = "SELECT staff_no FROM user WHERE  login='$username'";
   $result = sql_query($qry,$dbi);
   $nostaff = sql_result($result,0,"staff_no");

   $op="Kemaskini";
   $sql="select KPD_PENUNJUK_PRESTASI,KPD_SASARAN,KPD_PERATUS_WAJARAN from SN_PT_KPI_DTL where KPD_NOSTAF=:nostaf and ROWID=:id";
   $query = OCIParse($c,"$sql");
   OCIBindByName($query,":nostaf",$nostaff);
   OCIBindByName($query,":id",$id);
   
   OCIExecute($query,OCI_DEFAULT);
   if (OCIFetch($query)){
      $sasaran=ociresult($query,"KPD_SASARAN");
      $kpi=ociresult($query,"KPD_PENUNJUK_PRESTASI");
	  $wajaran=ociresult($query,"KPD_PERATUS_WAJARAN");
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
                        Penunjuk Prestasi Utama</font></b></font></td>
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
<?php if ($tutup_kpi=="0"){ ?>					  
<form name="frmKpi" action="mainpage.php?module=HRISOnline&task=penilaian_prestasi_detail_B1" method="post" onSubmit="return semak();">
  <table bgcolor="#CCCCCC" width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr><td>
  <table bgcolor="#FFFFFF" width="100%" border="0" cellpadding="1">
                                  <tr height="20"> 
                                    <td width="116">1. KPI<br><font color="#FF0000">Jangan tekan butang "Enter" semasa menaip</font></td>
                                    <td width="7">:</td>
                                    <td width="603"><textarea  name="txtKpi" cols="80" rows="8" id="txtKpi"><?php echo $kpi; ?></textarea>
									<input name="txtID" type="hidden" id="txtID" value="<?php echo $id; ?>"></td>
                                  </tr>
                                  <tr height="20"> 
                                    <td>2. Sasaran<br><font color="#FF0000">Jangan tekan butang "Enter" semasa menaip</font></td>
                                    <td>:</td>
                                    <td><textarea  name="txtSasaran" cols="80" rows="8" id="txtSasaran"><?php echo $sasaran; ?></textarea></td>
                                  </tr>
                                  <tr> 
                                    <td>3. Wajaran (%)</td>
                                    <td>: </td>
                                    <td><input name="txtWajaran" type="text" id="txtWajaran" size="3" maxlength="3" value="<?php echo $wajaran; ?>">
                                        &nbsp;&nbsp;&nbsp;Jumlah wajaran terkini ialah <strong><?php echo $jum_wajaran; ?></strong>
                                   <input name="txtWajaranold" type="hidden" id="txtWajaranold" size="3" maxlength="3" value="<?php echo $wajaran; ?>">
								   <input name="txtJum_wajaran" type="hidden" id="txtJum_wajaran" size="3" maxlength="3" value="<?php echo $jum_wajaran; ?>"></td>
								  </tr>
                                  <tr height="30"> 
                                    <td colspan="3" align="center">
									  <input type="submit" name="Submit" value="Simpan" > 
                                      <input name="Batal" type="button" id="Batal" value="Batal" onClick="location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi#B1';"> 
                                      <input type="hidden" name="txtNoStaf" value="<?php echo $nostaf; ?>">
                                      <input type="hidden" name="op" value="<?php echo $op; ?>">
									  <input type="hidden" name="post" value="1">                                    </td>
                                  </tr>
                                  <tr height="25">
                                    <td colspan="3" align="center">
									<!-- azizi edit on 11DEC07 * add table spacing-->
									<table border="0" height="50">
										<tr><td>&nbsp; </td></tr>
									</table>									
									
									
                                      <strong><font color="#FF0000" size="1">
                                      Sistem akan LOGOUT secara automatik dalam tempoh 30 minit sekiranya aplikasi ini tidak digunakan secara berterusan.<br>Maklumat yang dimasukkan akan 'hilang' jika pengguna tidak klik butang 'simpan' dalam tempoh tersebut.
                                                                        <br />
                                                                        <br />
                                      Sebarang kemusykilan, sila hubungi En Husin / Pn 
                                      Rosaida (BSM) - sambungan 3236 </font></strong></td>
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
						<input type="button" name="Back" value="Kembali" OnClick="location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi#B1';">
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
