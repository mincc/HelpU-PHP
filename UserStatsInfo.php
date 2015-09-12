<?php
/*
 * 	29-08-2015 cm.choong : created
 *  05-09-2015 cm.choong : Add totalCustomerRequestNotification COUNT
 *  09-09-2015 cm.choong : alreadyReadNotification checking
 */

	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
		$userId = $_POST["userId"];
	}else{
		$userId = 3;
	}
	

	$sql = 	"SELECT COUNT(*) AS totalCustomerRequest ".
			"FROM customerrequest ".
			"WHERE userId=? ".
			"And projectStatusId <> 16"; //Remove from view";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequest'] =  $data;
	}

	$sql = 	"SELECT COUNT(*) AS totalServiceProvider ".
			"FROM serviceprovider ".
			"WHERE userId=?";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalServiceProvider'] =  $data;
	}
	
	$sql = 	"SELECT Count(*) AS totalJobDone ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"WHERE cr.projectStatusId = 15 ".
			"AND cr.serviceProviderId is not null ".
			"AND sp.userId = ? LIMIT 1";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}


	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalJobDone'] =  $data;
	}
	
	$sql = 	"SELECT Count(*) AS totalJobOffer ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"WHERE cr.projectStatusId >= 3 ".
			"AND cr.projectStatusId <> 15 ".
			"AND cr.projectStatusId <> 16 ". //Remove from view";
			"AND cr.serviceProviderId is not null ".
			"AND sp.userId = ? LIMIT 1";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalJobOffer'] =  $data;
	}
	
	$sql = 	"SELECT Count(*) AS totalWorkNotification ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"WHERE ( cr.projectStatusId = 4 ".
			"OR cr.projectStatusId = 9 ".
			"OR cr.projectStatusId = 23 ".
			"OR cr.projectStatusId = 24 ) ".
			"AND cr.serviceProviderId is not null ".
			"AND cr.alreadyReadNotification = 0 ".
			"AND sp.userId = ? LIMIT 1";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalWorkNotification'] =  $data;
	}
	
	$sql = 	"SELECT Count(*) AS totalHireNotification ".
			"FROM customerrequest cr ".
			"WHERE ( cr.projectStatusId = 19 ".
			"OR cr.projectStatusId = 20 ".
			"OR cr.projectStatusId = 21 ".
			"OR cr.projectStatusId = 22 ".
			"OR cr.projectStatusId = 25 ) ".
			"AND cr.serviceProviderId is not null ".
			"AND cr.alreadyReadNotification = 0 ".
			"AND cr.userId = ? LIMIT 1 ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->bind_param('i', $userId);
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalHireNotification'] =  $data;
	}
	
	echo json_encode($result);


	include 'closedb.php';

?>
