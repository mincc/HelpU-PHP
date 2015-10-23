<?php
/*
 * 16-10-2015 cm.choong : created
 * 20-10-2015 cm.choong : require_once 'DBUtils.php'
 * 21-10-2015 cm.choong : select distinct to prevent duplicate send
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	
    $sql =	"SELECT DISTINCT gcmRegId ".
			"FROM user ".
    		"WHERE gcmRegId != '' ";
    
	$stmt = $con->prepare($sql);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	
	//Execute statement 
	$stmt->execute();
	$stmt->store_result();
	$data = fetchArray($stmt);
	

//     echo json_encode($data);
	return $data;
    
    include 'closedb.php';
?>