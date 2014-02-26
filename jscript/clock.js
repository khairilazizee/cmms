var monat = new Array("Januari","Februari","Mac","April","Mei","Jun","Julai","Ogos","September","Oktober","November","Disember");

function clock() {
var digital = new Date();
var hours = digital.getHours();
var minutes = digital.getMinutes();
var seconds = digital.getSeconds();
var m = digital.getMonth();

var amOrPm = "AM";
if (hours > 11) amOrPm = "PM";
if (hours > 12) hours = hours - 12;
if (hours == 0) hours = 12;
if (minutes <= 9) minutes = "0" + minutes;
if (seconds <= 9) seconds = "0" + seconds;

dispTime = digital.getDate()+" "+monat[ m ]+" "+digital.getFullYear()+", "+hours + ":" + minutes + ":" + seconds + " " + amOrPm;
dispTime = "<font color=#000000>&nbsp;&nbsp;" + dispTime + " &nbsp;&nbsp;</font>";
//dispTime = '<b>'+hours + ":" + minutes + ":" + seconds + " " + amOrPm+'</b>';

document.getElementById('pendule').innerHTML = dispTime;
setTimeout("clock()", 1000);
}
