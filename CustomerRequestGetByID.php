<?php
	include 'config.php';
	include 'opendb.php';
	
    $customerRequestId = $_POST["customerRequestId"];
    //$customerRequestId = 4;
	
    $sql = 	"SELECT cr.customerRequestId, cr.serviceId, cr.description, cr.userId, cr.projectStatusId,".
			"u.name AS userName, s.serviceName,ps.name As projectStatusName ".
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
	
	/* Fetch result to array */
	$res = $stmt->get_result();
	$data = $res->fetch_array(MYSQLI_ASSOC);
	

    echo json_encode($data);
	
    
    include 'closedb.php';
?>