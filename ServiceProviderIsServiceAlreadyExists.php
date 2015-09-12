<?php
/*
 * 	21-08-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	include 'DBUtils.php';
	
	if(!$debug){
    	$userId = $_POST["userId"];
    	$serviceId = $_POST["serviceId"];
	}else{
		$userId = 1;
		$serviceId = 10;
	}
	
    $sql = 	"SELECT serviceProviderId ".
			"FROM serviceprovider ".
			"WHERE userId = ? ".
			"AND serviceId = ? LIMIT 1 ";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	

	$stmt->bind_param('ii', $userId, $serviceId);
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	
	if (mysqli_real_escape_string($con, $data["serviceProviderId"])==null) {
		//result no exist
		$result = (array('result' => false));
	} else {
		//result exist	
		$result = (array('result' => true));
	}

    echo json_encode($result);
	
    
    include 'closedb.php';
?>