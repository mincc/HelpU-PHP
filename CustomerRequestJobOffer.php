<?php
/*
 * 	01-07-2015 cm.choong : created
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
		$userId = 3;
	}
	
    $sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId, ".
			"cr.serviceProviderId, cr.quotation, cr.customerRatingValue, cr.serviceProviderRatingValue, cr.alreadyReadNotification, ".
    		"u.name AS userName, u.userEmail, u.userContact, s.serviceName,ps.name As projectStatusName ".
			"FROM customerrequest cr ".
			"INNER JOIN serviceprovider sp ON cr.serviceProviderId = sp.serviceProviderId ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN service s ON sp.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.projectStatusId = 4 ".
			"AND cr.serviceProviderId is not null ".
			"AND cr.isDelete = 0 ".
			"AND sp.userId = ? ";
    
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	

    echo json_encode($data);
	
    
    include 'closedb.php';
?>