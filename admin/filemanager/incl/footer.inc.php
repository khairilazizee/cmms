<?php

list($seconds, $microseconds) = explode(" ", microtime());
$time_end = $seconds + $microseconds;
$total_time = round($time_end-$time_start, 4);

print "<br /><br />";

print "</center>";
print "</body>";
print "</html>";

?>