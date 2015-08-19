<?php
/*
 * 	01-07-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
    	$userId = $_POST["userId"];
	}else{
		$userId = 9;
	}
	
    $sql = 	"SELECT Count(*) AS Total ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"WHERE cr.projectStatusId = 15 ".
			"AND cr.serviceProviderId is not null ".
			"AND sp.userId = ? LIMIT 1";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();
	
	$stmt->bind_result($data);
	
	/* fetch values */
	while ($stmt->fetch()) {
		$data = (array('Total' => $data));
	}
	
    echo json_encode($data);
	
    
    include 'closedb.php';
?>