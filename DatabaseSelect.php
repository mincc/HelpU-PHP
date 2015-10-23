<?php
/*
 * 23-10-2015 cm.choong : created
 *
 */
	include 'config.php';
	include 'opendb.php';
	require_once 'DBUtils.php';
	include 'StringUtils.php';
	
	$stringUtil = new StringUtils();
	
	if(!$debug){
		$sql = $_POST["sql"];
	}else {
		$sql = "SELECT userId FROM user WHERE userId = 1";
	}
	
	$columnName = trim($stringUtil ->getStringBetween($sql, 'SELECT', 'FROM'), " ");
// 	echo 'Column Name : '. $columnName;
// 	echo '</br>';
		
	//Prepare statement
	$stmt = $con->prepare($sql);
	if($stmt === false) {
		trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $con->errno . ' ' . $con->error, E_USER_ERROR);}
	$stmt->execute();
	$stmt->store_result();
	$data = fetchRow($stmt);
	
	$result = array("result"=>$data[$columnName]);
	echo json_encode($result);

	include 'closedb.php';
?>