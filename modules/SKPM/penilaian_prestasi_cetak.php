<?
	global $username; //=$_SESSION["username"];
	global $dbi;
	global $modname;
	include("conn_oracle.php");
	
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

     $qry = OCIParse($c,"SELECT GRJ_KOD_BORANG FROM SN_KD_GRED_JAWATAN,SN_PA_SUMM_KHIDMAT
	                     WHERE GRJ_KOD_GRED_JWTN=RKH_GRED_HAKIKI
						 AND RKH_NOSTAF='$nogaji'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry))
		$kod_borang =  ociresult($qry,"GRJ_KOD_BORANG"); 
     	 
     //end maklumat staf
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

     $qry = OCIParse($c,"SELECT EMP_NAME FROM RESEARCH_MANAGE_IS_V WHERE EMP_NO='$nostaf_ppp'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$nama_ppp = ociresult($qry,"EMP_NAME");
     }	 

     $qry = OCIParse($c,"SELECT EMP_NAME FROM RESEARCH_MANAGE_IS_V WHERE EMP_NO='$nostaf_ppk'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$nama_ppk = ociresult($qry,"EMP_NAME");
     }	 

     //end maklumat PPP and PPK

     $qry = OCIParse($c,"SELECT to_char(ADP_TKH_MULA_UMPORTAL,'yyyymmdd') AS TKH_MULA,to_char(ADP_TKH_TAMAT_UMPORTAL,'yyyymmdd') AS TKH_TAMAT FROM SN_PT_ADMIN_PTJ WHERE ADP_NOSTAF='$nogaji' AND ADP_TAHUN='$tahun'");
     OCIExecute($qry,OCI_DEFAULT);
     if (OCIFetch($qry)){
	 	$tkh_mula = ociresult($qry,"TKH_MULA");
	 	$tkh_tamat = ociresult($qry,"TKH_TAMAT");
     }	 
	$tkh = strtoupper(date("Ymd"));
	
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
        <tr> 
          <td>
		    <table width="100%" border="0" align="center">
              <tr> 
                <td> 
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
				   <tr><td align="right"><strong>BORANG <?php echo $kod_borang; ?></strong>&nbsp;&nbsp;</td>
				   </tr>
                    <tr>						
                      <td><div align="center"><font size="2"><strong>LAPORAN PENILAIAN 
                          PRESTASI<br>
                          TAHUN <?php echo $tahun ?></strong></font></div></td>
					</tr>
					<tr> 
                      <td vAlign=top bgColor=#F8F8F8 colspan="3" width="100%"> 
                        <p> <font color="#0000FF" size="2"><strong>BAHAGIAN A: 
                          MAKLUMAT STAF</strong></font></p>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
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
                            <td >&nbsp;</td>
                            <td width=104><strong> PPP</strong></td>
                            <td>:</td>
                              <td colspan="6" valign="baseline">&nbsp;<?php echo $nama_ppp ?></td>
                          </tr>
                          <tr> 
                            <td >&nbsp;</td>
                            <td width=104><strong> PPK</strong></td>
                            <td>:</td>
                              <td colspan="6" valign="baseline">&nbsp;<?php echo $nama_ppk ?></td>
                          </tr>
                        </table>
                        <hr /> <p> <font color="#0000FF" size="2"><strong>BAHAGIAN 
                          B1: MAKLUMAT PENUNJUK PRESTASI</strong></font></p>
                        <ul>
                          <li><strong><font color="#000000" size="1">Kolum 1, 
                            2, dan 3 di isi oleh Pegawai Yang Dinilai (PYD) setelah 
                            dipersetujui oleh Ketua Jabatan.</font></strong></li>
                          <li><strong><font color="#000000" size="1">Kolum 4 dan 
                            5 diisikan oleh Pegawai Penilai Pertama (PPP) dan 
                            Pegawai Penilai Kedua (PPK) pada akhir tahun.</font></strong></li>
                        </ul>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                          <tr> 
                            <td> <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="3" >
                                <tr height="20" bgcolor="#00CCFF" > 
                                  <th width="148" rowspan="2" >1. Penunjuk Prestasi 
                                    Utama / KPI</th>
                                  <th width="169" rowspan="2" >2. Sasaran</th>
                                  <th width="84" rowspan="2" >3. Wajaran</th>
                                  <th colspan="2" >4. Markah (1 - 10)</th>
                                  <th colspan="2" >5. Markah Diwajar<br>
                                    Kol(4)/10 x Kol(3)</th>
                                </tr>
                                <tr bgcolor="#00CCFF"> 
                                  <th width="62" >PPP</th>
                                  <th width="69" >PPK</th>
                                  <th width="68" >PPP</th>
                                  <th width="70">PPK</th>
                                </tr>
                                <?php
     $sql="SELECT KPD_PENUNJUK_PRESTASI, KPD_SASARAN,KPD_PERATUS_WAJARAN, KPH_TKH_SETUJU_SASARAN 
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
		
		$jum_wajaran = $jum_wajaran + $wajaran;
		
		
        echo "<tr bgcolor=\"#FFFFFF\" ><td height=\"20\" align=\"left\">$reccnt&nbsp;$kpi</td><td align=\"left\">$sasaran</td>";
        echo "                     <td align=\"center\">$wajaran</td>";
        echo "                          <td align=\"center\">&nbsp;</td>";
        echo "                          <td align=\"left\">&nbsp;</td>";
        echo "                          <td align=\"right\">&nbsp;</td>";
        echo "                          <td align=\"left\">&nbsp;</td>";
     }								
        echo "<tr bgcolor=\"#FFFFFF\"><td height=\"20\" align=\"center\"><strong>JUMLAH (B1)</strong></td>";
		echo "							<td align=\"left\">&nbsp;</td>";
        echo "                     		<td align=\"center\">&nbsp;$jum_wajaran</td>";
        echo "                          <td align=\"center\">&nbsp;</td>";
        echo "                          <td align=\"left\">&nbsp;</td>";
        echo "                          <td align=\"right\">&nbsp;</td>";
        echo "                          <td align=\"left\">&nbsp;</td></tr>";
								
?>
                              </table></td>
                          </tr>
                        </table>
                        <hr /> <p> <font color="#0000FF" size="2"><strong>BAHAGIAN 
                          B2: MAKLUMAT PENUNJUK PRESTASI</strong></font></p>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
                            <td> <table width="100%" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" bgcolor="#CCCCCC">
                                <tr height="20" bgcolor="#00CCFF"> 
                                  <th width="525" rowspan="2" >Maklumat berkenaan aktiviti 
                                    dan pencapaian</th>
                                  <th colspan="2" >Markah Bonus yang <br>diberikan oleh</th>
                                </tr>
                                <tr bgcolor="#00CCFF"> 
                                  <th width="80" >PPP</th>
                                  <th width="69" >PPK</th>
                                </tr>
                                <?php
		// select statement
     $sql="SELECT BON_AKT_PENCAPAIAN,KPH_TKH_SETUJU_SASARAN 
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
	  	

        echo "<tr bgcolor=\"#FFFFFF\"><td width=\"525\" height=\"35\" align=\"left\">$reccnt&nbsp;$kpi2</td>";
        echo "                          <td align=\"center\">&nbsp;</td>";
        echo "                          <td align=\"left\">&nbsp;</td>";
		}
								
		if ($reccnt==0){
        echo "<tr bgcolor=\"#FFFFFF\"><td colspan=\"4\" align=\"center\">&nbsp;TIADA MAKLUMAT LAGI !!</td></tr>";
		}

        echo "<tr bgcolor=\"#FFFFFF\" height=\"35\"><th width=\"525\" align=\"center\">JUMLAH (B2)</th>";
        echo "<th width=\"80\" align=\"left\" >&nbsp;</th>";
        echo "<th width=\"69\" align=\"left\" >&nbsp;</th></tr>";

        echo "<tr bgcolor=\"#FFFFFF\" height=\"35\"><th width=\"525\" align=\"center\">JUMLAH KESELURUHAN <BR> (JUMLAH B1 + B2)</th>";
        echo "<th width=\"80\" align=\"left\">&nbsp;</th>";
        echo "<th width=\"69\" align=\"left\">&nbsp;</th></tr>";

        echo "<tr bgcolor=\"#FFFFFF\" height=\"35\"><th width=\"525\" align=\"center\">JUMLAH PURATA KESELURUHAN <BR>";
		echo " (JUMLAH KESELURUHAN PPP + JUMLAH KESELURUHAN PPK)/2</th>";
        echo "<th width=\"80\" align=\"left\">&nbsp;</th>";
        echo "<th width=\"69\" align=\"left\">&nbsp;</th></tr>";
								
?>
                              </table></td>
                          </tr>
                        </table>
                        <hr /> 
                        <p> <font color="#0000FF" size="2"><strong>BAHAGIAN C: 
                          PENETAPAN KPI DAN SASARAN</strong></font><br>
						  <font color="#000000" size="1"><strong>(Dilengkapkan pada awal tahun penilaian berkenaan)</strong></font></p>
                        <table width="100%" border="0" cellpadding="0" cellspacing=1>
						<?php
						if ($tkh_setuju<>""){
		  					echo "<tr><td colspan=\"4\" height=\"30\">KPI &amp; sasaran telah dipersetujui dan ditandatangani bersama pada &nbsp;&nbsp;<strong>$tkh_setuju</strong></td></tr>";
		  					echo "<tr><td colspan=\"2\" height=\"30\">Nama Pegawai Dinilai </td><td colspan=\"2\" height=\"30\">:&nbsp;&nbsp;$nama  </td></tr>";
		  					echo "<tr><td colspan=\"2\" height=\"30\">Nama Penilai Pertama </td><td colspan=\"2\" height=\"30\">:&nbsp;&nbsp;$nama_ppp  </td></tr>";
		  					echo "<tr><td colspan=\"2\" height=\"30\">Nama Penilai Kedua </td><td colspan=\"2\" height=\"30\">:&nbsp;&nbsp;$nama_ppk  </td></tr>";
						}
						else {
		  					echo "<tr><td colspan=\"4\" height=\"30\">KPI &amp; sasaran dipersetujui bersama pada &nbsp;_________________</td></tr>";
		  					echo "<tr><td height=\"30\">Tandatangan Penilai Pertama</td>";
		  					echo "<td height=\"30\">:&nbsp;_________________</td>";
		  					echo "<td height=\"30\">Tandatangan Penilai Kedua</td>";
		  					echo "<td height=\"30\">:&nbsp;_________________</td></tr>";
		  					echo "<tr><td height=\"30\">Nama Penilai Pertama</td>";
		  					echo "<td height=\"30\">:&nbsp;$nama_ppp</td>";
		  					echo "<td height=\"30\">Nama Penilai Kedua</td>";
		  					echo "<td height=\"30\">:&nbsp;$nama_ppk</td></tr>";
		  					echo "<tr><td height=\"30\">Tandatangan Pegawai Dinilai</td>";
		  					echo "<td colspan=\"3\" height=\"30\">:&nbsp;_________________</td></tr>";
		  					echo "<tr><td height=\"30\">Nama Pegawai Dinilai</td>";
		  					echo "<td colspan=\"3\" height=\"30\">:&nbsp;$nama</td></tr>";

						}
                          ?>
				  </table>
                        <hr /> 
                        <p> <font color="#0000FF" size="2"><strong>BAHAGIAN D: 
                          PENILAIAN PENCAPAIAN KPI DAN SASARAN</strong></font><br>
						  <font color="#000000" size="1"><strong>(Dilengkapkan pada akhir tahun penilaian berkenaan)</strong></font></p>
                        <table width="100%" border="0" cellpadding="0" cellspacing=1>
                          <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
		  				<?php
		  					echo "<tr><td height=\"30\">Tandatangan Pegawai Dinilai</td>";
		  					echo "<td height=\"30\">:&nbsp;_________________</td><td>Tarikh</td><td>:&nbsp;_________________</td></tr>";
		  					echo "<tr><td height=\"30\">Nama Pegawai Dinilai</td>";
		  					echo "<td colspan=\"3\" height=\"30\">:&nbsp;$nama</td></tr>";
							
		  					echo "<tr><td height=\"30\">Tandatangan Penilai Pertama</td>";
		  					echo "<td height=\"30\">:&nbsp;_________________</td><td>Tarikh</td><td>:&nbsp;_________________</td></tr>";
		  					echo "<tr><td height=\"30\">Nama Pegawai Pertama</td>";
		  					echo "<td colspan=\"3\" height=\"30\">:&nbsp;$nama_ppp</td></tr>";
							
		  					echo "<tr><td height=\"30\">Tandatangan Penilai Kedua</td>";
		  					echo "<td height=\"30\">:&nbsp;_________________</td><td>Tarikh</td><td>:&nbsp;_________________</td></tr>";
		  					echo "<tr><td height=\"30\">Nama Pegawai Kedua</td>";
		  					echo "<td colspan=\"3\" height=\"30\">:&nbsp;$nama_ppk</td></tr>";
							

                        ?>  
						  <tr> 
                            <td colspan="4">&nbsp;</td>
                          </tr>
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
<script type="text/javascript">
//print();
</script>