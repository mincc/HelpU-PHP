<?php
	include 'config.php';
	include 'opendb.php';
	 
	// Check connection
	if(mysqli_connect_errno($con)) {
		die("Failed to connect to MySQL: " . mysqli_connect_error());
	}
	 
	// query the application data
	$sql = "SELECT * FROM app_data ORDER By id";
	$result = mysqli_query($con, $sql);
	 
	// an array to save the application data
	$rows = array();
	 
	// iterate to query result and add every rows into array
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$rows[] = $row;
	}
	 
	// close the database connection
	include 'closedb.php';
	 
	// echo the application data in json format
	echo json_encode($rows);
?>