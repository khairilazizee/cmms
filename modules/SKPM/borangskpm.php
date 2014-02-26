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
if (isInteger(document.frmaddcal.txt_jumprakerajaansekkerajaan.value)==false){
  alert('Bilangan Pelajar - Masukkan nombor sahaja !');
  document.frmaddcal.txt_jumprakerajaansekkerajaan.focus();
  return false;
}
if (document.frmaddcal.txt_jumprakerajaansekkerajaan.value==""){
	alert("Ruangan mesti diisi !");
	document.frmaddcal.txt_jumprakerajaansekkerajaan.focus();
	return false;
}
if (document.frmaddcal.txt_jumprakerajaankemas.value==""){
	alert("Ruangan mesti diisi !");
	document.frmaddcal.txt_jumprakerajaankemas.focus();
	return false;
}


return confirm("Simpan Maklumat anda?");

}
</script>

<?
	defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );
  	global $username,$dbi;

function GetDesc($tbl,$ktrgn,$kod,$v)
 {
  $rekod[]=NULL;
  $sql2="select " . $ktrgn . " from " . $tbl ." where " . $kod . "='" . $v . "'";
  $qid2=mysql_query($sql2);
  $rekod=mysql_fetch_row($qid2);		
  return $rekod[0];
 
 }

$kodsekolah=$_SESSION["kodsek"];
?>

<FORM METHOD="post" name="frmaddcal" ACTION="mainpage.php?module=SKPM&task=borangskpm" >
<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" class="form_content">

  <tr>
           <td colspan="11" class="form_header"><div align="center">RUMUSAN SKOR 
                INSTRUMEN PEMASTIAN STANDARD <br />
              </div></td>
          </tr>
          <tr> 
            <td width="24%" class="form_label">Sekolah</td>
            <td width="2%" class="form_label"><strong>:</strong></td>
            <td width="74%" class="form_readonly"><strong><?php echo $kodsekolah." - ".GetDesc("tssekolah","NamaSekolah","KodSekolah",$kodsekolah); ?></strong></td>
          </tr>
          <tr> 
            <td width="24%" class="form_label">GPS Sekolah</td>
            <td width="2%" class="form_label"><strong>:</strong></td>
            <td width="74%" class="form_readonly"><strong>2.21</strong></td>
          </tr>
          <tr> 
            <td width="24%" class="form_label">Kategori Sekolah</td>
            <td width="2%" class="form_label"><strong>:</strong></td>
            <td width="74%" class="form_readonly"><strong>-- Tiada lagi. --</strong></td>
          </tr>

          <? 
	 $username=$_SESSION["username"];	

	 
?>
          <tr> 
            <td colspan="11" class="form_label"><strong>Arahan :</strong><br>
              Sila isikan pada ruangan SKOR. Jumlah keseluruhan mestilah 100%.</td>
          </tr>
		<tr> 
		  <td colspan="10"><table width="100%">          
		  <tr> 
            <td width="39%" class="form_header" background="images/tile_sub.gif"><div align="center"><strong>DIMENSI</strong></div></td>
            <td width="46%" class="form_header" background="images/tile_sub.gif"><div align="center"><strong>ELEMEN</strong></div></td>
            <td align="left" class="form_header" width="15%" background="images/tile_sub.gif"><div align="center"><strong>SKOR</strong></div></td>
          </tr>
          <tr> 
            <td rowspan="2" class="form_label"><strong><strong>DIMENSI I :</strong> 
              HALA TUJU KEPIMPINAN</strong></td>
            <td class="form_label">E01 : Visi dan Misi</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE01"  value="<?php echo $jumlah_e01 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E02 : Kepimpinan</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE02"  value="<?php echo $jumlah_e02 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2" ><div align="center"><strong>Jumlah 
                DIMENSI I</strong>:</div></td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtJumlahDimensi1" value="<?php echo $jumlah_dimensi1 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td rowspan="5" class="form_label"><strong><strong>DIMENSI II :</strong> 
              PENGURUSAN ORGANISASI</strong></td>
            <td class="form_label">E03 : Struktur Organisasi</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE03"  value="<?php echo $jumlah_e03 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E04 : Perancangan</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE04"  value="<?php echo $jumlah_e04 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E05 : Iklim</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE05"  value="<?php echo $jumlah_e05 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E06 : Pengurusan Sumber</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE06"  value="<?php echo $jumlah_e06 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E07 : Pengurusan Maklumat</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE07"  value="<?php echo $jumlah_e07 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><div align="center"><strong>Jumlah 
                DIMENSI II</strong>:</div></td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtJumlahDimensi2" value="<?php echo $jumlah_dimensi2 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td rowspan="4" class="form_label"><strong><strong>DIMENSI III :</strong> 
              PENGURUSAN PROGRAM PENDIDIKAN</strong></td>
            <td class="form_label">E08 : Pengurusan Program Kurukulum, Kokurikulum & HEM</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE08"  value="<?php echo $jumlah_e08 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E09 : Pengajaran dan Pembelajaran</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE09"  value="<?php echo $jumlah_e09 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E10 : Pembangunan Sahsiah Murid</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE10" value="<?php echo $jumlah_e10 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td class="form_label">E11 : Penilaian Pencapaian Murid</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE11"  value="<?php echo $jumlah_e11 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><div align="center"><strong>Jumlah 
                DIMENSI III</strong>:</div></td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtJumlahDimensi3" value="<?php echo $jumlah_dimensi3 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr> 
            <td rowspan="1" class="form_label"><strong><strong>DIMENSI IV :</strong> 
              KEMENJADIAN MURID</strong></td>
            <td class="form_label">E12 : Kemenjadian Murid Dalam Akademik, Kokurikulum dan Sahsiah</td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtE12"  value="<?php echo $jumlah_e12 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><div align="center"><strong>Jumlah 
                DIMENSI IV :</strong></div></td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtJumlahDimensi4" value="<?php echo $jumlah_dimensi4 ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><div align="center"><strong>JUMLAH BESAR SKPM :
                </strong></div></td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtJumlahSKPM" value="<?php echo $jumlah_skpm ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><div align="center"><strong>KOMPOSIT SKOR : </strong><br>
                (Jumlah Besar SKPM x 0.3) + (GPS x 0.7)</div></td>
            <td colspan="2" align="left" ><div align="right">
                <input name="txtKomposit" value="<?php echo $jumlah_komposit ?>" type="text" size="20" maxlength="20" >
              </div></td>
          </tr>
          <tr bgcolor="#CCCCCC"> 
            <td colspan="2"><div align="center"><strong>KATEGORI SEKOLAH TERKINI : </strong><br>
                </div></td>
            <td colspan="2" align="left" class="form_readonly"><div align="right">&nbsp;
                
              </div></td>
          </tr>

          <tr> 
            <td class="form_label" colspan="8" align="center" >&nbsp;</td>
          </tr>
		 </table></td></tr>
          <tr> 
            <td colspan="8" align="center" ><input type="hidden" value="<? echo $addnewbio; ?>" name="addnewbio" /> 
              <input type="submit" value="Simpan" class="button" onclick="return semak();" /> 
              <input type="reset" value="Reset" class="button" /> <input type="button" value="<< Kembali" class="button" onclick="location.href='mainpage.php?module=LamanUtama';" /></td>
          </tr>
        </table>
</form>


