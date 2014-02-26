<?php
session_start();
defined( '_UMPORTAL' ) or die( 'Akses tidak dibenarkan !' );

global $dbi;
global $usrrole;
/*
if ($_SESSION["userrole"]==5 or $_SESSION["userrole"]==13) // user role SEKOLAH dan PENGETUA
	pageredirect("mainpage.php?module=LamanUtama&task=stat_sekolah");		   
elseif ($_SESSION["userrole"]==4 or $_SESSION["userrole"]==14) // user role PPD dan PEGAWAI PPD
	pageredirect("mainpage.php?module=LamanUtama&task=stat_ppd");		   
elseif ($_SESSION["userrole"]==3 or $_SESSION["userrole"]==15) // user role JPN dan PENGARAH JPN
	pageredirect("mainpage.php?module=LamanUtama&task=stat_jpn");		   
elseif (($_SESSION["userrole"]==9) or ($_SESSION["userrole"]==10)or ($_SESSION["userrole"]==16)) // user role ketua unit, pegawai unit data, KPM
	pageredirect("mainpage.php?module=LamanUtama&task=stat_pusat");		   
elseif ($_SESSION["userrole"]==8) // user role KERANI (ADUAN)
	pageredirect("mainpage.php?module=ketua_unit");		   
else
*/
	pageredirect("mainpage.php?module=SKPM&task=borangskpm");		   

?>