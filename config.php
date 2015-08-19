<?php
	if ($_SERVER['HTTP_HOST'] == "helpu.hostei.com") {
		$dbhost = "mysql10.000webhost.com";
		$dbuser = "a7159820_mincc";
		$dbpass = "Password123";
		$dbdatabase = "a7159820_helpu";
	}if($_SERVER['HTTP_HOST'] == "helpu.comuf.com") {
		$dbhost = "mysql5.000webhost.com";
		$dbuser = "a5665104_mincc";
		$dbpass = "Password123";
		$dbdatabase = "a5665104_helpu";
	}
	else{
		$dbhost = "localhost";
		$dbuser = "root";
		$dbpass = "Password123";
		$dbdatabase = "a7159820_helpu";
	}
	// echo $dbhost;
	// echo "<br>";
	// echo $dbuser;
	// echo "<br>";
	// echo $dbpass;
	// echo "<br>";
	// echo $dbdatabase;
	
	$debug = false;
	
?>
