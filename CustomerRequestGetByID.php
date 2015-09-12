<?php
/*
 * 	01-09-2015 cm.choong : created
 *  09-09-2015 cm.choong : add customerRatingValue, serviceProviderRatingValue, alreadyReadNotification;
 *  12-09-2015 cm.choong : add userEmail and userContact
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug){
    	$customerRequestId = $_POST["customerRequestId"];
	}else {
    	$customerRequestId = 25;
	}
	
    $sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId, ".
			"cr.serviceProviderId, cr.quotation, cr.customerRatingValue, cr.serviceProviderRatingValue, cr.alreadyReadNotification, ".
    		"u.name AS userName, u.userEmail, u.userContact, s.serviceName,ps.name As projectStatusName ".
			"FROM customerrequest cr ".
			"INNER JOIN user u ON cr.userId = u.userId ".
			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.customerRequestId = ?";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $customerRequestId);
	
	//Execute statement 
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	
    echo json_encode($data);
	
    include 'closedb.php';
?>