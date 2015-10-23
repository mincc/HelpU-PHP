<?php
/*
 * 01-07-2015 cm.choong : created
 * 18-08-2015 cm.choong : Add avgRatedValue column
 * 01-10-2015 cm.choong : get lastOnline value
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
 		$serviceProviderId = $_POST["serviceProviderId"];
	}else{
		$serviceProviderId = 12;
	}
	
 	$sql = 	"SELECT sp.serviceProviderId, sp.userId, sp.serviceId, sp.phone, sp.email, sp.avgRatedValue, ".
 			"u.name AS userName, s.serviceName, u.lastOnline AS lastOnline ".
 			"FROM serviceprovider sp ".
 			"INNER JOIN user u ON sp.userId = u.userId ".
 			"INNER JOIN service s ON sp.serviceId = s.serviceId ".
 			"WHERE sp.serviceProviderId = ?";

	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $serviceProviderId);
	
	//Execute statement 
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	

    echo json_encode($data);
	
    
    include 'closedb.php';
?>