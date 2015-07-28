<?php
	include 'config.php';
	include 'opendb.php';
	
 	$serviceProviderId = $_POST["serviceProviderId"];
    //$serviceProviderId = 4;
	
 	$sql = 	"SELECT sp.serviceProviderId, sp.userId, sp.serviceId, sp.phone, sp.email, ".
 			"u.name AS userName, s.serviceName ".
 			"FROM ServiceProvider sp ".
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
	
	/* Fetch result to array */
	$res = $stmt->get_result();
	$data = $res->fetch_array(MYSQLI_ASSOC);
	

    echo json_encode($data);
	
    
    include 'closedb.php';
?>