<?php
/*
 * 22-09-2015 cm.choong : created
 * 23-09-2015 cm.choong : retrieve user info
 * 01-10-2015 cm.choong : add isAdmin column
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug)
	{
		$email = $_POST["email"];
	    $newPassword = $_POST["newPassword"];
	}else{
		$email = "test@gmail.com";
		$newPassword = "Password1234";
	}
	
 	$sql=	"UPDATE user ".
			"SET password = ? ".
			"WHERE userEmail = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	
	$stmt->bind_param('ss', $newPassword, $email);
	$stmt->execute();
	
	$sql = 	"SELECT userId, name, username, userContact ". 
			", userEmail, userAvgRatedValue, userJoinDate, isAdmin ".
			"FROM user ".
			"WHERE userEmail = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('s', $email);

	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);

	echo json_encode($data);
	
    include 'closedb.php';
?>