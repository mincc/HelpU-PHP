<?php
/*
 * 	01-07-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug){
   	 	$username = $_POST["username"];
    	$password = $_POST["password"];
	}else{
	 	$username = "cm.choong";
		$password = "Password123";
	}
	
    $sql = 	"SELECT * FROM user WHERE username = ? AND password = ?";
    
    //Prepare statement
    $stmt = $con->prepare($sql);
    if($stmt === false) {
    	trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
    
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
 	$stmt->bind_param('ss', $username, $password);
    
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
    
    echo json_encode($data);
	
    include 'closedb.php';
?>