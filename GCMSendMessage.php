<?php
/*
 * 19-10-2015 cm.choong : created
 *
 * */
 
	include_once './GCM.php';
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
		$chatMessageId = $_POST["chatMessageId"];
	}else{
		$chatMessageId = 10;
	}
	
	$sql = 	"SELECT chatMessageId, id, message, userIdFrom, userIdTo, createdDate".
			", isDelete ".
			"FROM chatmessage ".
			"WHERE chatMessageId = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	$stmt->bind_param('i', $chatMessageId);
	$stmt->execute();
	$stmt->store_result();
	$chatMessageRecord = fetchRow($stmt);
	
	$userIdFrom = $chatMessageRecord['userIdFrom'];
	$sql =	"SELECT name ".
			"FROM user ".
			"WHERE userId = ?";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
	$stmt->bind_param('i', $userIdFrom);

	//Execute statement
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);

	//sender info
	$userNameFrom =  $data['name'];
	
	$userIdTo = $chatMessageRecord['userIdTo'];
	$sql =	"SELECT name, gcmRegId ".
			"FROM user ".
			"WHERE userId = ?";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
	$stmt->bind_param('i', $userIdTo);

	//Execute statement
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	
	//receiver info
	$regId = $data['gcmRegId'];
	$userNameTo =  $data['name'];
	$message = $chatMessageRecord['message'];
		
	if (isset($regId) && isset($message)) {
		
		$registatoinId = array($regId);
		$message = array(
				"message" => $message, 
				"notificationType" => "Message", 
				"userNameFrom" => $userNameFrom,
				"userNameTo" => $userNameTo,
				"jsonInfo" => $chatMessageRecord
		);
		
		$gcm = new GCM();
		$result = $gcm->sendPushNotification($registatoinId, $message);
	
		echo $result;
	}
?>