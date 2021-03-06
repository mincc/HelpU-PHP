<?php
/*
 * 25-09-2015 cm.choong : created
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 *
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
    	$customerIssueId = $_POST["customerIssueId"];
	}else {
    	$customerIssueId = 1;
	}
	
    $sql = 	"SELECT customerIssueId, userId, subject, description, customerIssueTypeId".
    		", customerIssueStatusId ".
			"FROM customerissue ".
			"WHERE customerIssueId = ? ";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	$stmt->bind_param('i', $customerIssueId);
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	
    echo json_encode($data);
	
    include 'closedb.php';
?>