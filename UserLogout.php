<?php
/*
 * 01-10-2015 cm.choong : created
 */
	include 'config.php';
	include 'opendb.php';
	
	if(!$debug){
   	 	$userId = $_POST["userId"];
	}else{
	 	$userId = 1;
	}
	
	$sql=	"UPDATE user ".
			"SET logout = ?, ".
			"lastOnline = ? ".
			"WHERE userId = ? ";

	$currDateTime = date('Y-m-d G:i:s');
	$stmt = $con->prepare($sql);
	$stmt->bind_param('sss', $currDateTime, $currDateTime, $userId);
	$stmt->execute();
	
    include 'closedb.php';
?>