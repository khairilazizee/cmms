<?php
global $dbi;
	$query = "SELECT KodSekolah,NamaSekolah FROM tssekolah";
	$result = sql_query($query,$dbi);
	$num_rows = sql_num_rows($result);
	if($num_rows > 0) {
		$cnt=1;
		while($data=sql_fetch_array($result,$dbi)){ 
		  	$kodsek = $data["KodSekolah"];
		  	$login = "PGB".$data["KodSekolah"];
			$namasekolah=mysql_escape_string($data["NamaSekolah"]);
 			$password='12345678';
			$query2 = "SELECT login FROM user where login='$kodsek'";
			$result2 = sql_query($query2,$dbi);
			$num_rows2 = sql_num_rows($result2);
			if($num_rows2 == 0) { // user belum ada lagi
		    	$qry="INSERT INTO `user` (id,`login`,`password`,`role`,`nama`,`kodsek`) 
				 	VALUES ('','$login',md5($password),5,'$namasekolah','$kodsek')";
 				echo "$cnt - $kodsek $namasekolah<br>";
 				//echo "$cnt - $qry<br>";				
				$cnt++;
				sql_query($qry,$dbi);
			} else {
				echo "$cnt - $kodsek $namasekolah - USER INI TELAH WUJUD.<br>";
				$cnt++;
			}
		}
	}

?>