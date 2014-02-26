<?php
//if (eregi("block-Calendar.php", $PHP_SELF)) {
//    Header("Location: index.php");
//    die();
//}

$index = 1;
$boxstuff = "\n<script type=\"text/javascript\" src=\"jscript/basiccalendar.js\"></script>\n";
$boxstuff .= "<form name=\"frmcal\"><input type=\"hidden\" name=\"mth\" size=\"2\"><input type=\"hidden\" name=\"yr\" size=\"4\"></form>\n
              <div id=\"calendarspace\">\n
             <script type=\"text/javascript\">\n
             var todaydate=new Date();\n
             var curmonth=todaydate.getMonth()+1; //get current month (1-12) \n
             var curyear=todaydate.getFullYear(); //get current year\n
			 updatecalendar(curmonth,curyear);\n
             </script>\n
			 </div>";
$boxstuff .= "
             <script type=\"text/javascript\">\n
			 if (document.frmcal.mth.value=='')\n
			   document.frmcal.mth.value=curmonth;\n
			 if (document.frmcal.yr.value=='')\n
			   document.frmcal.yr.value=curyear;\n
			 </script>\n
               <table bgcolor=\"#E8EFFC\" width=\"100%\"><tr>
			   <td align=\"left\"><a href=\"javascript: document.frmcal.mth.value=parseInt(document.frmcal.mth.value)-1; if (document.frmcal.mth.value<1){document.frmcal.mth.value=12;document.frmcal.yr.value=parseInt(document.frmcal.yr.value)-1;} updatecalendar(document.frmcal.mth.value,document.frmcal.yr.value);\"><img src=\"images/left-arrow.gif\"></a></td>\n
			   <td align=\"center\"><a href=\"javascript: document.frmcal.mth.value=curmonth;document.frmcal.yr.value=curyear;updatecalendar(curmonth,curyear);\"><img src=\"images/up-arrow.gif\"></a></td>\n
			   <td align=\"right\"><a href=\"javascript: document.frmcal.mth.value=parseInt(document.frmcal.mth.value)+1; if (document.frmcal.mth.value>12){document.frmcal.mth.value=1;document.frmcal.yr.value=parseInt(document.frmcal.yr.value)+1;} updatecalendar(document.frmcal.mth.value,document.frmcal.yr.value);\"><img src=\"images/right-arrow.gif\"></a></td>\n
			   </tr></table>";
$content = $boxstuff;
?>
