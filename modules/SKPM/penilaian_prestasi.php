<script type="text/javascript">

function semak_wajaran(v)
{

if (v!='100'){
  alert('Sila pastikan jumlah wajaran adalah 100 sebelum mencetak borang KPI !');
  return false;
}
return true;
}

function tambah_pencapaian(v)
{
if (v!='100')
  alert('Sila pastikan jumlah wajaran adalah 100 sebelum menambah aktiviti/pencapaian !');
else
  location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi_detail_B2';
return true;
}
</script>

<?
	global $username; //=$_SESSION["username"];
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

     $qry = OCIParse($c,"SELECT TKW_TAHUN_PENILAIAN FROM SN_PT_THN_KWL");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$tahun = ociresult($qry,"TKW_TAHUN_PENILAIAN");
     }
	 else
	    $tahun = date("Y");	 

// maklumat staf
     $query="select staff_no FROM user WHERE  login='$username'";
     $result=mysql_query($query,$dbi);
     $nogaji = sql_result($result,0,"staff_no");

     $qry = OCIParse($c,"SELECT EMP_NAME,EMP_IC_NEW,POSITION_DESC,UNIT_DESCRIPTION FROM RESEARCH_MANAGE_IS_V WHERE EMP_NO='$nogaji'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$nama = ociresult($qry,"EMP_NAME");
		$nokp = ociresult($qry,"EMP_IC_NEW");
		$jawatan = ociresult($qry,"POSITION_DESC");
		$jabatan =  ociresult($qry,"UNIT_DESCRIPTION"); 
     }	 

     //end maklumat staf

    if ($_GET["tukar"]=="ppp" and $tutup_kpi=="0"){
		   $ppp_baru=$_POST["ppp"];
		   $sql="update SN_PT_KPI_HDR set KPH_NOSTAF_PPP=:ppp_baru,KPH_UPDATED_BY=:updatedby,KPH_UPDATED_DATE=SYSDATE 		 
				  where KPH_NOSTAF=:nostaff and KPH_TAHUN=:tahun"; 
		  $query = OCIParse($c,"$sql");
		  OCIBindByName($query,":nostaff",$nogaji);
		  OCIBindByName($query,":ppp_baru",$ppp_baru);
		  OCIBindByName($query,":tahun",$tahun);
		  OCIBindByName($query,":updatedby",strtoupper($username));
		  OCIExecute($query,OCI_DEFAULT);
		  OCICommit($c);	
}
    if ($_GET["tukar"]=="ppk" and tutup_kpi=="0"){
		   $ppk_baru=$_POST["ppk"];
		   $sql="update SN_PT_KPI_HDR set KPH_NOSTAF_PPK=:ppk_baru,KPH_UPDATED_BY=:updatedby,KPH_UPDATED_DATE=SYSDATE 		 
				  where KPH_NOSTAF=:nostaff and KPH_TAHUN=:tahun"; 
		  $query = OCIParse($c,"$sql");
		  OCIBindByName($query,":nostaff",$nogaji);
		  OCIBindByName($query,":ppk_baru",$ppk_baru);
		  OCIBindByName($query,":tahun",$tahun);
		  OCIBindByName($query,":updatedby",strtoupper($username));
		  OCIExecute($query,OCI_DEFAULT);
		  OCICommit($c);	
}

    if ($_GET["hapus"]=="1" and $tutup_kpi=="0"){
       $id=htmlentities($_GET["id"]);
	   $nostaff=$nogaji;
	 
      $sql="DELETE FROM SN_PT_KPI_DTL WHERE KPD_NOSTAF=:nostaff and ROWID=:id and KPD_TAHUN=:tahun"; 
	
      $query = OCIParse($c,"$sql");
      OCIBindByName($query,":nostaff",$nostaff);
      OCIBindByName($query,":id",$id);
      OCIBindByName($query,":tahun",$tahun);
      OCIExecute($query,OCI_DEFAULT);
      OCICommit($c);
	  pageredirect("$modname&task=penilaian_prestasi#B1");
	
}
    if ($_GET["hapus"]=="2" and $tutup_kpi=="0"){
       $id=htmlentities($_GET["id"]);
	   $nostaff=$nogaji;
	 
      $sql="DELETE FROM SN_PT_MARK_BONUS WHERE BON_NOSTAF=:nostaff and ROWID=:id and BON_TAHUN=:tahun"; 
      $query = OCIParse($c,"$sql");
      OCIBindByName($query,":nostaff",$nostaff);
      OCIBindByName($query,":id",$id);
      OCIBindByName($query,":tahun",$tahun);
      OCIExecute($query,OCI_DEFAULT);
      OCICommit($c);	
	  pageredirect("$modname&task=penilaian_prestasi#B2");

}

    if ($_GET["hapus"]=="3" and $tutup_kpi=="0"){
	   $nostaff=$nogaji;
	 
      $sql="UPDATE SN_PT_KPI_HDR SET KPH_NOSTAF_PPK=null WHERE KPH_NOSTAF=:nostaff"; 
      $query = OCIParse($c,"$sql");
      OCIBindByName($query,":nostaff",$nostaff);
      OCIExecute($query,OCI_DEFAULT);
      OCICommit($c);	
}

	// maklumat PPP dan PPK

     $qry ="select KPH_NOSTAF_PPP,KPH_NOSTAF_PPK,KPH_TKH_TT_CAPAIAN_PYD,KPH_TKH_TT_CAPAIAN_PPP,KPH_TKH_TT_CAPAIAN_PPK 
	        FROM SN_PT_KPI_HDR WHERE  KPH_NOSTAF='$nogaji' AND KPH_TAHUN='$tahun'"; 
	 $query = OCIParse($c,$qry);
     OCIExecute($query,OCI_DEFAULT);
     if (OCIFetch($query)){
	 	$nostaf_ppp = ociresult($query,"KPH_NOSTAF_PPP");
	 	$nostaf_ppk = ociresult($query,"KPH_NOSTAF_PPK");
	 	$tkh_tt_ppy = ociresult($query,"KPH_TKH_TT_CAPAIAN_PYD");
	 	$tkh_tt_ppp = ociresult($query,"KPH_TKH_TT_CAPAIAN_PPP");
	 	$tkh_tt_ppk = ociresult($query,"KPH_TKH_TT_CAPAIAN_PPK");
     }	 

     $qry = OCIParse($c,"SELECT EMP_NAME,POSITION_DESC,UNIT_DESCRIPTION,GRADE_CODE FROM RESEARCH_MANAGE_IS_V WHERE EMP_NO='$nostaf_ppp'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$nama_ppp = ociresult($qry,"EMP_NAME");
	 	$jawatan_ppp = ociresult($qry,"POSITION_DESC");
	 	$jabatan_ppp = ociresult($qry,"UNIT_DESCRIPTION");
	 	$grade_ppp = ociresult($qry,"GRADE_CODE");
     }	 

     $qry = OCIParse($c,"SELECT EMP_NAME,POSITION_DESC,UNIT_DESCRIPTION,GRADE_CODE FROM RESEARCH_MANAGE_IS_V WHERE EMP_NO='$nostaf_ppk'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$nama_ppk = ociresult($qry,"EMP_NAME");
	 	$jawatan_ppk = ociresult($qry,"POSITION_DESC");
	 	$jabatan_ppk = ociresult($qry,"UNIT_DESCRIPTION");
	 	$grade_ppk = ociresult($qry,"GRADE_CODE");
     }	 

     //end maklumat PPP and PPK

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="13"><img src="images/bar_organizer/top_left.gif" width="13" height="23"></td>
    <td background="images/bar_organizer/top_bg.gif"> <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="bottom"> 
          <td>&nbsp;</td>
          <td height="23" >&nbsp;</td>
          <td height="23" width="85" background="images/bar_organizer/tab1d2.gif"><div align="center"><strong>KPI</strong></div>
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
                        Laporan Penilaian Prestasi</font></b></font></td>
                      <td>&nbsp;</td>
                      <td width="291"><img src="images/bar_organizer/bg_title_right.jpg"></td>
                    </tr>
                  </table>
                  <table width="100%" border=0 align="center" cellpadding=5 cellspacing=0 bgcolor="#FFFFFF">
                    <tr>
						
                      <td><div align="center"><font size="2"><strong>LAPORAN PENILAIAN 
                          PRESTASI<br>
                          TAHUN <?php echo $tahun ?></strong></font></div></td>
					</tr>
					<tr>
                      <td>
					  <?php if ($tutup_kpi=="1"){ ?>
					   <font color="#FF0000">Adalah dengan ini dimaklumkan bahawa proses memasukkan/mengemaskini 
                        data telah tamat.<br> Anda hanya dibenarkan memapar dan mencetak 
                        sahaja.<br> Sebarang kemusykilan, sila hubungi <strong>En Husin</strong> / 
                        <strong>Pn Rosaida</strong> (BSM) - sambungan 3236</font>
					  <?php } ?>	
						</td>
                    </tr>
					<TR> 
                      <TD vAlign=top bgColor=#F8F8F8 colspan="3" width="100%"> 
                        <!-- content start -->
                        <p> <font color="#0000FF" size="2"><strong>BAHAGIAN A: 
                          MAKLUMAT STAF</strong></font></p>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
                          <?php
     $sql="SELECT SUM(KPD_PERATUS_WAJARAN) as SUM_WAJARAN 
	 		FROM SN_PT_KPI_DTL,SN_PT_KPI_HDR WHERE KPD_NOSTAF=KPH_NOSTAF AND  KPD_TAHUN=KPH_TAHUN AND
			KPD_NOSTAF='$nogaji' AND KPD_TAHUN='$tahun'";
	 $query = OCIParse($c,$sql);
     OCIExecute($query,OCI_DEFAULT);
     if (OCIFetch($query)){
	    $peratus_wajaran=OCIResult($query,"SUM_WAJARAN");
	 }
 ?>
                          <tr> 
                            <td colspan="10" align="right"><a href="mainpage.php?module=HRISOnline&task=penilaian_prestasi_cetak&displayframework=0" alt="Format Pencetak" target="_blank" onClick="return semak_wajaran('<?php echo $peratus_wajaran; ?>');">CETAK 
                              Borang KPI&nbsp;&nbsp;<img src="images/print.gif"></a></td>
                          </tr>
                          <tr> 
                            <td width="6" >&nbsp;</td>
                            <td width=104><strong> Nama</strong></td>
                            <td width="6">:</td>
                            <td><font color="#000000" size="2"> <?php echo $nama ?> 
                              </font></td>
                            <td width="10" >&nbsp;</td>
                            <td width="91"><strong> No. K.P</strong></td>
                            <td width="9">:</td>
                            <td width="224" colspan="2"><font color="#000000" size="2"> 
                              <?php echo $nokp ?> </font></td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104><strong> Jawatan</strong></td>
                            <td>:</td>
                            <td><font color="#000000" size="2"> <?php echo $jawatan ?> 
                              </font></td>
                            <td >&nbsp;</td>
                            <td width=91><strong> No Staf</strong></td>
                            <td>:</td>
                            <td colspan="2"><font color="#000000" size="2"> <?php echo $nogaji ?> 
                              </font></td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104><strong> Jabatan</strong></td>
                            <td>:</td>
                            <td colspan="6" valign="baseline">&nbsp;<?php echo $jabatan ?></td>
                          </tr>
                          <tr> 
                            <td colspan="9" >&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" colspan="8" >&nbsp;</td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104><strong> PPP</strong></td>
                            <td>:</td>
                            <td valign="baseline">&nbsp;<?php echo $nama_ppp ?> 
                            </td>
                            <td colspan="5">&nbsp;<?php echo $jawatan_ppp ?> &nbsp;(<?php echo $grade_ppp ?>)</td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104></td>
                            <td>:</td>
                            <td colspan="8">&nbsp;<?php echo $jabatan_ppp ?></td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                            <td colspan="8">
							  <?php if ($tutup_kpi=="0") { ?>
							  <input type="button" name="Tambah32" value="Tukar PPP" onClick="location.href='mainpage.php?module=HRISOnline&task=tukar_pp&flg=1';">
							  <?php } ?>
                            </td>
                          </tr>
                          <tr> 
                            <td colspan="9">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104><strong> PPK</strong></td>
                            <td>:</td>
                            <td valign="baseline">&nbsp;<?php echo $nama_ppk ?> 
                            </td>
                            <td colspan="5">&nbsp;<?php echo $jawatan_ppk ?>&nbsp;(<?php echo $grade_ppk ?>)</td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104></td>
                            <td>:</td>
                            <td colspan="8">&nbsp;<?php echo $jabatan_ppk ?></td>
                          </tr>
                          <tr>
                            <td >&nbsp;</td>
                            <td></td>
                            <td>&nbsp;</td>
                            <td colspan="8">
							  <?php if ($tutup_kpi=="0"){ ?>
							  <input type="button" name="Tambah3" value="Tukar PPK" onClick="location.href='mainpage.php?module=HRISOnline&task=tukar_pp&flg=2';">
                              <input type="button" name="HapusPPK" value="Hapus PPK" onClick="if (confirm('Hapuskan Pegawai Penilai Kedua?')) location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi&hapus=3';">
							  <?php } ?>
							 </td>
                          </tr>
                          <tr> 
                            <td align="left" colspan="8" >&nbsp; </td>
                          </tr>
                        </table>
						<hr />
                        <p> <font color="#000000" size="2"><strong><u>ARAHAN</u></strong></font></p>
                        <table width="100%" border="0" cellpadding="0" cellspacing=1>
                          <tr> 
                            <td colspan="4"><ol>
                                <li><font color="#000000">Bilangan Petunjuk Prestasi 
                                  Utama mungkin lebih/kurang dari 6, mengikut 
                                  persetujuan PYD dan KJ.</font></li>
                                <li><font color="#000000">Ketua PTj diingatkan 
                                  bahawa di dalam memberikan markah, bilangan 
                                  staf yang mencapai prestasi cemerlang tidak 
                                  boleh melebihi 8% dari jumlah staf di dalam 
                                  PTj tersebut <strong><u>dan</u></strong> pencapaian 
                                  staf tersebut melebihi markah 100%. Staf tersebut 
                                  layak untuk disyorkan untuk menerima 'Anugerah 
                                  Perkhidmatan Cemerlang'.</font></li>
                                <li><font color="#000000">Walau bagaimanapun, 
                                  Ketua PTj diingatkan bahawa keputusan muktamad 
                                  tentang staf yang layak menerima 'Anugerah atau 
                                  Sijil Perkhidmatan Cemerlang' akan dibuat oleh 
                                  Panel Pembangunan Sumber Manusia Pusat.</font></li>
                                <li><font color="#000000">Pegawai yang tidak mencapai 
                                  sasaran diminta memberi ulasan.</font></li>
                                <li><font color="#000000">Borang Laporan Penilaian 
                                  Prestasi Tahunan hendaklah disimpan di PTj masing-masing. 
                                  Borang hanya diserahkan kepada Bahagian Sumber 
                                  Manusia pada <strong>31 Disember tahun penilaian</strong> 
                                  berkenaan setelah Borang Penilaian Prestasi 
                                  Tahunan lengkap diisikan oleh semua pihak (PYD, 
                                  PPP, PPK).</font></li>
                                <li><font color="#000000">PTj dikehendaki membuat 
                                  salinan Borang Penilaian Prestasi Tahunan yang 
                                  telah lengkap diisikan untuk tujuan rekod dan 
                                  rujukan.</font></li>
                              </ol></td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td colspan="4"><strong><u>PANDUAN PEMBERIAN MARKAH UNTUK 
                              BAHAGIAN B2: MAKLUMAT PENUNJUK PRESTASI</u></strong>
						    </td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td colspan="4"><ol>
                                <li><font color="#000000">Untuk kegiatan peringkat 
                                  PTj julat markah yang boleh diberikan ialah 
                                  1 - 5.</font></li>
                                <li><font color="#000000">Untuk kegiatan peringkat 
                                  Universiti julat markah yang boleh diberi ialah 
                                  1-10.</font></li>
                                <li><font color="#000000">Untuk kegiatan peringkat 
                                  Nasional julat markah yang boleh diberi ialah 
                                  1-15.</font></li>
                                <li><font color="#000000">Untuk kegiatan peringkat 
                                  Antarabangsa julat markah yang boleh diberi 
                                  ialah 1-20.</font></li>
                              </ol></td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td colspan="4"><strong><u>DOKUMEN SOKONGAN</u></strong></td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td colspan="4"><p>Kakitangan akademik <u>mesti</u> 
                                menyediakan dokumen sokongan dalam aspek-aspek 
                                berikut:-</p>
                              <ol>
                                <li><font color="#000000">Penerbitan</font></li>
                                <li><font color="#000000">Penyertaan dalam persidangan</font></li>
                                <li><font color="#000000">penerimaan gran penyelidikan</font></li>
                                <li><font color="#000000">Keahlian profesional</font></li>
                                <li><font color="#000000">Keahlian dalam jawatankuasa 
                                  - antarabangsa/nasional/universiti/fakulti/jabatan</font></li>
                              </ol></td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td colspan="4"><strong><u>CATATAN</u></strong></td>
                          </tr>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td colspan="4"><ul>
                                <li>PYD = PEGAWAI YANG DINILAI</li>
                                <li>PPP = PEGAWAI PENILAI PERTAMA</li>
                                <li>PPK = PEGAWAI PENILAI KEDUA</li>
                                <li>PTj = PUSAT TANGGUNGJAWAB</li>
                                <li>KJ = KETUA JABATAN</li>
                              </ul></td>
                          </tr>
				  		</table>						
                        <hr /> 
                        <p> <font color="#0000FF" size="2"><strong><a name="B1"></a>BAHAGIAN B1: 
                          MAKLUMAT PENUNJUK PRESTASI</strong></font></p>
                        <p><strong><font size="2"><u>Cara Pengisian</u></font></strong></p>
                        <ul>
                          <li><strong><font color="#000000" size="1">Klik butang Tambah KPI untuk menambah butir KPI yang telah dipersetujui oleh Ketua Jabatan.</font></strong></li>
                          <li><strong><font color="#000000" size="1">Jumlah wajaran MESTI 100 sebelum boleh ke Bahagian B2.</font></strong></li>

                          <li><strong><font color="#FF0000" size="1">Sebarang 
                            kemusykilan, sila hubungi En Husin / Pn Rosaida (BSM) 
                            - sambungan 3236</font></strong></li>
                        </ul>
                        <table width="100%" border="0" cellpadding="0" cellspacing=1>
                          <tr> 
                            <td colspan="6"> 
							<?php if ($tutup_kpi=="0"){ ?>
							<input type="button" name="Tambah2" value="Tambah KPI" onClick="location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi_detail_B1';">
						   <?php } ?>
						   </td>
                          </tr>
                          <tr> 
                            <td> <table width="100%" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                                <tr height="20" bgcolor="#00CCFF"> 
                                  <th width="148">1. Penunjuk Prestasi Utama 
                                    / KPI</th>
                                  <th width="169" >2. Sasaran</th>
                                  <th width="84" >3. Wajaran</th>
                                  <th width="40">Tindakan&nbsp;</th>
                                </tr>
                                <?php
     $sql="SELECT KPD_PENUNJUK_PRESTASI, KPD_SASARAN,KPD_PERATUS_WAJARAN, KPH_TKH_SETUJU_SASARAN ,ROWIDTOCHAR(SN_PT_KPI_DTL.ROWID) as R_ID 
	 		FROM SN_PT_KPI_DTL,SN_PT_KPI_HDR WHERE KPD_NOSTAF=KPH_NOSTAF AND  KPD_TAHUN=KPH_TAHUN AND
			KPD_NOSTAF='$nogaji' AND KPD_TAHUN='$tahun'";

	 $sql.=" ORDER BY KPD_CREATED_DATE ASC";  
	 $query = OCIParse($c,$sql);
     OCIExecute($query,OCI_DEFAULT);
	 $reccnt=0;
	 $jum_wajaran=0;
     while (OCIFetch($query)){
	    $reccnt++;
		$kpi = ociresult($query,"KPD_PENUNJUK_PRESTASI");
		$sasaran = ociresult($query,"KPD_SASARAN");
		$wajaran = ociresult($query,"KPD_PERATUS_WAJARAN");
		$tkh_setuju = ociresult($query,"KPH_TKH_SETUJU_SASARAN");
		$r_id = ociresult($query,"R_ID");
		
		$jum_wajaran = $jum_wajaran + $wajaran;
		
		
        echo "<tr bgcolor=\"#FFFFFF\"><td valign=\"top\" height=\"20\" align=\"left\">$reccnt.&nbsp;$kpi</td>
									  <td valign=\"top\" align=\"left\">$sasaran</td>";
        echo "                        <td  valign=\"top\" align=\"center\">$wajaran</td>";
		if ($tkh_setuju<>"" or $tutup_kpi=="1")
		  echo "<td valign=\"top\">Tutup&nbsp;</td></tr>";
		else
          echo "<td valign=\"top\"><a href=\"$modname&task=penilaian_prestasi_detail_B1&id=".urlencode($r_id)."\"><img src=\"images/admin/btn_edit.gif\" alt=\"Kemaskini\"></a>&nbsp;
		  <a href=\"$modname&task=penilaian_prestasi&hapus=1&id=".urlencode($r_id)."\" onClick=\"return confirm('Hapuskan rekod ini?');\"><img src=\"images/admin/btn_delete.gif\" alt=\"Hapus\"></a></td></tr>";

     }								
        echo "<tr bgcolor=\"#FFFFFF\"><td height=\"20\" align=\"center\"><strong>JUMLAH (B1)</strong></td>";
		echo "							<td align=\"left\">&nbsp;</td>";
        echo "                     		<td align=\"center\">&nbsp;$jum_wajaran</td>";
		echo "							<td>&nbsp;</td></tr>";
								
?>
                          <tr> 
                            <td colspan="6" bgcolor="#FFFFFF">
						<?php if ($tutup_kpi=="0"){ ?>
							<input type="button" name="Tambah2" value="Tambah KPI" onClick="location.href='mainpage.php?module=HRISOnline&task=penilaian_prestasi_detail_B1';">
                         <?php  } ?>							
							</td>
                          </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td colspan="6" align="center" bgcolor="#FFFFFF">&nbsp;</td>
                          </tr>
                        </table>
                        <!-- content end -->
                        <hr /> <p> <font color="#0000FF" size="2"><strong><a name="B2"></a>BAHAGIAN 
                          B2: MAKLUMAT PENUNJUK PRESTASI</strong></font></p>
                        <table width="100%" border="0" cellpadding="0" cellspacing=1>
                          <tr> 
                            <td colspan="6">Jika staf menunjukkan prestasi yang 
                              melebihi sasaran (seperti menerbitkan artikel melebihi 
                              sasaran dan di dalam jurnal yang berwasit) dan/atau 
                              melaksanakan aktiviti lain yang menguntungkan universiti, 
                              markah bonus boleh diberikan kepada staf tersebut 
                              dengan syarat kedua-dua pegawai bersetuju. Butir 
                              terperinci berkenaan pencapaian staf perlu dimasukkan 
                              di dalam ruang di bawah.</td>
                          </tr>
                          <tr> 
                            <td colspan="6">
						<?php if ($tutup_kpi=="0"){ ?>
							<input type="button" name="Tambah" value="Tambah Aktiviti/Pencapaian" onClick="tambah_pencapaian('<?php echo $peratus_wajaran; ?>');">
					    <?php } ?>
						</td>
                          </tr>
                          <tr> 
                            <td> <table width="100%" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
                                <tr height="20" bgcolor="#00CCFF"> 
                                  <th width="525" >Maklumat berkenaan aktiviti 
                                    dan pencapaian</th>
                                  <th width="40">Tindakan&nbsp;</th>
                                </tr>
                                <?php
		// select statement
     $sql="SELECT BON_AKT_PENCAPAIAN,KPH_TKH_SETUJU_SASARAN,ROWIDTOCHAR(SN_PT_MARK_BONUS.ROWID) as R_ID  
	 		FROM SN_PT_MARK_BONUS,SN_PT_KPI_HDR WHERE BON_NOSTAF=KPH_NOSTAF AND  BON_TAHUN=KPH_TAHUN AND
			BON_NOSTAF='$nogaji' AND BON_TAHUN='$tahun'";

	 $sql.=" ORDER BY BON_CREATED_DATE ASC";  
	 $query = OCIParse($c,$sql);
     OCIExecute($query,OCI_DEFAULT);
	 $reccnt=0;
     while (OCIFetch($query)){
	    $reccnt++;
		$kpi2 = ociresult($query,"BON_AKT_PENCAPAIAN");
		$tkh_setuju = ociresult($query,"KPH_TKH_SETUJU_SASARAN");
		$r_id= ociresult($query,"R_ID");
	  	

        echo "<tr bgcolor=\"#FFFFFF\"><td valign=\"top\" width=\"525\" height=\"20\" align=\"left\">$reccnt.&nbsp;$kpi2</td>";
		if ($tkh_setuju<>"" or $tutup_kpi=="1")
		  echo "<td valign=\"top\">Tutup&nbsp;</td></tr>";
		else
          echo "<td valign=\"top\"><a href=\"$modname&task=penilaian_prestasi_detail_B2&id=&id=".urlencode($r_id)."\"><img src=\"images/admin/btn_edit.gif\" alt=\"Kemaskini\"></a>&nbsp;
		   <a href=\"$modname&task=penilaian_prestasi&hapus=2&id=".urlencode($r_id)."\" onClick=\"return confirm('Hapuskan rekod ini?');\"><img src=\"images/admin/btn_delete.gif\" alt=\"Hapus\"></a></td></tr>";
		}
								
		if ($reccnt==0){
        echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"4\" align=\"center\">&nbsp;TIADA MAKLUMAT LAGI !!</td></tr>";
		}

?>
                          <tr> 
                            <td colspan="6" bgcolor="#FFFFFF">
							<?php if ($tutup_kpi=="0"){ ?>
							<input type="button" name="Tambah" value="Tambah Aktiviti/Pencapaian" onClick="tambah_pencapaian('<?php echo $peratus_wajaran; ?>');">
						    <?php } ?>
							</td>
                          </tr>
                              </table></td>
                          </tr>
                        </table>
                        <hr /> 
                        <table width="100%" border="0" cellpadding="0" cellspacing=1>
						<?php
						if ($tkh_setuju<>""){
		  					echo "<tr><td colspan=\"4\" height=\"30\">KPI &amp; sasaran telah dipersetujui dan ditandatangani bersama pada &nbsp;&nbsp;<strong>$tkh_setuju</strong></td></tr>";
		  					echo "<tr><td colspan=\"2\" height=\"30\">Nama Pegawai Dinilai </td><td colspan=\"2\" height=\"30\">:&nbsp;&nbsp;$nama  </td></tr>";
		  					echo "<tr><td colspan=\"2\" height=\"30\">Nama Penilai Pertama </td><td colspan=\"2\" height=\"30\">:&nbsp;&nbsp;$nama_ppp  </td></tr>";
		  					echo "<tr><td colspan=\"2\" height=\"30\">Nama Penilai Kedua </td><td colspan=\"2\" height=\"30\">:&nbsp;&nbsp;$nama_ppk  </td></tr>";
						}
                          ?>
				  </table>
				  </TD>
                    </TR>
                  </table>
				  </td>
              </tr>
            </table> </td>
        </tr>
      </table></td><td background="images/bar_organizer/right_bg.gif">&nbsp;</td>
  </tr>
  <tr> 
    <td height="9"><img src="images/bar_organizer/bottom_left.gif" width="13" height="9"></td>
    <td background="images/bar_organizer/bottom_bg.gif"></td>
    <td><img src="images/bar_organizer/bottom_right.gif" width="13" height="9"></td>
  </tr>
</table>
<?php
  OCILogoff($c);
?>  