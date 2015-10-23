<?php
/*
 * 	01-07-2015 cm.choong : created
 *	17-08-2015 cm.choong : filter by project state "Remove By View"
 *  09-09-2015 cm.choong : add customerRatingValue, serviceProviderRatingValue, alreadyReadNotification;
 *  12-09-2015 cm.choong : add userEmail and userContact
 *  20-10-2015 cm.choong : require_once 'DBUtils.php'
 *  23-10-2015 cm.choong : replace projectStatusId = 16 to isDelete
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
    	$userId = $_POST["userId"];
	}else{
		$userId = 1;
	}
	
	// query the application data
	$sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId,".
			"cr.serviceProviderId, cr.quotation, cr.customerRatingValue, cr.serviceProviderRatingValue, cr.alreadyReadNotification, ".
			"u.name AS userName, u.userEmail, u.userContact, s.serviceName,ps.name As projectStatusName ".
			"FROM customerrequest cr ".
			"INNER JOIN user u ON cr.userId = u.userId ".
			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.userId = ? ".
			"AND cr.isDelete = 0 "; 
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();
    $service_providers = fetchArray($stmt);

    echo json_encode($service_providers);
    
	include 'closedb.php';
?>