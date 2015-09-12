<?php
/*
 * 	21-08-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug){
    	$username = $_POST["username"];
	}else{
		$username = "cm.choong";
	}
	
    $sql = 	"SELECT userId ". 
			"FROM user ".
			"WHERE username = ? LIMIT 1";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	

	$stmt->bind_param('s', $username);
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	
	if (mysqli_real_escape_string($con, $data["userId"])==null) {
		//result no exist
		$result = (array('result' => false));
	} else {
		//result exist	
		$result = (array('result' => true));
	}

    echo json_encode($result);
	
    
    include 'closedb.php';
?>