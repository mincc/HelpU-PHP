<?php
/*
 * 	01-07-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug){
    	$userId = $_POST["userId"];
	}else{
		$userId = 3;
	}
	
    $sql = 	"SELECT cr.customerRequestId ".
			"FROM serviceprovider sp ".
			"INNER JOIN user u ON sp.userId = u.userId ".
			"INNER JOIN customerrequest cr ON sp.serviceProviderId = cr.serviceProviderId ".
			"WHERE ( cr.projectStatusId = 3 OR cr.projectStatusId = 8 ) ". //PICK (3) or Do down payment (8)
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
	$stmt->store_result();
	$data = fetchRow($stmt);
	
	if (mysqli_real_escape_string($con, $data["customerRequestId"])==null) {
		//result no exist
		$result = (array('result' => false));
	} else {
		//result exist
		//Update the project status where project status is PICK
		$sql = 	"UPDATE customerrequest ".
				"SET projectStatusId = 4 ".
				"WHERE customerrequestId = ?  ".
				"AND projectStatusId = 3  ";
		
		$stmt = $con->prepare($sql);
		if($stmt === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
		
		//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
		$stmt->bind_param('i', mysqli_real_escape_string($con, $data["customerRequestId"]));
		
		//Execute statement
		$stmt->execute();
		
		//Update the project status where project status is Do down payment
		$sql = 	"UPDATE customerrequest ".
				"SET projectStatusId = 9 ".
				"WHERE customerrequestId = ?  ".
				"AND projectStatusId = 8  ";
		
		$stmt = $con->prepare($sql);
		if($stmt === false) {
			trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);
		}
		
		//Bind parameters. Types: s = string, i = integer, d = double,  b = blob
		$stmt->bind_param('i', mysqli_real_escape_string($con, $data["customerRequestId"]));
	
		//Execute statement
		$stmt->execute();
		
		$result = (array('result' => true));
	}

    echo json_encode($result);
	
    
    include 'closedb.php';
?>