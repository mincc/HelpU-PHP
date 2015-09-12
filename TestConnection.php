<?php
	if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
		echo 'Hello World POST<br/>';
	}else if ( $_SERVER['REQUEST_METHOD'] === 'GET') {
		echo 'Hello World GET<br/>';
	}
	
	echo 'Hello World<br/>';
	
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	echo $username;
	echo "<br/>";
	echo $password;
	echo "<br/>";		

?>