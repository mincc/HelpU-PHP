<?php
/*
 * 	01-07-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
    	$userId = $_POST["userId"];
	}else{
		$userId = 3;
	}
	
    $sql = "SELECT COUNT(*) AS Total FROM serviceprovider WHERE userId=?";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();

	$stmt->bind_result($data);
	
	/* fetch values */
	while ($stmt->fetch()) {
		$data = (array('Total' => $data));
	}
	
    echo json_encode($data);
	
    
    include 'closedb.php';
?>