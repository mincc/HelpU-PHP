<?php
	if ($_SERVER['HTTP_HOST'] == "helpu.hostei.com") {
		$dbhost = "mysql10.000webhost.com";
		$dbuser = "a7159820_mincc";
		$dbpass = "Password123";
		$dbdatabase = "a7159820_helpu";
	}else if($_SERVER['HTTP_HOST'] == "helpu.comuf.com") {
		$dbhost = "mysql5.000webhost.com";
		$dbuser = "a5665104_mincc";
		$dbpass = "Password123";
		$dbdatabase = "a5665104_helpu";
	}else if($_SERVER['HTTP_HOST'] == "helpu.hostingsiteforfree.com") {
		$dbhost = "mysql.1freehosting.com";
		$dbuser = "u539419275_mincc";
		$dbpass = "Password123";
		$dbdatabase = "u539419275_helpu";
	}else if($_SERVER['HTTP_HOST'] == "helpu.byethost33.com") {
		$dbhost = "sql101.byethost33.com";
		$dbuser = "b33_16450480";
		$dbpass = "Password123";
		$dbdatabase = "b33_16450480_HelpU";
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

	date_default_timezone_set("Asia/Kuala_Lumpur");
	
	/*
	 * Google API Key
	 */
	if (!defined('GOOGLE_API_KEY'))
		define("GOOGLE_API_KEY", "AIzaSyCgzCdApBDAKgQII-zMJRFqHHBFZEt__tg"); // Place your Google API Key
?>
