<?php
	include 'config.php';
	include 'opendb.php';
	
    $userId = $_POST["userId"];
    //$userId = 3;
	
	// query the application data
	$sql = 	"SELECT sp.serviceProviderId, sp.userId, sp.serviceId, sp.phone, sp.email, ".
			"u.name AS userName, s.serviceName ".
			"FROM ServiceProvider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN service s ON sp.serviceId = s.serviceId ".
			"WHERE sp.userId = ?";
	
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