<?php
	include 'config.php';
	include 'opendb.php';
	
    $userId = $_POST["userId"];
	//$userId = 1;
	
	// query the application data
	$sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId,".
			"u.name AS userName, s.serviceName,ps.name As projectStatusName ".
			"FROM customerrequest cr ".
			"INNER JOIN user u ON cr.userId = u.userId ".
			"INNER JOIN service s ON cr.serviceId = s.serviceId ".
			"INNER JOIN projectstatus ps ON cr.projectStatusId = ps.projectStatusId ".
			"WHERE cr.userId = ?";
	
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();
	
	// an array to save the application data
    $service_providers = array();
	
	/* Fetch result to array */
	$res = $stmt->get_result();
	while($row = $res->fetch_array(MYSQLI_ASSOC)) {
		array_push($service_providers, $row);
	}

    echo json_encode($service_providers);
    
	include 'closedb.php';
?>