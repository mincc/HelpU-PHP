<?php
/*
 * 	01-09-2015 cm.choong : created
 */

	include 'config.php';
	include 'opendb.php';

	$sql = 	"SELECT COUNT(*) AS totalCustomerRequestInOneDay ".
			"FROM customerrequest ".
			"WHERE createdDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequestInOneDay'] =  $data;
	}

	$sql = 	"SELECT COUNT(*) AS totalCustomerRequestInOneWeek ".
			"FROM customerrequest ".
			"WHERE createdDate ".
			"BETWEEN DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) ".
    		"AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequestInOneWeek'] =  $data;
	}
	
	$sql = 	"SELECT COUNT(*) AS totalCustomerRequestInOneMonth ".
			"FROM customerrequest ".
			"WHERE createdDate ".
			"BETWEEN DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) ".
			"AND LAST_DAY(NOW()) ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequestInOneMonth'] =  $data;
	}
	
	$sql = 	"SELECT COUNT(*) AS totalServiceProviderInOneDay ".
			"FROM serviceprovider ".
			"WHERE createdDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalServiceProviderInOneDay'] =  $data;
	}
	
	$sql = 	"SELECT COUNT(*) AS totalServiceProviderInOneWeek ".
			"FROM serviceprovider ".
			"WHERE createdDate ".
			"BETWEEN DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) ".
			"AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalServiceProviderInOneWeek'] =  $data;
	}
		
	$sql = 	"SELECT COUNT(*) AS totalServiceProviderInOneMonth ".
			"FROM serviceprovider ".
			"WHERE createdDate ".
			"BETWEEN DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) ".
			"AND LAST_DAY(NOW()) ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalServiceProviderInOneMonth'] =  $data;
	}
	
	$sql = 	"SELECT COUNT(*) AS totalCustomerRequestDoneInOneDay ".
			"FROM customerrequest ".
			"WHERE createdDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ".
			"AND projectStatusId = 15 ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequestDoneInOneDay'] =  $data;
	}

	$sql = 	"SELECT COUNT(*) AS totalCustomerRequestDoneInOneWeek ".
			"FROM customerrequest ".
			"WHERE createdDate ".
			"BETWEEN DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) ".
			"AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) ".
			"AND projectStatusId = 15 ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequestDoneInOneWeek'] =  $data;
	}

	$sql = 	"SELECT COUNT(*) AS totalCustomerRequestDoneInOneMonth ".
			"FROM customerrequest ".
			"WHERE createdDate ".
			"BETWEEN DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) ".
			"AND LAST_DAY(NOW()) ".
			"AND projectStatusId = 15 ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalCustomerRequestDoneInOneMonth'] =  $data;
	}
	
	$sql = 	"SELECT COALESCE( SUM(quotation), 0) AS totalQuotationInOneDay ".
			"FROM customerrequest ".
			"WHERE createdDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalQuotationInOneDay'] =  $data;
	}

	$sql = 	"SELECT COALESCE( SUM(quotation), 0) AS totalQuotationInOneWeek ".
			"FROM customerrequest ".
			"WHERE createdDate ".
			"BETWEEN DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) ".
			"AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalQuotationInOneWeek'] =  $data;
	}

	$sql = 	"SELECT COALESCE( SUM(quotation), 0) AS totalQuotationInOneMonth ".
			"FROM customerrequest ".
			"WHERE createdDate ".
			"BETWEEN DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) ".
			"AND LAST_DAY(NOW()) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalQuotationInOneMonth'] =  $data;
	}
	
	$sql = 	"SELECT COUNT(*) AS totalUserInOneDay ".
			"FROM user ".
			"WHERE userJoinDate BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ";
	
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalUserInOneDay'] =  $data;
	}

	$sql = 	"SELECT COUNT(*) AS totalUserInOneWeek ".
			"FROM user ".
			"WHERE userJoinDate ".
			"BETWEEN DATE_ADD(CURDATE(), INTERVAL 1-DAYOFWEEK(CURDATE()) DAY) ".
			"AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalUserInOneWeek'] =  $data;
	}

	$sql = 	"SELECT COUNT(*) AS totalUserInOneMonth ".
			"FROM user ".
			"WHERE userJoinDate ".
			"BETWEEN DATE_SUB(CURDATE(),INTERVAL (DAY(CURDATE())-1) DAY) ".
			"AND LAST_DAY(NOW()) ";

	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}

	$stmt->execute();
	$stmt->bind_result($data);
	while ($stmt->fetch()) {
		$result['totalUserInOneMonth'] =  $data;
	}
			
	echo json_encode($result);


	include 'closedb.php';

?>
