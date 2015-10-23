<?php
/*
 * 01-07-2015 cm.choong : created
 * 23-09-2015 cm.choong : dont use *  but use column name
 * 01-10-2015 cm.choong : add isAdmin column
 * 15-10-2015 cm.choong : add gsmRegId
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
 		$userId = $_POST["userId"];
	}else{
		$userId = 1;
	}
	
    $sql =	"SELECT userId, name, username, userContact ". 
			", userEmail, userAvgRatedValue, userJoinDate, isAdmin, gcmRegId ".
			"FROM user ".
    		"WHERE userId = ?";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	

    echo json_encode($data);
	
    
    include 'closedb.php';
?>