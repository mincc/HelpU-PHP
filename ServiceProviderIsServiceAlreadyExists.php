<?php
/*
 * 	21-08-2015 cm.choong : created
 *  21-09-2015 cm.choong : Add isDelete filter
 *  20-10-2015 cm.choong : require_once 'DBUtils.php'
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
	if(!$debug){
    	$userId = $_POST["userId"];
    	$serviceId = $_POST["serviceId"];
	}else{
		$userId = 97;
		$serviceId = 1;
	}
	
    $sql = 	"SELECT serviceProviderId ".
			"FROM serviceprovider ".
			"WHERE userId = ? ".
			"AND serviceId = ? ".
    		"AND isDelete = 0 LIMIT 1 ";
    
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