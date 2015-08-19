<?php
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
    $customerRequestId = $_POST["customerRequestId"];
    //$customerRequestId = 25;
	
    $sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId,".
			"cr.serviceProviderId, cr.quotation, u.name AS userName, s.serviceName,ps.name As projectStatusName ".
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