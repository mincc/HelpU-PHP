<?php
/*
 * 22-09-2015 cm.choong : created
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug)
	{
		$userId = $_POST["userId"];
	    $currentPassword = $_POST["currentPassword"];
	    $newPassword = $_POST["newPassword"];
	}else{
		$userId = 3;
		$currentPassword = "Password1234";
		$newPassword = "Password123";
	}
	
	$sql = 	"SELECT userId ".
			"FROM user ".
			"WHERE userId = ? ".
			"AND password = ? LIMIT 1";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	
	$stmt->bind_param('is', $userId, $currentPassword);
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);

	if (mysqli_real_escape_string($con, $data["userId"])==null) {
		//result no exist
		$result = (array('result' => false));
	} else {
		//result exist
	 	$sql=	"UPDATE user ".
				"SET password = ? ".
				"WHERE userId = ? ";
	 	
	 	$statement = mysqli_prepare($con, $sql);
	 	mysqli_stmt_bind_param($statement, "si",$newPassword, $userId);
	 	mysqli_stmt_execute($statement);
	 	mysqli_stmt_close($statement);
	 	
	 	$result = (array('result' => true));
	}
	
	echo json_encode($result);
	
    include 'closedb.php';
?>