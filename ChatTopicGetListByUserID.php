<?php
/*
 * 20-10-2015 cm.choong : created
 * 23-10-2015 cm.choong : replace projectStatusId = 16 to isDelete
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
	$sql = 	"SELECT cr.userId AS userIdCust, ucus.name AS userNameCust, cr.customerRequestId, cr.description,  ".
			"cr.serviceProviderId, sp.userId AS userIdSPdr, usdpr.name AS userNameSPdr ".
			"FROM customerrequest cr ".
			"INNER JOIN user ucus ON cr.userId = ucus.userId ".
			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"INNER JOIN serviceprovider sp ON sp.serviceProviderId = cr.serviceProviderId ".
			"INNER JOIN user usdpr ON sp.userId = usdpr.userId ".
			"WHERE cr.userId = ? ".
			"AND cr.isDelete = 0 ".
			"UNION ".
			"SELECT cr.userId AS userIdCust, ucus.name AS userNameCust, cr.customerRequestId, cr.description, ".
			"cr.serviceProviderId, sp.userId AS userIdSPdr, usdpr.name AS userNameSPdr  ".
			"FROM serviceprovider sp ".
			"INNER JOIN user usdpr ON sp.userId = usdpr.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"INNER JOIN user ucus ON cr.userId = ucus.userId ".
			"INNER JOIN service s ON sp.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.projectStatusId >= 3 ".
			"AND cr.projectStatusId <> 15 ". //Project done
			"AND cr.isDelete = 0 ".
			"AND cr.serviceProviderId is not null ".
			"AND sp.userId = ? ";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('ii', $userId, $userId);
	
	//Execute statement 
	$stmt->execute();
    $service_providers = fetchArray($stmt);

    echo json_encode($service_providers);
    
	include 'closedb.php';
?>