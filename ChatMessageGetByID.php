<?php
/*
 * 	19-10-2015 cm.choong : created
 *	20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
    	$chatMessageId = $_POST["chatMessageId"];
	}else {
    	$chatMessageId = 1;
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
	$data = fetchRow($stmt);
	
    echo json_encode($data);
	
    include 'closedb.php';
?>