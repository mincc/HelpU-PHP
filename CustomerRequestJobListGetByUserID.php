<?php
/*
 * 	01-07-2015 cm.choong : created
 *	17-08-2015 cm.choong : filter by project state "Remove By View"
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug){
   		$userId = $_POST["userId"];
	}else{
    	$userId =3;
	}
	
    $sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId, ".
			"cr.serviceProviderId, cr.quotation, u.name AS userName, s.serviceName,ps.name As projectStatusName ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"INNER JOIN service s ON sp.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.projectStatusId >= 3 ".
			"AND cr.projectStatusId <> 15 ". //Project done
 			"AND cr.projectStatusId <> 16  ". //Remove from view";
			"AND cr.serviceProviderId is not null ".
			"AND sp.userId = ? ";
    
    
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