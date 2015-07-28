<?php
	include 'config.php';
	include 'opendb.php';
	
    $userId = $_POST["userId"];
    //$userId = 3;
	
    $sql = 	"SELECT COUNT(*) AS Total ".
    		"FROM customerrequest ".
    		"WHERE userId=?";
    
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
	$stmt->bind_param('i', $userId);
	
	//Execute statement 
	$stmt->execute();
	
	/* Fetch result to array */
	$res = $stmt->get_result();
	$data = $res->fetch_array(MYSQLI_ASSOC);
	

    echo json_encode($data);
	
    
    include 'closedb.php';
?>