<?php
/*
 * 18-08-2015 cm.choong : created
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
		$customerRequestId = $_POST["customerRequestId"];
		$ratingType = $_POST["ratingType"];
    	$targetUserId = $_POST["targetUserId"];
	}else{
		$customerRequestId = 44;
		$ratingType = "s"; //represent customer rate the service provider
		$targetUserId = 3;
	}
	
	// get service Id
	$sql = 	"SELECT serviceId ".
			"FROM customerrequest ".
			"WHERE customerRequestId = ? ";
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('i', $customerRequestId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$serviceId = $data;
	}
	
	// get total sum ratingValue
	$sql = 	"SELECT SUM(r.ratingValue) ".
			"AS TotalRatingValue ".
    		"FROM rating r ".
    		"INNER JOIN customerrequest cr ".
    		"ON r.customerRequestId = cr.customerRequestId ".
    		"WHERE ratingType = ? ".
    		"AND cr.serviceId = ? ".
			"AND r.targetUserId = ? "; 
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('sii', $ratingType, $serviceId, $targetUserId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$TotalRatingValue = $data;
	}
	
	// get total record for ratingValue
	$sql = 	"SELECT COUNT(r.ratingValue) ".
			"AS TotalRatingValue ".
			"FROM rating r ".
			"INNER JOIN customerrequest cr ".
			"ON r.customerRequestId = cr.customerRequestId ".
			"WHERE ratingType = ? ".
			"AND cr.serviceId = ? ".
			"AND r.targetUserId = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
	$stmt->bind_param('sii', $ratingType, $serviceId, $targetUserId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$TotalCountRecord = $data;
	}
	
	//default value for every rating give 2.5 point
	$result = ( $TotalRatingValue + 2.5 ) / ( $TotalCountRecord + 1);
	$data = (array('AvgRatingValue' => $result));
	
	//Update the service provider rating value
	$sql = 	"UPDATE serviceprovider ".
			"SET avgRatedValue = ? ".
			"WHERE serviceId = ? ".
			"AND userId = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
	$stmt->bind_param('dii', $result, $serviceId, $targetUserId);
	$stmt->execute();
	
	if($debug){
		echo $serviceId;
		echo "<br>";
		echo $TotalRatingValue;
		echo "<br>";
		echo $TotalCountRecord;
		echo "<br>";
	}
	
    echo json_encode($data);
    
	include 'closedb.php';
?>