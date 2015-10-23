<?php
/*
 * 	21-08-2015 cm.choong : created
 *  21-09-2015 cm.choong : update the existing if previously record create
 *  20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
	    $userId = $_POST["userId"];
	    $serviceId = $_POST["serviceId"];
	    $phone = $_POST["phone"];
	    $email = $_POST["email"];
	}else{
		$userId = 97;
		$serviceId = 1;
		$phone = "0121111111";
		$email = "test@gmail.com";
	}
	
	$sql = 	"SELECT serviceProviderId ".
			"FROM serviceprovider ".
			"WHERE userId = ? ".
			"AND serviceId = ? ".
			"AND isDelete = 1 ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	
	$stmt->bind_param('ii', $userId, $serviceId);
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);

	if (mysqli_real_escape_string($con, $data["serviceProviderId"])==null) {
		
		//result no exist
		$sql = 	"INSERT INTO serviceprovider (userId, serviceId, phone, email) ".
				"VALUES (?, ?, ?, ?)";
		$statement = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($statement, "iiss", $userId, $serviceId, $phone, $email);
		
	} else {
		
		//result exist
		$sql = 	"UPDATE serviceprovider ".
			 	"SET isDelete = 0 ".
			 	", phone = ? ".
			 	", email = ? ".
				"WHERE serviceProviderId = ? ";
		$statement = mysqli_prepare($con, $sql);
		mysqli_stmt_bind_param($statement, "ssi", $phone, $email, $data["serviceProviderId"]);
		
	}
		

	mysqli_stmt_execute($statement);
    mysqli_stmt_close($statement);
    
    include 'closedb.php';
?>