<?php
// capaian mesti melalui page admin
defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );
include('include/function.php');
$Mfunction = new fungsi();
$limit = 50;
//$_SESSION["kodsek"]="";

global $username;
global $dbi;
$hlcolor= "#AACCF2";
$ncolor="#ffffff";	
$altcolor="#57C9DD";

 function GetDesc($tbl,$ktrgn,$kod,$v)
 {
  $rekod[]=NULL;
  $sql2="select " . $ktrgn . " from " . $tbl ." where " . $kod . "='" . $v . "'";
  $qid2=mysql_query($sql2);
  $rekod=mysql_fetch_row($qid2);		
  return $rekod[0];
 
 }


if(!isset($_GET["limit"]))
   $rowstart = 0;
else
   $rowstart = $_GET["limit"];

unset($_SESSION['kodsek']);
unset($_SESSION['id']);

$kodsekolah=$_SESSION["kodsek"];
$nama=$_REQUEST["nama"];
$kod_cari=$_REQUEST["kod"];
$kodppd=$_SESSION["kodppd"];
$kodnegeri=$_SESSION["negeri"];
$kodjeniscari=$_REQUEST["jenis"];
$role=$_SESSION["userrole"];

//die ("kod ppd=".$kodppd);
//die ("kod negeri=".$kodnegeri);

?>
<table width="100%" class="form_content" border="0" align="center" cellpadding="2" cellspacing="0" >
<form name="frmcarian" method="post" action="mainpage.php?module=Selenggara&task=list_sek">
  <tr> 
    <td align="center" colspan="6" class="form_header">
	<?php 
	if ($role==3) 
		echo "Senarai Sekolah Bagi JPN $kodnegeri - ".GetDesc("tknegeri","Negeri","KodNegeri",$kodnegeri); 
	elseif ($role==4)
		echo "Senarai Sekolah Bagi PPD $kodppd - ".GetDesc("tkppd","PPD","KodPPD",$kodppd);
	elseif ($role==6) 
		echo "Senarai Sekolah Seluruh Malaysia."; 	
	?>
	</td>
  </tr>
<tr><td colspan="5" class="form_label"><b>Carian Sekolah</b></td></tr>
<tr><td class="form_label">Mengikut Kod</td>
<td width="1%" class="form_label">:</td><td width="77%"><input type="text" value="<?php echo $kod_cari; ?>" name="kod" size="40" /></td></tr>
<tr><td class="form_label">Mengikut Nama Sekolah</td>
<td class="form_label">:</td><td><input type="text" value="<?php echo $nama; ?>" name="nama" size="40" /></td></tr>
<tr><td align="center">
	<input type="hidden" value="<?php echo $kodnegeri; ?>" name="negeri" />
	<input type="hidden" value="<?php echo $kodppd; ?>" name="ppd" />
	<input type="submit" class="button" value="Mula Carian" /></td>
      <td colspan="3"><font size="1"><strong>Kosongkan kedua-dua kotak untuk 
        memaparkan semua sekolah</strong></font></td>
    </tr>
</form>
 <?php
	$query = "SELECT KodSekolah, NamaSekolah, KodSesi, GredSekolah,KodJenisSekolah,KodLokasiSemasa FROM tssekolah where 1 ";

if ($kod_cari!="")
   $query.= " and KodSekolah LIKE '%$kod_cari%' ";
if ($nama!="")
   $query.=" AND NamaSekolah LIKE '%$nama%' ";

if($kodppd!="")
  $query.= " AND KodPPD='$kodppd'";

if($kodnegeri!="")
  $query.= " AND KodNegeriJPN='$kodnegeri'";

if($kodjeniscari!="")
  $query.= " AND KodJenisSekolah='$kodjeniscari'";


	$sql2=$query." ORDER BY KodSekolah,NamaSekolah";
	$qid2=sql_query($sql2,$dbi);
	$numrows = sql_num_rows($qid2);

	$query.= " ORDER BY KodSekolah,NamaSekolah LIMIT ".$rowstart.", ".$limit;


 //die ($query);
    $result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	//print $Mfunction->page("mainpage.php?module=Selenggara&task=list_sek&ppd=$kodppd&negeri=$kodnegeri", $limit, $rowstart, $numrows);
	    echo "<tr><td colspan=\"7\"><font size=\"2\">Jumlah Sekolah :&nbsp;&nbsp;<strong>".$numrows."</strong></font></td></tr>";

	
	if($num_rows > 0) {
		echo "<tr><td colspan=\"9\"><table width=\"100%\" class=\"table_header\">";
		echo "<tr><td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Bil</strong></td>
		      <td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Kod Sekolah</strong></td>
			  <td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Nama Sekolah</strong></td>
			  <td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Jenis</strong></td>
			  <td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Sesi</strong></td>
			  <td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Gred</strong></td>
			  <td  height=\"25\" background=\"images/tile_sub.gif\"><strong>Lokasi</strong></td></tr>\n";

		$count=$rowstart;
	    while ($data=sql_fetch_array($result,$dbi)) {
						$kodsek = $data["KodSekolah"];
						$namasekolah = $data["NamaSekolah"];
						$sesi = $data["KodSesi"];
						$gredsekolah = $data["GredSekolah"];
						$kodjenis = $data["KodJenisSekolah"];
						$lokasisemasa = $data["KodLokasiSemasa"];
						$count++;

						
                        echo "<tr bgcolor='$ncolor' onMouseOver=\"this.bgColor = '$hlcolor'\" onMouseOut =\"this.bgColor = '$ncolor'\"> \n";
			            echo "<td>$count</td>";
                        echo "<td ><strong><a href=\"mainpage.php?module=Profail_Sekolah&task=ses&kodsek=$kodsek\">$kodsek</a></strong></td>"; 
                        echo "<td >$namasekolah</td>"; 
                        //echo "<td >".GetDesc("tkjenissekolah","JenisSekolah","KodJenisSekolah",$kodjenis)."</td>";
                        echo "<td >$kodjenis</td>"; 
                        echo "<td >$sesi</td>"; 
                        echo "<td >$gredsekolah</td>"; 
                        echo "<td >$lokasisemasa</td>"; 
                        //echo "<td >".GetDesc("tklokasi","lokasi","kodlokasi",$lokasisemasa)."</td>"; 
				echo "</tr>\n";

					} //end while 
					} 
				echo "</table></td></tr>\n"; 
				echo "<tr><td colspan=\"9\">";
				print $Mfunction->page(	"mainpage.php?module=Selenggara&task=list_sek&ppd=$kodppd&negeri=$kodnegeri&kod=$kod_cari&nama=$nama&jenis=$kodjeniscari", $limit, $rowstart, $numrows);
				echo "</td></tr>";

					?>					
</table>
