<?php
/*
 * 01-07-2015 cm.choong : created
 * 23-09-2015 cm.choong : dont use *  but use column name
 * 01-10-2015 cm.choong : add isAdmin, login column
 * 15-10-2015 cm.choong : add gcmRegId
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
   	 	$username = $_POST["username"];
    	$password = $_POST["password"];
	}else{
	 	$username = "cm.choong";
		$password = "Password123";
	}
	
	$sql=	"UPDATE user ".
			"SET login = ? ".
			"WHERE username = ? ".
    		"AND password = ? ";

	$currDateTime = date('Y-m-d G:i:s');
	$stmt = $con->prepare($sql);
	$stmt->bind_param('sss', $currDateTime, $username, $password);
	$stmt->execute();
	
    $sql = 	"SELECT userId, name, username, userContact ". 
			", userEmail, userAvgRatedValue, userJoinDate, isAdmin, gcmRegId ".
      		"FROM user ".
    		"WHERE username = ? ".
    		"AND password = ? ";
    
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